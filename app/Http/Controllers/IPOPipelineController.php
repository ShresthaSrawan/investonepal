<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\IPOPipelineFormRequest;

use Auth;
use App\Models\IPOPipeline;
use App\Models\IssueManager;
use App\Models\Company;
use App\Models\FiscalYear;
use App\Models\AnnouncementSubType;
use App\Models\AnnouncementType;
use App\Models\IPOIssueManager;

class IPOPipelineController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $issueManager = IssueManager::lists('company', 'id');
            $company = Company::lists('name', 'id');
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label', 'id');
            $issueopenid = AnnouncementType::where('label','=','issue open')->first()['id'];
            $announcementSubtype =  AnnouncementSubType::where('announcement_type_id','=',$issueopenid)->lists('label','id')->toArray();

            return view('admin.ipoPipeline.create')
                ->with('company', $company)
                ->with('fiscalYear', $fiscalYear)
                ->with('issueManager', $issueManager)
                ->with('announcementSubtype', $announcementSubtype);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(IPOPipelineFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $ipo = new IPOPipeline();
            $ipo->company_id = $input['company_id'];
            $ipo->fiscal_year_id = $input['fiscal_year_id'];
            $ipo->announcement_subtype_id = $input['announcement_subtype_id'];
            $ipo->amount_of_securities = $input['amount_of_securities'];
            $ipo->amount_of_public_issue = $input['amount_of_public_issue'];
            $ipo->approval_date = $input['approval_date'];
            $ipo->application_date = $input['application_date'];
            $ipo->remarks = $input['remarks'];
            $ipo->save();

            foreach($input['issue_manager'] as $issueManagers)
            $ipo_issue = new IPOIssueManager();
            $ipo_issue->issue_manager_id = $issueManagers;
            $ipo_issue->ipo_pipeline_id = $ipo->id;
            $ipo_issue->save();

            $ipoPipelines = IPOPipeline::all();

            return redirect()->route('admin.ipoPipeline.index')
                ->with('success', 'Ipo Pipeline has been successfully created.')
                ->with('ipoPipelines', $ipoPipelines);
        else:
            return redirect()->route('403');
        endif;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $ipoPipelines = IPOPipeline::with('ipoIssueManager')->get();

            return view('admin.ipoPipeline.index')
                ->with('ipoPipelines', $ipoPipelines);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $ipoPipeline = IPOPipeline::with('ipoIssueManager')->find($id);
            $issueManager = IssueManager::lists('company', 'id');
            $company = Company::lists('name', 'id');
            $fiscalYear = FiscalYear::lists('label', 'id');

            $issueopenid = AnnouncementType::where('label','=','issue open')->first()['id'];
            $announcementSubtype =  AnnouncementSubType::where('announcement_type_id','=',$issueopenid)->lists('label','id')->toArray();


            return view('admin.ipoPipeline.edit')
              ->with('company', $company)
              ->with('ipoPipeline', $ipoPipeline)
              ->with('fiscalYear', $fiscalYear)
              ->with('issueManager', $issueManager)
              ->with('announcementSubtype', $announcementSubtype);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, IPOPipelineFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $ipo = IPOPipeline::find($id);
            $ipo->company_id = $input['company_id'];
            $ipo->fiscal_year_id = $input['fiscal_year_id'];
            $ipo->announcement_subtype_id = $input['announcement_subtype_id'];
            $ipo->amount_of_securities = $input['amount_of_securities'];
            $ipo->amount_of_public_issue = $input['amount_of_public_issue'];
            $ipo->approval_date = $input['approval_date'];
            $ipo->application_date = $input['application_date'];
            $ipo->remarks = $input['remarks'];
            $ipo->save();

            $issueManagers = $input['issue_manager'];
            IPOIssueManager::where('ipo_pipeline_id','=',$id)->delete();

            foreach($issueManagers as $issueManager)
            {
                $ipoPipeline = new IPOIssueManager();
                $ipoPipeline->ipo_pipeline_id = $ipo->id;
                $ipoPipeline->issue_manager_id = $issueManager;
                $ipoPipeline->save();
            }

            return redirect()->route('admin.ipoPipeline.index')
                ->with('success', 'IPO Pipeline has been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $ipoPipeline = IPOPipeline::find($id);
            if(is_null($ipoPipeline)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $ipoPipeline->delete();

              return redirect()->route('admin.ipoPipeline.index')
                  ->with('success', 'Ipo Pipeline has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
