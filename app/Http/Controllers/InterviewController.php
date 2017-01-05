<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
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
use App\Models\IntervieweDetail;
use App\Models\ImageInterviewArticle;
use Exception;

class InterviewController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            return view('admin.interview.index');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getInterviewDatatable(Request $request) // ajax request
    {
        //Type 1=Article 0=Interview
        $interviewList = InterviewArticle::with('category')->where('type',0)->get();
        return Datatables::of($interviewList)->make(true);
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $news_category = NewsCategory::lists('label', 'id');
            $company = Company::lists('name', 'id')->toArray();
            $bullion = BullionType::lists('name', 'id')->toArray();
            $user = User::lists('username', 'id')->toArray();
            return view('admin.interview.create')
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
                $interview = new InterviewArticle();
                $interview->category_id = $input['newsCategory'];
                $interview->type = $input['type'];
                $interview->title = $input['title'];
                $interview->slug = str_slug(strtolower($input['title']).' '.date('YmdHis'));
                $interview->pub_date = date_create($input['pub_date'])->format('Y-m-d H:i:s');
                $interview->details = $input['details'];
                $interview->tags = $input['tags'];
                
                if(array_key_exists('company_id', $input)):
                    if($input['company_id']==0):
                        $interview->company_id = null;
                    else:
                        $interview->company_id = $input['company_id'];
                    endif;
                endif;

                $interview->bullion_type_id = array_key_exists('bullion_type_id', $input) ? $input['bullion_type_id'] : null;
                $interview->user_id = array_key_exists('user_id', $input) ? $input['user_id'] : null;
                $interview->save();

                //Interviewe Details
                $interviewe = new IntervieweDetail();
                $interviewe->interview_id = $interview->id;
                $interviewe->name = $input['intervieweDetail']['name'];
                $interviewe->organization = $input['intervieweDetail']['organization'];
                $interviewe->contact = $input['intervieweDetail']['contact'];
                $interviewe->address = $input['intervieweDetail']['address'];
                $interviewe->position = $input['intervieweDetail']['position'];
                if($request->hasFile('interviewe_photo')){
                    $interviewe->photo = File::upload($request->file('interviewe_photo'),IntervieweDetail::$imageLocation);
                }
                $interviewe->save();

                //Featured Image
               if($request->hasFile('featured_image'))
               {
                    foreach ($request->file('featured_image') as $file)
                    {
                        $iafi = new ImageInterviewArticle();
                        $iafi->interview_article_id = $interview->id;
                        $iafi->featured_image = File::upload($file,ImageInterviewArticle::$imageLocation);
                        $iafi->save();
                    }
                }
                
                //External details
                if($input['source']=='external'):
                    $ia = new IAExternalDetail();
                    $ia->interview_article_id = $interview->id;
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
                return redirect()->route('admin.interview.create')->with('danger', $e->getMessage());
            } 
            DB::commit();

            return redirect()->route('admin.interview.show',$interview->id)
                            ->with('success', 'Interview has been successfully created.');
        else:
            return redirect()->route('403');
        endif;
    }
    
    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
    		$interview = InterviewArticle::with('featuredImage','intervieweDetail')->find($id);

            return view('admin.interview.show')
                    ->with('interview' ,$interview);
        else:
            return redirect()->route('403');
        endif;
	}

    public function edit($id, Request $request)
    {
    	if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $interview = InterviewArticle::with('category','externalDetail','intervieweDetail')->find($id);
            $news_category = NewsCategory::lists('label', 'id')->toArray();
            $company = Company::lists('name', 'id')->toArray();
            $bullion = BullionType::lists('name','id')->toArray();
            $user = User::lists('username', 'id')->toArray();
            return view('admin.interview.edit')
              ->with('bullion',$bullion)
              ->with('company', $company)
              ->with('user', $user)
              ->with('interview', $interview)
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
                $interview = InterviewArticle::find($id);
                $interview->category_id = $input['newsCategory'];
                $interview->title = $input['title'];
                $interview->pub_date = date_create($input['pub_date'])->format('Y-m-d H:i:s');
                $interview->details = $input['details'];
                $interview->tags = $input['tags'];

                if(array_key_exists('company_id', $input)):
                    if($input['company_id']==0):
                        $interview->company_id = null;
                    else:
                        $interview->company_id = $input['company_id'];
                    endif;
                endif;

                $interview->bullion_type_id = array_key_exists('bullion_type_id', $input) ? $input['bullion_type_id'] : null;
                $interview->user_id = array_key_exists('user_id', $input) ? $input['user_id'] : null;
                $interview->save();

                //Interviewe Details
                $interviewe = IntervieweDetail::where('interview_id',$id)->first();
                $interviewe->interview_id = $interview->id;
                $interviewe->name = $input['intervieweDetail']['name'];
                $interviewe->organization = $input['intervieweDetail']['organization'];
                $interviewe->contact = $input['intervieweDetail']['contact'];
                $interviewe->address = $input['intervieweDetail']['address'];
                $interviewe->position = $input['intervieweDetail']['position'];

                if($request->hasFile('interviewe_photo')):
                    $interviewe->removeImage();
                    $interviewe->photo = File::upload($request->file('interviewe_photo'),IntervieweDetail::$imageLocation);
                endif;

                $interviewe->save();

                if($request->hasFile('featured_image')):
                    foreach ($request->file('featured_image') as $file):
                        $iafi = new ImageInterviewArticle();
                        $iafi->interview_article_id = $interview->id;
                        $iafi->featured_image = File::upload($file,ImageInterviewArticle::$imageLocation);
                        $iafi->save();
                    endforeach;
                endif;

                //External details
                if($input['source']=='external' && !is_null($interview->externalDetail)):
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
                elseif($input['source']=='internal' && !is_null($interview->externalDetail)):
                    $ia = IAExternalDetail::where('interview_article_id',$id)->first();
                    if(is_null($ia)):
                        return redirect()->back()->with('danger','Invalid Request');
                    else:
                        $ia->removeImage();
                        $ia->delete();
                    endif;
                elseif($input['source']=='external' && is_null($interview->externalDetail)):
                    $ia = new IAExternalDetail();
                    $ia->interview_article_id = $interview->id;
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
                return redirect()->route('admin.interview.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.interview.show',$id)
              ->with('success', 'Interview has been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $interview = InterviewArticle::with('featuredImage')->find($id);

            if(is_null($interview)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            foreach($interview->featuredImage as $fi){
                $fi->removeImage();
            }
            $interview->removeImage();

            if(!is_null($interview->externalDetail)){
                $interview->externalDetail->removeImage();
            }
            $interview->delete();


            return redirect()->route('admin.interview.index')
                ->with('success', 'Selected interview has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
