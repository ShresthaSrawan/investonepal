<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportLabel;
use App\Http\Requests\ReportFormRequest;
use App\Models\BalanceSheet;
use App\Models\BalanceSheetDump;

class BalanceSheetController extends Controller
{
    public function create($fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $financialReport = FinancialReport::find($fid);
            $reportLabel = ReportLabel::where('type','=','bs')->lists('label','id')->toArray();
            return view('admin.reports.balanceSheet.create')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $bs = BalanceSheet::where('financial_report_id','=',$fid)->first();

            if(!is_null($bs)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }

            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');

            foreach ($reportLabel as $key => $id):
                $balanceSheet = new BalanceSheet;
                $balanceSheet->label_id = $id;
                $balanceSheet->value = ($value[$key]!='') ? $value[$key] : null;
                $balanceSheet->financial_report_id = $fid;
                $balanceSheet->save();
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
            $financialReport = FinancialReport::where('id','=',$fid)->with('balanceSheet.reportLabel')->first();
            $reportLabel = ReportLabel::where('type','=','bs')->lists('label','id')->toArray();
            return view('admin.reports.balanceSheet.edit')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            //clear all previous balancesheet
            BalanceSheet::where('financial_report_id','=',$fid)->delete();
            
            $bs = BalanceSheet::where('financial_report_id','=',$fid)->first();

            if(!is_null($bs)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }
            
            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');


            foreach ($reportLabel as $key => $id):
                $balanceSheet = new BalanceSheet;
                $balanceSheet->label_id = $id;
                $balanceSheet->value = ($value[$key]!='') ? $value[$key] : null;
                $balanceSheet->financial_report_id = $fid;
                $balanceSheet->save();
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
            $bs = BalanceSheet::where('financial_report_id',$id);

            if(is_null($bs)):
                return redirect()->back()->with('warning','Invalid Request.');
            endif;

            $bs->delete();

            return redirect()->route('admin.financialReport.show', $id)
                ->with('success','Balance sheet has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
