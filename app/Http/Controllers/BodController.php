<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\BodFormRequest;
use App\Models\Company;
use App\Models\FiscalYear;
use App\Models\BodPost;
use App\Models\BOD;
use App\Models\BodFiscalYear;

class BodController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($cid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $company = Company::find($cid);
            $bod = BOD::where('company_id','=',$cid)->get();
            if(!empty($bod->toArray())):
                return view('admin.bod.index')
                    ->with('company',$company)
                    ->with('bods',$bod);
            else:
                return redirect()->route('admin.company.bod.create', $cid)
                    ->with('info','There are no existing board of directors.');
            endif;
        else:
            return redirect()->route('403');
        endif;
    }

    public function create($cid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $company = Company::find($cid);
            $fy = FiscalYear::lists('label','id')->toArray();
            $posts = BodPost::lists('label','id')->toArray();
            return view('admin.bod.create')->with('company',$company)
                                        ->with('fiscalYears',$fy)
                                        ->with('posts',$posts);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store($cid,BodFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $bod = new BOD();
            $bod->name = $input['name'];
            $bod->profile = $input['profile'];
            $bod->post_id = $input['post_id'];
            $bod->company_id = $cid;

            //upload logo
            if($request->hasFile('photo')){
                $bod->photo = File::upload($request->file('photo'),BOD::$imageLocation);
            }

            $bod->save();

            $fiscalYears = $input['fiscal_year'];
            foreach($fiscalYears as $fiscalYear)
            {
                $fy = new BodFiscalYear();
                $fy->bod_id = $bod->id;
                $fy->fiscal_year_id = $fiscalYear;
                $fy->save();
            }
            return redirect()->route('admin.company.bod.index', $cid)
                ->with('success',"Board of directors {$input['name']} has been created.");
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($cid,$bid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $bod = BOD::find($bid);
            $company = Company::find($cid);
            $fisYear = [];
            foreach($bod->bodFiscalYear->toArray() as $key=>$fy){
                $fisYear[$key] = $fy['fiscal_year_id'];
            }
            $fy = FiscalYear::lists('label','id')->toArray();
            $posts = BodPost::lists('label','id')->toArray();
            return view('admin.bod.edit')
                ->with('bod',$bod)
                ->with('posts', $posts)
                ->with('fiscalYears', $fy)
                ->with('fisYears', $fisYear)
                ->with('company',$company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($cid, $bid,BodFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $bod = BOD::find($bid);
            $bod->name = $input['name'];
            $bod->profile = $input['profile'];
            $bod->post_id = $input['post_id'];
            $bod->company_id = $cid;

            //upload logo
            if($request->hasFile('photo')){
                if(!empty($bod->photo)){
                    $bod->removeImage();
                }
                $bod->photo = File::upload($request->file('photo'),BOD::$imageLocation);
            }

            $bod->save();

            $fiscalYears = $input['fiscal_year'];
            BodFiscalYear::where('bod_id','=',$bid)->delete();
            foreach($fiscalYears as $fiscalYear)
            {
                $fy = new BodFiscalYear();
                $fy->bod_id = $bod->id;
                $fy->fiscal_year_id = $fiscalYear;
                $fy->save();
            }
            return redirect()
                ->route('admin.company.bod.index', $cid)
                ->with('success',"Board of directors {$input['name']} has been edited.");
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($cid, $bid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $company = Company::find($cid);
            $bod = BOD::find($bid);

            return view('admin.bod.show')
                ->with('company', $company)
                ->with('bod', $bod);
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($cid,$bid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $bod = Bod::where('company_id',$cid)
                        ->where('id',$bid)
                        ->first();

            if(is_null($bod)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            else{
                $bod->removeImage();
                $bod->delete();
            }
            

            return redirect()->back()
                ->with('success',"Board of director have been removed.");
        else:
            return redirect()->route('403');
        endif;
    }
}
