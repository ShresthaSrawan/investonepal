<?php

namespace App\Http\Controllers;

use App\Models\BudgetLabel;
use App\Models\BudgetSubLabel;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BudgetSubLabelController extends Controller
{
    public function index($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $budgetLabel = BudgetLabel::find($id);
            if(is_null($budgetLabel)){
                return redirect()->back()->withMessage('Invalid Request');
            }
            return view('admin.budgetSubLabel.index')
                ->with('budgetLabel',$budgetLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store($id,Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $label = $request->get('label');
            $subLabel = new BudgetSubLabel();
            $subLabel->label = $label;
            $subLabel->budget_label_id = $id;
            $subLabel->save();

            return redirect()->back()->with('success','A new sub label has been added');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(Request $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();
            $rules = ['label' => "required"];

            $validator = Validator::make($input, $rules, BudgetSubLabel::$messages);            
            if($validator->fails()){
                return Redirect::back()
                ->with('warning',$validator->errors()->first('label'));
            }

            $subLabel = BudgetSubLabel::find($id);
            if(is_null($subLabel)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            $subLabel->label = $request->get('label');
            $subLabel->save();

            return redirect()->back()->with('success','Sub label has been updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $subLabel = BudgetSubLabel::find($id);

            if(is_null($subLabel)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            if($subLabel->countBudget() == 0):
                $subLabel->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related budget source or expense before deleting this label.');
            endif;

            return redirect()->back()->with('success','Sub label has been deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
