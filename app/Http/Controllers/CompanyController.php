<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyFormRequest;

use Auth;
use DB;
use App\File;
use App\Models\Company;
use App\Models\CompanyDetail;
use App\Models\Sector;
use App\Models\IssueManager;
use App\Models\BOD;

class CompanyController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $company = Company::with('details','sector')->get();
            return view('admin.company.index')
                ->with('companys',$company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function getCompanyDatatable(Request $request) // ajax request
    {
        $companyList = Company::with('details','sector')->get();
        return Datatables::of($companyList)->make(true);
    }

    public function create($name=null)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $allSectors = Sector::lists('label','id');
            $allIssueManagers = IssueManager::lists('company','id');

            $this->request->Session()->flash('info','The fields marked asterisk ( * ) are required.');

            $this->request->Session()->flash('name',$name);

            return view('admin.company.create')
                ->with('issueManagers', $allIssueManagers)
                ->with('sectors',$allSectors);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(CompanyFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            DB::beginTransaction();
            try{
                $input = $request->all();

                $companydetail = new CompanyDetail;

                $companydetail->address = $input['details']['address'];
                $companydetail->phone = $input['details']['phone'];
                $companydetail->email = $input['details']['email'];
                $companydetail->web = $input['details']['web'];
                $companydetail->operation_date = $input['details']['operation_date'];
                $companydetail->profile = $input['details']['profile'];
                $companydetail->issue_manager_id = $input['details']['issueManager']['id']!=0?$input['details']['issueManager']['id']:null;

                $companydetail->save();

                $company = new Company;
                if(isset($input['listed_shares']))
                    $company->listed_shares = $input['listed_shares'];
                if(isset($input['face_value']))
                    $company->face_value = $input['face_value'];
                if(isset($input['total_paid_up_value']))
                    $company->total_paid_up_value = $input['total_paid_up_value'];

                $company->sector_id = $input['sector']['id'];
                $company->detail_id = $companydetail->id;
                $company->quote = $input['quote'];
                $company->name = $input['name'];
                $company->issue_status = $input['issue_status'];
                if(isset($input['listed'])){
                    $company->listed = '1';    
                }else{
                    $company->listed = '0';    
                }

                //upload logo
                if($request->hasFile('logo')){
                    $company->logo = File::upload($request->file('logo'),Company::$imageLocation);
                }
                
                $company->save();

            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.company.create')->with('danger', $e->getMessage());
            }
            DB::commit();
                return redirect()
                    ->route('admin.company.index')
                    ->with('success','A new Company has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $company = Company::where('id','=',$id)->with('details.issueManager','sector')->first();
            $bod = BOD::where('company_id','=',$id)->get();
            return view('admin.company.show')
                ->with('company', $company)
                ->with('bod',$bod);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $company = Company::where('id','=',$id)->with('details.issueManager','sector')->first();
            $allSectors = Sector::lists('label','id');
            $allIssueManagers = IssueManager::lists('company','id');

            $this->request->Session()->flash('info','The fields marked asterisk ( * ) are required.');

            return view('admin.company.edit')
                ->with('issueManagers', $allIssueManagers)
                ->with('sectors',$allSectors)
                ->with('company',$company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(CompanyFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            DB::beginTransaction();
            try{
                $input = $request->all();

                $company = Company::find($id);
                $company->sector_id = $input['sector']['id'];
                $company->quote = $input['quote'];
                $company->name = $input['name'];
                $company->issue_status = $input['issue_status'];
                if(isset($input['listed_shares']))
                    $company->listed_shares = $input['listed_shares'];
                if(isset($input['face_value']))
                    $company->face_value = $input['face_value'];
                if(isset($input['total_paid_up_value']))
                    $company->total_paid_up_value = $input['total_paid_up_value'];
                if(isset($input['listed'])){
                    $company->listed = '1';    
                }else{
                    $company->listed = '0';    
                }

                //upload logo
                if($request->hasFile('logo')){
                    $company->removeImage();
                    $company->logo = File::upload($request->file('logo'),Company::$imageLocation);
                }

                $company->save();

                $companydetail = CompanyDetail::find($company->detail_id);
                $companydetail->address = $input['details']['address'];
                $companydetail->phone = $input['details']['phone'];
                $companydetail->email = $input['details']['email'];
                $companydetail->web = $input['details']['web'];
                $companydetail->operation_date = $input['details']['operation_date'];
                $companydetail->issue_manager_id = $input['details']['issueManager']['id']!=0?$input['details']['issueManager']['id']:null;
                $companydetail->profile = $input['details']['profile'];
                $companydetail->save();

            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.news.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();
                return redirect() 
                    ->route('admin.company.show',$id)
                    ->with('success','Company has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
                $company = Company::find($id);

                if(is_null($company)){
                    return redirect()->back()->with('danger','Invalid Request');
                }

            if($company->countNews() == 0 && $company->countFloorsheet() == 0 && $company->countAnnouncement() == 0 && $company->countInterviewArticle() == 0):
                $company->removeImage();
                $company->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related news, announcement, interview, article & floorsheet before deleting this company.');
            endif;

            return redirect()->route('admin.company.index')
            ->with('success','Selected company has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
