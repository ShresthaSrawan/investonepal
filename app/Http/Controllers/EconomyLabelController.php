<?php

namespace App\Http\Controllers;

use App\Http\Requests\EconomyLabelFormRequest;
use App\Models\EconomyLabel;
use App\Models\EconomyValue;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EconomyLabelController extends Controller
{
    //TODO validation
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $labels = EconomyLabel::all();
            return view('admin.economy.label.index')->with('labels',$labels);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(EconomyLabelFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            EconomyLabel::create(['name'=>$request->get('name')]);
            return redirect()->route('admin.economyLabel.index')->with('success','Economy Label has been successfully created');
        else:
            return redirect()->route('403');
        endif;
    }


    public function update(EconomyLabelFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $label = EconomyLabel::find($id);
            if(is_null($label)) return redirect()->route('admin.economyLabel.index')->with('danger','Invalid Request');

            $label->name = $request->get('name');
            $label->save();

            return redirect()->route('admin.economyLabel.index')->with('success','Economy Label has been successfully updated');
        else:
            return redirect()->route('403');
        endif;
    }


    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $label = EconomyLabel::find($id);
            if(is_null($label)) return redirect()->route('admin.economyLabel.index')->with('danger','Invalid Request');

            $count = EconomyValue::where('label_id',$id)->count();

            if($count > 0) return redirect()->route('admin.economyLabel.index')->with('info',$label->name.' has '.$count.' number of economy, so, could not be deleted');

            $label->delete();
            return redirect()->route('admin.economyLabel.index')->with('success','Economy Label has been successfully deleted');
        else:
            return redirect()->route('403');
        endif;
    }
}
