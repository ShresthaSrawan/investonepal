<?php

namespace App\Http\Controllers;

use App\Http\Requests\EconomyFormRequest;
use App\Models\Economy;
use App\Models\EconomyLabel;
use App\Models\EconomyValue;
use App\Models\FiscalYear;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EconomyController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $economies = Economy::with('fiscalYear','values.label')->orderBy('fiscal_year_id','desc')->get();

            return view('admin.economy.index')
                ->with('economies',$economies);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $fiscalYears = FiscalYear::orderBy('label','desc')->lists('label','id')->toArray();
            $economyLabels = EconomyLabel::lists('name','id')->toArray();

            return view('admin.economy.create')
                ->with('fiscalYears',$fiscalYears)
                ->with('economyLabels',$economyLabels);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(EconomyFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $tran = DB::transaction(function () use($input,$request) {
                $fiscalYear = $request->get('fiscal_year_id');
                $labels = $request->get('label');
                $values = $request->get('value');
                $dates = $request->get('date');

                $economy = Economy::create(['fiscal_year_id'=>$fiscalYear]);

                foreach($labels as $index => $id)
                {
                    $data = ['economy_id'=>$economy->id,'label_id'=>$id,'value'=>$values[$index],'date'=>$dates[$index]];
                    EconomyValue::create($data);
                }
            });

            return redirect()->route('admin.economy.index')->with('success','Economy entry was successfully created');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $fiscalYears = FiscalYear::orderBy('label','desc')->lists('label','id')->toArray();
            $economyLabels = EconomyLabel::lists('name','id')->toArray();

            if(is_null($economy = Economy::with('values.label')->find($id))):
                return redirect()->route('admin.economy.index')->with('danger','Invalid Request');
            endif;

            return view('admin.economy.edit')
                ->with('fiscalYears',$fiscalYears)
                ->with('economyLabels',$economyLabels)
                ->with('economy',$economy);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(EconomyFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            if(is_null($economy = Economy::find($id))):
                return redirect()->route('admin.admin.economy.index')->with('danger','Invalid Request.');
            endif;

            DB::transaction(function () use($request,$economy) {
                $fiscalYear = $request->get('fiscal_year_id');
                $labels = $request->get('label');
                $values = $request->get('value');
                $dates = $request->get('date');

                $economy->fiscal_year_id = $fiscalYear;
                $economy->save();

                $labelIDs = array_values($request->get('label'));

                //update or create new economy value
                foreach($labels as $index => $id)
                {
                    $economyValue = $economy->values->where('label_id',(int) $id)->first();
                    if(is_null($economyValue)):
                        //value does not exists create new
                        $data = ['economy_id'=>$economy->id,'label_id'=>$id,'value'=>$values[$index],'date'=>$dates[$index]];
                        EconomyValue::create($data);
                    else:
                        //value does not exists create new
                        $economyValue->value = $values[$index];
                        $economyValue->date = $dates[$index];
                        $economyValue->save();
                    endif;
                }

                foreach($economy->values as $value):
                    if(!in_array($value->label_id,$labelIDs)) $value->delete();
                endforeach;
            });

            return redirect()->route('admin.economy.index')->with('success','Economy entry was successfully updated');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $economy = Economy::with('fiscalYear')->find($id);

            if(is_null($economy)):
                return redirect()->route('admin.economy.index')->with('danger','Invalid Request');
            endif;

            $economy->delete();

            return redirect()->route('admin.economy.index')->with('success','Economy of fiscal year '.$economy->fiscalYear->label.' has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
