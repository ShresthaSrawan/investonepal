<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use Auth;
use Carbon\Carbon;
use yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsFormRequest;

use App\Models\NewsCategory;
use App\Models\News;
use App\Models\Tags;
use App\Models\Company;
use App\Models\ImageNews;
use App\Models\BullionType;
use App\Models\Event;
use App\Models\User;
use Exception;
use DB;

class NewsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            return view('admin.news.index');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getNewsDatatable(Request $request) // ajax request
    {
        $newsList = News::with('category')->get();
        return Datatables::of($newsList)->make(true);
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $company = Company::orderBy('name','asc')->lists('name', 'id')->toArray();
            $newsCategory = NewsCategory::lists('label', 'id');
            $user = User::lists('username', 'id');
            $bullion = BullionType::lists('name', 'id');
            $tags = Tags::lists('name','id')->toArray();

            return view('admin.news.create',compact('bullion','newsCategory','user','tags','company'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(NewsFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            DB::beginTransaction();
            try{
                $input = $request->all();
                $data = [
                    'user_id' => $input['user_id'],
                    'title' => $input['title'],
                    'slug' => str_slug(strtolower($input['title']).' '.date('YmdHis')),
                    'category_id' => $input['newsCategory'],
                    'event_date' => null,
                    'bullion_id' => null,
                    'company_id' => null,
                    'pub_date' => date_create($input['pub_date'])->format('Y-m-d H:i:s'),
                    'details' => $input['details'],
                    'source' => $input['source'],
                    'location' => $input['location'],
                ];

                if(array_key_exists('event', $input) && $request->has('event_date')) $data['event_date'] = date_create($input['event_date'])->format('Y-m-d H:i:s');
                if(array_key_exists('company_id', $input) && !$input['company_id'] == 0) $data['company_id'] = $input['company_id'];
                if(array_key_exists('bullion_id', $input)) $data['bullion_id'] = $input['bullion_id'];

                $news = News::create($data);

                if(!$news):
                    DB::rollback();
                    Throw (new Exception('News could not be created at the moment.'));
                endif;
                if($request->hasFile('featured_image')):
                    foreach ($request->file('featured_image') as $file):
                        $newsImages = new ImageNews();
                        $newsImages->featured_image = File::upload($file,ImageNews::$imageLocation);
                        $newsImages->news_id = $news->id;

                        if(!$newsImages->save()):
                            DB::rollback();
                            Throw (new Exception('Featured Image could not be uploaded at the moment.'));
                        endif;

                    endforeach;
                endif;

                $listOfTags = [];
                if(count($input['tags'])>0):
                    foreach($input['tags'] as $tag):
                        $tagExists = Tags::find($tag);
                        if($tagExists):
                            array_push($listOfTags,$tagExists->id);
                        else:
                            $t = new Tags();
                            $t->name = strtolower($tag);
                            $t->save();
                            array_push($listOfTags,$t->id);
                        endif;
                    endforeach;
                endif;

                $news->tags()->attach($listOfTags);
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.news.create')->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.news.show',$news->id)->with('success', 'News item has been added successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $news = News::with('imageNews')->where('news.id', '=', $id)->first();

            return view('admin.news.show')
                ->with('news',$news);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $news = News::with('company','category','user','tags')->where('id','=',$id)->first();
            $checked = $news->tags()->lists('id')->toArray();
            $bullion = BullionType::lists('name', 'id');
            $allNewsCategorys = NewsCategory::lists('label','id');
            $company = Company::lists('name', 'id')->toArray();
            $user = User::lists('username', 'id');
            $tags = Tags::lists('name','id');

            return view('admin.news.edit')
                ->with('newsCategory',$allNewsCategorys)
                ->with('bullion', $bullion)
                ->with('user', $user)
                ->with('news',$news)
                ->with('edit', true)
                ->with('company',$company)
                ->with('tags',$tags)
                ->with('checked',$checked);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, NewsFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            DB::beginTransaction();
            try{
                $input = $request->all();
                
                $news = News::find($id);

                if(isset($input['event'])):
                    if($request->has('event_date')):
                        $news->event_date = date_create($input['event_date'])->format('Y-m-d H:i:s');
                    endif;
                else:
                    $news->event_date = null;
                endif;
                   
                $news->location = $input['location'];
                $news->user_id = $input['user_id'];
                $news->category_id = $input['newsCategory'];
                $news->title = $input['title'];
                $news->pub_date = date_create($input['pub_date'])->format('Y-m-d H:i:s');
                $news->details = $input['details'];
                $news->source = $input['source'];
                if(array_key_exists('company_id', $input)):
                    if($input['company_id']==0):
                        $news->company_id = null;
                    else:
                        $news->company_id = $input['company_id'];
                    endif;
                endif;
                $news->bullion_id = array_key_exists('bullion_id', $input) ? $input['bullion_id'] : null;
                $news->save();

                if(!$news):
                    DB::rollback();
                    Throw (new Exception('News could not be updated at the moment.'));
                endif;
                
                if($request->hasFile('featured_image')):
                    foreach ($request->file('featured_image') as $file):
                        $newsImages = new ImageNews();
                        $newsImages->featured_image = File::upload($file,ImageNews::$imageLocation);
                        $newsImages->news_id = $news->id;
                        $newsImages->save();
                    endforeach;

                        if(!$newsImages->save()):
                            DB::rollback();
                            Throw (new Exception('Featured Image could not be uploaded at the moment.'));
                        endif;
                endif;

                $listOfTags = [];
                if(count($input['tags'])>0):
                    foreach($input['tags'] as $tag):
                        $tagExists = Tags::find($tag);
                        if($tagExists):
                            array_push($listOfTags,$tagExists->id);
                        else:
                            $t = new Tags();
                            $t->name = strtolower($tag);
                            $t->save();
                            array_push($listOfTags,$t->id);
                        endif;
                    endforeach;
                endif;

                $news->tags()->sync($listOfTags);

            }catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.news.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();
            return redirect()->route('admin.news.show', $id)
                ->with('success','News details have been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $news = News::find($id);
            $news->tags()->detach();

            if(is_null($news)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            foreach($news->imageNews as $fi){
                $fi->removeImage();
            }
            
            $news->delete();

            return redirect()->route('admin.news.index')
            ->with('success','Selected news item have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
