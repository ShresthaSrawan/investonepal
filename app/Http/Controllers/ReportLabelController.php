<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ReportLabel;
use App\Models\ReportLabelInsurance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ReportLabelFormRequest;


class ReportLabelController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($label=null,$type=null)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $reportLabel = ReportLabel::class;
            $reportLabelInsurance = ReportLabelInsurance::class;

            $this->request->Session()->flash('label',ucwords(str_replace('_', ' ', $label)));

            $this->request->Session()->flash('type',$type);

            return view('admin.reportLabel.index')->with('reportLabel',$reportLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(ReportLabelFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $type= $input['type'];

                $reportLabel = new ReportLabel;
                $reportLabel->label = $input['label'];
                $reportLabel->type = $input['type'];
                $reportLabel->save();

            return Redirect::back()
                ->with('success','Report label has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, ReportLabelFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $type= $input['type'];

            $reportLabel = ReportLabel::find($id);

            if($reportLabel == NULL):
                return Redirect::back()
                    ->with('danger','Invalid Request.');
            endif;

            $reportLabel->label = $input['label'];
            $reportLabel->save();

            return Redirect::back()
                ->with('success','Report label has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $input = $this->request->all();

            $type = $input['type'];

            $rl = ReportLabel::find($id);

            if(is_null($rl)):
                return redirect()->back()->with('danger','Invalid Request');
            endif;

            if
                (
                    $rl->countBS() == 0 
                    && $rl->countPL() == 0 
                    && $rl->countPI() == 0
                    && $rl->countIS() == 0 
                    && $rl->countCR() == 0
                ):
                $rl->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Report Label has been used in one or many reports.');
            endif;

            return Redirect::back()
                ->with('success','Report label has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
