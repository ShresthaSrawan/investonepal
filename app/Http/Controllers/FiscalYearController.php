<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FiscalYear;
use App\Http\Requests\FiscalYearFormRequest;
use App\Models\Budget;
use App\Models\BudgetLabel;
use App\Models\BudgetSubLabel;
use App\Models\BudgetSubValue;

class FiscalYearController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->initialize();
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $fiscal = FiscalYear::orderBy('label','desc')->get();

            return view('admin.fiscalYear.all')->with('fiscalYear', $fiscal);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(FiscalYearFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();
            $year = $input['fiscalYear'];

            $fiscal_year = new FiscalYear();
            $fiscal_year->label = $year;
            $fiscal_year->save();

            $year = FiscalYear::all();
            return redirect()->route('admin.fiscalYear.index')
                ->with('fiscalYear', $year)
                ->with('success', 'Fiscal Year has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        return redirect()->route('403');
    }
    
    public function destroy()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $input = $this->request->all();
            $year = $input['year'];
            FiscalYear::destroy($year);

            $year = FiscalYear::all();
            return redirect()->route('admin.fiscalYear.index')
                ->with('fiscalYear', $year)
                ->with('success','Selected fiscal year has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(FiscalYearFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $this->request->all();
            $year = FiscalYear::find($id);
            $year->label = $input['label'];
            $year->save();

            $year = FiscalYear::all();

            return redirect()->back()
                ->with('fiscalYear', $year)
                ->with('success','Fiscal year has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
