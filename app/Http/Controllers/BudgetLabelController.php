<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Requests\BudgetLabelFormRequest;
use App\Http\Controllers\Controller;
use App\Models\BudgetLabel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class BudgetLabelController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $budgetLabel = BudgetLabel::class;
            return view('admin.budgetLabel.index')
                ->with('budgetLabel',$budgetLabel);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(BudgetLabelFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $budgetLabel = new BudgetLabel;
            $budgetLabel->label = $input['label'];
            $budgetLabel->type = $input['type'];
            $budgetLabel->save();

            return Redirect::back()
                ->with('success','Budget label has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(BudgetLabelFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $budgetLabel = BudgetLabel::find($id);
            if($budgetLabel == NULL){
                return Redirect::back()
                ->with('danger','Invalid Request.');
            }
            $budgetLabel->label = $input['label'];
            $budgetLabel->type = $input['type'];
            $budgetLabel->save();

            return Redirect::back()
                ->with('success','Budget label has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $budgetLabel = BudgetLabel::find($id);

            if(is_null($budgetLabel)):
                    return redirect()->back()->with('danger','Invalid Request');
            endif;

            if($budgetLabel->countBudget() == 0):
                $budgetLabel->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related budget source or expense before deleting this label.');
            endif;

            return Redirect::back()
                ->with('success','Budget label has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
