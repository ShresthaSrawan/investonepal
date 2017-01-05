<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\NepseGroup;
use App\Models\NepseGroupGrade;
use App\Models\FiscalYear;
use App\Models\Company;
use App\Http\Requests\NepseGroupFormRequest;
use Illuminate\Support\Facades\DB;

class NepseGroupController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $nepseGroup = NepseGroup::with('nepseGroupGrade.company','fiscalYear')->get();
            return view('admin.nepseGroup.index')
                ->with('nepseGroup',$nepseGroup);
        else:
            return redirect()->route('403');
        endif;
    }

    public function upload(Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $file = $request->file('file');

            File::upload($file,NepseGroup::FILE_LOCATION,NepseGroup::FILE_NAME);

            $nepseGroup = new NepseGroup();
            $nepseGroup->setGroupFromExcel();

            return redirect()->route('nepseGroup.show')
                ->with('success','Nepse Group XLS has been uploaded successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();

            $company = Company::lists('name','id')->toArray();

            $data = NepseGroup::match();

            return view('admin.nepseGroup.show',compact('data','fiscalYear','company'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function db(NepseGroupFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $tran = DB::transaction(function () use($input,$request) {
                $fiscalYear = $request->get('fiscal_year_id');
                $companys = $request->get('company');
                $grades = $request->get('grade');

                $nepseGroup = NepseGroup::create(['fiscal_year_id'=>$fiscalYear]);

                foreach($companys as $index => $id)
                {
                    $data = ['nepse_group_id'=>$nepseGroup->id,'company_id'=>$id,'grade'=>$grades[$index]];
                    NepseGroupGrade::create($data);
                }
            });
            return redirect()->route('nepseGroup.index')
                ->with('success','Nepse group has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $nepseGroup = NepseGroup::find($id);

            if(is_null($nepseGroup)):
                return redirect()->route('nepseGroup.index')->with('danger','Invalid Request');
            endif;
            
            $nepseGroup->delete();

            return redirect()->route('nepseGroup.index')
                ->with('success','Nepse Group of fiscal year '.$nepseGroup->fiscalYear->label.' has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
