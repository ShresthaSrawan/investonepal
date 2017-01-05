<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Http\Requests;
use App\Http\Requests\EnergyTypeFormRequest;
use App\Http\Controllers\Controller;
use App\Models\EnergyType;

class EnergyTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $energy = EnergyType::all();

            return view('admin.energyType.all')
                ->with('energyTypes', $energy);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(EnergyTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();
            $energy = $input['name'];
            $unit = $input['unit'];

            $energy_type = new EnergyType();
            $energy_type->name = $energy;
            $energy_type->unit = $unit;
            $energy_type->save();

            return redirect()->back()
                ->with('success', 'Energy type has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(EnergyTypeFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();
            $energy_type = EnergyType::find($id);
            $energy_type->name = $input['name'];
            $energy_type->unit = $input['unit'];
            $energy_type->save();

            return redirect()->back()
                ->with('success','Energy type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $energy = EnergyType::find($id);

            if(is_null($energy)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $energy->delete();

            return redirect()->back()
                ->with('success','Selected energy type has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
