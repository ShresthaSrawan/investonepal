<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;

use Auth;
use Excel;
use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FiscalYear;
use App\Models\Company;
use App\Models\Quarter;
use App\Models\FinancialReport;
use App\Http\Requests\FinancialReportFormRequest;
use App\Http\Requests\ReportUploadRequest;
use App\Models\BalanceSheet;
use App\Models\BalanceSheetDump;
use App\Models\ReportLabel;

class FinancialReportController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $financialReport = FinancialReport::with('company.sector','fiscalYear','quarter')->get();
            return view('admin.financialReport.index')
                ->with('financialReport',$financialReport);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();
            $quarter = Quarter::lists('label','id');
            $company = Company::lists('name','id')->toArray();
            return view('admin.financialReport.create')
                ->with('fiscalYear',$fiscalYear)
                ->with('create', true)
                ->with('quarter',$quarter)
                ->with('company',$company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(FinancialReportFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $exists = FinancialReport::where('fiscal_year_id','=',$request->get('fiscal_year_id'))
                                    ->where('company_id','=',$request->get('company_id'))
                                    ->where('quarter_id','=',$request->get('quarter_id'))
                                    ->first();
            if(!is_null($exists)){
                return redirect()->back()->with('warning','Duplicate financial report found.');
            }
            $financialReport = new FinancialReport();
            $financialReport->company_id = $request->get('company_id');
            $financialReport->quarter_id = $request->get('quarter_id');
            $financialReport->fiscal_year_id = $request->get('fiscal_year_id');
            $financialReport->entry_by = $request->get('entry_by');
            $financialReport->entry_date = $request->get('entry_date');
            $financialReport->save();

            return redirect()->route('admin.financialReport.index')
                ->with('success','A new Financial Report has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $financialReport = FinancialReport::with('company','fiscalYear','quarter')->where('id','=',$id)->first();
            $view = '';
            if(strtolower($financialReport->company->sector->label) == strtolower('Insurance')
                || strtolower($financialReport->company->sector->label) == strtolower('Life Insurance')):
                    $view = view('admin.financialReport.showInsurance');
            else:
                    $view = view('admin.financialReport.showVarious');
            endif;
                return $view->with('financialReport',$financialReport);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $financialReport = FinancialReport::find($id);
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();
            $quarter = Quarter::lists('label','id');
            return view('admin.financialReport.edit')
                ->with('financialReport',$financialReport)
                ->with('fiscalYear',$fiscalYear)
                ->with('quarter',$quarter);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(FinancialReportFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $exists = FinancialReport::where('fiscal_year_id','=',$request->get('fiscal_year_id'))
                                    ->where('quarter_id','=',$request->get('quarter_id'))
                                    ->where('company_id','=',$request->get('company_id'))
                                    ->where('id','!=',$id)
                                    ->first();
            if(!is_null($exists)){
                return redirect()->back()->with('warning','Duplicate financial report found.');
            }

            $financialReport = FinancialReport::find($id);
            $financialReport->quarter_id = $request->get('quarter_id');
            $financialReport->fiscal_year_id = $request->get('fiscal_year_id');
            $financialReport->entry_by = $request->get('entry_by');
            $financialReport->entry_date = $request->get('entry_date');
            $financialReport->save();

            return redirect()->route('admin.financialReport.index')
                ->with('success','A financial Report has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $financialReport = FinancialReport::where('id',$id);

            if(is_null($financialReport)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $financialReport->delete();

            return redirect()->route('admin.financialReport.index')
                ->with('success','Selected financial report(s) have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function upload(Request $request,$id,$type)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $class = FinancialReport::$className[$type];//Extracting class name from model
            $file = $request->file('file');
            File::upload($file,FinancialReport::FILE_LOCATION,$class::FILE_NAME);

            $financialReport = new FinancialReport();
            $financialReport->setReportFromExcel($type);

            return redirect()->route('admin.financialReport.view',[$id,$type])
                ->with('success','Balance Sheet XLS has been uploaded successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function view($id,$type)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $dump = FinancialReport::$classDump[$type];//Extracting dump class name from model

            $report = $dump::all();

            $allLabels = ReportLabel::where('type',$type)->lists('label','id')->toArray();

            $data = FinancialReport::match($type);

            $financialReport = FinancialReport::find($id);

            return view('admin.reports.show',compact('data','allLabels','financialReport','type'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function db(Request $request,$id,$type)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $class = FinancialReport::$className[$type];//Extracting class name from model

            $labels = $request->get('label');
            $value = $request->get('value');

            foreach ($labels as $key => $labelid):
                $report = new $class;
                $report->label_id = $labelid;
                $report->value = $value[$key];
                $report->financial_report_id = $id;
                $report->save();
            endforeach;

            return redirect()->route('admin.financialReport.show', $id)
                ->with('success','Report has been created with excel successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function bonusDividend(Request $request)
    {
        $company_id = $request->get('company_id',null);

        if(is_null($company_id)) return "No company id found.";

        $bonusDividend = FinancialReport::with(['principalIndicators'=>function($q){
                                            $q->with('reportLabel');
                                            $q->whereHas('reportLabel',function($q2){
                                                $q2->whereRaw('label like "%cash dividend%" or label like "%dividend on share capital%"');
                                            });
                                        },'fiscalYear'])
                                        ->has('principalIndicators')
                                        ->where('company_id',$company_id)
                                        ->where('quarter_id','5')
                                        ->orderBy('fiscal_year_id','desc')
                                        ->limit(5)
                                        ->get();

        return Datatables::of(collect($bonusDividend))->make(true);
    }
}