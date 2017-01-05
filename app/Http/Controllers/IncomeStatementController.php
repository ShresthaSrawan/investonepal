<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportLabel;
use App\Http\Requests\ReportFormRequest;
use App\Models\IncomeStatement;

class IncomeStatementController extends Controller
{
    public function create($fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $financialReport = FinancialReport::find($fid);
            $reportLabel = ReportLabel::where('type','=','is')->lists('label','id')->toArray();
            return view('admin.reports.incomeStatement.create')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $is = IncomeStatement::where('financial_report_id','=',$fid)->first();

            if(!is_null($is)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }

            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');

            foreach ($reportLabel as $key => $id):
                $incomeStatement = new IncomeStatement;
                $incomeStatement->label_id = $id;
                $incomeStatement->value = ($value[$key]!='') ? $value[$key] : null;
                $incomeStatement->financial_report_id = $fid;
                $incomeStatement->save();
            endforeach;

            return redirect()->route('admin.financialReport.show', $fid)
                ->with('success','Balance sheet has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $financialReport = FinancialReport::where('id','=',$fid)->with('incomeStatement.reportLabel')->first();
            $reportLabel = ReportLabel::where('type','=','is')->lists('label','id')->toArray();
            return view('admin.reports.incomeStatement.edit')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            //clear all previous incomeStatement
            IncomeStatement::where('financial_report_id','=',$fid)->delete();
            
            $is = IncomeStatement::where('financial_report_id','=',$fid)->first();

            if(!is_null($is)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }
            
            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');


            foreach ($reportLabel as $key => $id):
                $incomeStatement = new IncomeStatement;
                $incomeStatement->label_id = $id;
                $incomeStatement->value = ($value[$key]!='') ? $value[$key] : null;
                $incomeStatement->financial_report_id = $fid;
                $incomeStatement->save();
            endforeach;
            
            return redirect()->route('admin.financialReport.show', $fid)
                ->with('success','Balance sheet has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $is = IncomeStatement::where('financial_report_id',$id);

            if(is_null($is)):
                return redirect()->back()->with('warning','Invalid Request.');
            endif;

            $is->delete();

            return redirect()->route('admin.financialReport.show', $id)
                ->with('success','Income Statement has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}