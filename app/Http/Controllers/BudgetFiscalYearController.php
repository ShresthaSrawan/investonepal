<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BudgetFiscalYear;
use App\Http\Requests\FiscalYearFormRequest;
use App\Models\Budget;
use App\Models\BudgetLabel;
use App\Models\BudgetSubLabel;
use App\Models\BudgetSubValue;

class BudgetFiscalYearController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->initialize();
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $fiscal = BudgetFiscalYear::orderBy('label','desc')->get();

            return view('admin.budgetFiscalYear.all')->with('fiscalYear', $fiscal);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(FiscalYearFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();
            $year = $input['fiscalYear'];

            $fiscal_year = new BudgetFiscalYear();
            $fiscal_year->label = $year;
            $fiscal_year->save();

            return redirect()->route('admin.budgetFiscalYear.index')
                ->with('success', 'Fiscal Year has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $fiscalYear = BudgetFiscalYear::with('budget.budgetLabel.subLabel.subValue')->find($id);
            $filter = $this->filter;
            return view('admin.budget.show',compact('filter','fiscalYear'));
        else:
            return redirect()->route('403');
        endif;
    }
    
    public function destroy()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $input = $this->request->all();
            $year = $input['year'];
            BudgetFiscalYear::destroy($year);

            return redirect()->route('admin.budgetFiscalYear.index')
                ->with('success','Selected fiscal year has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(FiscalYearFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $this->request->all();
            $year = BudgetFiscalYear::find($id);
            $year->label = $input['label'];
            $year->save();

            return redirect()->back()
                ->with('success','Fiscal year has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
