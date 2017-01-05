<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\IPOResult;
use App\Http\Requests\IPOResultFormRequest;
use Excel;
use App\File;
use yajra\Datatables\Datatables;

class IPOResultController extends Controller
{
	public function __construct()
	{
		set_time_limit(0);
        ini_set('memory_limit','256M');
	}

    public function getIpoResult()
    {
        $ipoResult = IPOResult::select(DB::raw('count(application_no) as numberofapplicants,name,date,quote,company_id'))->groupBy('company_id','date')->leftJoin('company','company.id','=','ipo_result.company_id')->get();
        return Datatables::of($ipoResult)->make(true);
    }

    public function searchIpoResult(Request $request)
    {
        $company_id = $request->get('company_id',null);

        $first_name = $request->get('first_name',null);

        $last_name = $request->get('last_name',null);

        $application_no = $request->get('application_no',null);

        if(!($company_id=="" || is_null($company_id))):

            $ipoResult = IPOResult::where('company_id',$company_id)
                                    ->where(function ($q) use ($request,$application_no,$first_name,$last_name){
                                        if($request->has('application_no'))
                                            $q->where('application_no',$application_no);
                                        if($request->has('first_name'))
                                            $q->orWhere('first_name','LIKE',"$first_name%");
                                        if($request->has('last_name'))
                                            $q->orWhere('last_name','LIKE',"$last_name%");
                                    })->take(400);

        else:
            $ipoResult = collect([]);
        endif;

        return Datatables::of($ipoResult)->make(true);
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            return view('admin.ipoResult.index');
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $company = Company::lists('name', 'id');        
            return view('admin.ipoResult.create')->with('company', $company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
    	
            $input = $request->all();
            
            $name = File::upload($request->file('excel'),IPOResult::FILE_LOCATION,IPOResult::FILE_NAME);
            
            $this->allData = array();
            $flag = true;
            
            DB::beginTransaction();
            Excel::filter('chunk')->load(IPOResult::FILE_LOCATION.$name)->chunk(2000, function($results) use ($input)
    	    {
    	    	$this->allData = array();

    	        foreach($results as $key=>$ipo)
    	        {
                    if($ipo['application_no']!=''){
        	        	array_push($this->allData,array(
        					'company_id'=>$input['company_id']?$input['company_id']:'',
        					'code'=>$ipo['code']?$ipo['code']:'',
        					'application_no'=>$ipo['application_no']?$ipo['application_no']:'',
        					'first_name'=>$ipo['first_name']?$ipo['first_name']:'',
        					'last_name'=>$ipo['last_name']?$ipo['last_name']:'',
        					'applied_kitta'=>$ipo['applied_kitta']?$ipo['applied_kitta']:'',
        					'alloted_kitta'=>$ipo['alloted_kitta']?$ipo['alloted_kitta']:'',
        					'date'=>$input['date']?$input['date']:date('Y-m-d'),
        					'created_at'=>date('Y-m-d H:i:s'),
        					'updated_at'=>date('Y-m-d H:i:s')
        				));
                    }
    	        }
    	        if(!$flag = IPOResult::insert($this->allData)) break;
    	          
    	    });
            DB::commit();
    		echo ceil(memory_get_peak_usage() / 1024 / 1024);
            if($flag)
    		return redirect()->route('admin.ipo-result.index')->with('success', 'IPO Result has been successfully added.');
    		return redirect()->route('admin.ipo-result.index')->with('warning', 'Error adding IPO Result');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id,$date)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $result = IPOResult::where('company_id',$id)->where('date',$date)->first();
            if($result==null):
                return redirect()->back()->with('danger','Invalid request.');
            endif;
            $deleted = IPOResult::where('company_id',$id)->where('date',$date)->delete();

            if($deleted):
                return redirect()->back()->with('success','IPO Result has been deleted successfully.');
            else:
                return redirect()->back()->with('warning','Something went wrong.');
            endif;
        else:
            return redirect()->route('403');
        endif;
    }
}
