<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportLabel;
use App\Http\Requests\ReportFormRequest;
use App\Models\ProfitLoss;

class ProfitLossController extends Controller
{
    public function create($fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $financialReport = FinancialReport::find($fid);
            $reportLabel = ReportLabel::where('type','=','pl')->lists('label','id')->toArray();
            return view('admin.reports.profitLoss.create')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $pl = ProfitLoss::where('financial_report_id','=',$fid)->first();

            if(!is_null($pl)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }

            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');

            foreach ($reportLabel as $key => $id):
                $profitLoss = new ProfitLoss;
                $profitLoss->label_id = $id;
                $profitLoss->value = ($value[$key]!='') ? $value[$key] : null;
                $profitLoss->financial_report_id = $fid;
                $profitLoss->save();
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
            $financialReport = FinancialReport::where('id','=',$fid)->with('profitLoss.reportLabel')->first();
            $reportLabel = ReportLabel::where('type','=','pl')->lists('label','id')->toArray();
            return view('admin.reports.profitLoss.edit')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            //clear all previous profitLoss
            ProfitLoss::where('financial_report_id','=',$fid)->delete();
            
            $pl = ProfitLoss::where('financial_report_id','=',$fid)->first();

            if(!is_null($pl)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }
            
            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');


            foreach ($reportLabel as $key => $id):
                $profitLoss = new ProfitLoss;
                $profitLoss->label_id = $id;
                $profitLoss->value = ($value[$key]!='') ? $value[$key] : null;
                $profitLoss->financial_report_id = $fid;
                $profitLoss->save();
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
            $pl = ProfitLoss::where('financial_report_id',$id);

            if(is_null($pl)):
                return redirect()->back()->with('warning','Invalid Request.');
            endif;

            $pl->delete();

            return redirect()->route('admin.financialReport.show', $id)
                ->with('success','Profit Loss has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}