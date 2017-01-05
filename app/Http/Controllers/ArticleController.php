<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\Http\Requests;
use yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\InterviewArticleFormRequest;

use App\Models\NewsCategory;
use App\Models\InterviewArticle;
use App\Models\Company;
use App\Models\BullionType;
use App\Models\User;
use App\Models\IAExternalDetail;
use App\Models\ImageInterviewArticle;
use Exception;
use DB;
use Auth;

class ArticleController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            return view('admin.article.index');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getArticleDatatable(Request $request) // ajax request
    {
        //Type 1=Article 0=Interview
        $articleList = InterviewArticle::with('category')->where('type',1);
        return Datatables::of($articleList)->make(true);
    }

    public function create()
    {   
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $news_category = NewsCategory::lists('label', 'id');
            $company = Company::lists('name', 'id')->toArray();
            $bullion = BullionType::lists('name', 'id')->toArray();
            $user = User::lists('username', 'id')->toArray();
            return view('admin.article.create')
              ->with('bullion', $bullion)
              ->with('user', $user)
              ->with('company', $company)
              ->with('newsCategory', $news_category);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(InterviewArticleFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $input = $request->all();
            
            DB::beginTransaction();
            try{
                $article = new InterviewArticle();
                $article->category_id = $input['newsCategory'];
                $article->type = $input['type'];
                $article->title = $input['title'];
                $article->slug = str_slug(strtolower($input['title']).' '.date('YmdHis'));
                $article->pub_date = date_create($input['pub_date'])->format('Y-m-d H:i:s');
                $article->details = $input['details'];
                $article->tags = $input['tags'];

                if(array_key_exists('company_id', $input)):
                    if($input['company_id']==0):
                        $article->company_id = null;
                    else:
                        $article->company_id = $input['company_id'];
                    endif;
                endif;

                $article->bullion_type_id = array_key_exists('bullion_type_id', $input) ? $input['bullion_type_id'] : null;
                $article->user_id = array_key_exists('user_id', $input) ? $input['user_id'] : null;
                $article->save();
                
                //Featured Image
               if($request->hasFile('featured_image'))
               {
                    foreach ($request->file('featured_image') as $file)
                    {
                        $iafi = new ImageInterviewArticle();
                        $iafi->interview_article_id = $article->id;
                        $iafi->featured_image = File::upload($file,ImageInterviewArticle::$imageLocation);
                        $iafi->save();
                    }
                }
                
                //External details
                if($input['source']=='external'):
                    $ia = new IAExternalDetail();
                    $ia->interview_article_id = $article->id;
                    $ia->name = $input['externalDetail']['name'];
                    $ia->organization = $input['externalDetail']['organization'];
                    $ia->position = $input['externalDetail']['position'];
                    $ia->address = $input['externalDetail']['address'];
                    $ia->contact = $input['externalDetail']['contact'];
                    if($request->hasFile('photo'))
                    {
                        $ia->photo = File::upload($request->file('photo'),IAExternalDetail::$imageLocation);
                    }
                    $ia->save();
                endif;
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.article.create')->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.article.show',$article->id)
                            ->with('success', 'Article has been successfully created.');
        else:
            return redirect()->route('403');
        endif;
    }
    
    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $article = InterviewArticle::find($id);

            return view('admin.article.show')
                    ->with('article' ,$article);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id, Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):   
            $article = InterviewArticle::with('category','externalDetail')->find($id);
            $news_category = NewsCategory::lists('label', 'id')->toArray();
            $company = Company::lists('name', 'id')->toArray();
            $bullion = BullionType::lists('name','id')->toArray();
            $user = User::lists('username', 'id')->toArray();
            return view('admin.article.edit')
              ->with('bullion',$bullion)
              ->with('company', $company)
              ->with('article', $article)
              ->with('item', $item)
              ->with('edit', true)
              ->with('newsCategory', $news_category);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, InterviewArticleFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $input = $request->all();

            DB::beginTransaction();
            try{
                $article = InterviewArticle::find($id);
                $article->category_id = $input['newsCategory'];
                $article->title = $input['title'];
                $article->pub_date = date_create($input['pub_date'])->format('Y-m-d H:i:s');
                $article->details = $input['details'];
                $article->tags = $input['tags'];
                $article->status = array_key_exists('status', $input) ? $input['status'] : 0;

                if(array_key_exists('company_id', $input)):
                    if($input['company_id']==0):
                        $article->company_id = null;
                    else:
                        $article->company_id = $input['company_id'];
                    endif;
                endif;

                $article->bullion_type_id = array_key_exists('bullion_type_id', $input) ? $input['bullion_type_id'] : null;
                $article->user_id = array_key_exists('user_id', $input) ? $input['user_id'] : null;
                $article->save();

                if($request->hasFile('featured_image'))
                {
                    foreach ($request->file('featured_image') as $file)
                    {
                        $iafi = new ImageInterviewArticle();
                        $iafi->interview_article_id = $article->id;
                        $iafi->featured_image = File::upload($file,ImageInterviewArticle::$imageLocation);
                        $iafi->save();
                    }
                }

                //External details
                if($input['source']=='external' && !is_null($article->externalDetail)):
                    $ia = IAExternalDetail::where('interview_article_id',$id)->first();
                    $ia->name = $input['externalDetail']['name'];
                    $ia->organization = $input['externalDetail']['organization'];
                    $ia->position = $input['externalDetail']['position'];
                    $ia->address = $input['externalDetail']['address'];
                    $ia->contact = $input['externalDetail']['contact'];
                    if($request->hasFile('photo'))
                    {
                        $ia->removeImage();
                        $ia->photo = File::upload($request->file('photo'),IAExternalDetail::$imageLocation);
                    }
                    $ia->save();
                elseif($input['source']=='internal' && !is_null($article->externalDetail)):
                    $ia = IAExternalDetail::where('interview_article_id',$id)->first();
                    if(is_null($ia)):
                        return redirect()->back()->with('danger','Invalid Request');
                    else:
                        $ia->removeImage();
                        $ia->delete();
                    endif;
                elseif($input['source']=='external' && is_null($article->externalDetail)):
                    $ia = new IAExternalDetail();
                    $ia->interview_article_id = $article->id;
                    $ia->name = $input['externalDetail']['name'];
                    $ia->organization = $input['externalDetail']['organization'];
                    $ia->position = $input['externalDetail']['position'];
                    $ia->address = $input['externalDetail']['address'];
                    $ia->contact = $input['externalDetail']['contact'];
                    if($request->hasFile('photo'))
                    {
                        $ia->photo = File::upload($request->file('photo'),IAExternalDetail::$imageLocation);
                    }
                    $ia->save();
                endif;
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.article.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.article.show',$id)
              ->with('success', 'Article has been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $article = InterviewArticle::with('featuredImage')->find($id);

            if(is_null($article)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            foreach($article->featuredImage as $fi){
                $fi->removeImage();
            }

            if(!is_null($article->externalDetail)){
                $article->externalDetail->removeImage();
            }
            $article->delete();

            return redirect()->route('admin.article.index')
                ->with('success', 'Selected article has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}