<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportLabel;
use App\Http\Requests\ReportFormRequest;
use App\Models\ConsolidateRevenue;

class ConsolidateRevenueController extends Controller
{
    public function create($fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $financialReport = FinancialReport::find($fid);
            $reportLabel = ReportLabel::where('type','=','cr')->lists('label','id')->toArray();
            return view('admin.reports.consolidateRevenue.create')
                ->with('financialReport',$financialReport)
                ->with('reportLabel', $reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(ReportFormRequest $request, $fid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $cr = ConsolidateRevenue::where('financial_report_id','=',$fid)->first();

            if(!is_null($cr)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }

            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');

            foreach ($reportLabel as $key => $id):
                $consolidateRevenue = new ConsolidateRevenue;
                $consolidateRevenue->label_id = $id;
                $consolidateRevenue->value = ($value[$key]!='') ? $value[$key] : null;
                $consolidateRevenue->financial_report_id = $fid;
                $consolidateRevenue->save();
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
            $financialReport = FinancialReport::where('id','=',$fid)->with('consolidateRevenue.reportLabel')->first();
            $reportLabel = ReportLabel::where('type','=','cr')->lists('label','id')->toArray();
            return view('admin.reports.consolidateRevenue.edit')
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
            ConsolidateRevenue::where('financial_report_id','=',$fid)->delete();
            
            $cr = ConsolidateRevenue::where('financial_report_id','=',$fid)->first();

            if(!is_null($cr)){
                return redirect()->route('admin.financialReport.show', $fid)
                ->with('warning','Dublicate balance sheet found.');
            }
            
            $reportLabel = $request->get('reportLabel');
            $value = $request->get('value');


            foreach ($reportLabel as $key => $id):
                $consolidateRevenue = new ConsolidateRevenue;
                $consolidateRevenue->label_id = $id;
                $consolidateRevenue->value = ($value[$key]!='') ? $value[$key] : null;
                $consolidateRevenue->financial_report_id = $fid;
                $consolidateRevenue->save();
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
            $cr = ConsolidateRevenue::where('financial_report_id',$id);

            if(is_null($cr)):
                return redirect()->back()->with('warning','Invalid Request.');
            endif;

            $cr->delete();

            return redirect()->route('admin.financialReport.show', $id)
                ->with('success','Consolidate Revenue has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}