<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BullionType;
use App\Http\Requests\BullionTypeFormRequest;

class BullionTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $bullion = BullionType::all();

            return view('admin.bullionType.all')->with('bullionTypes', $bullion);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(BullionTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();
            $bullions = $input['name'];
            $unit = $input['unit'];

            $bullion = new BullionType();
            $bullion->name = $bullions;
            $bullion->unit = $unit;
            $bullion->save();

            $bullion = BullionType::all();
            return redirect()->route('admin.bullionType.index')->with('bullionTypes',$bullion)
                ->with('success', 'Bullion has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(BullionTypeFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();
            $bullion_type = BullionType::find($id);
            $bullion_type->name = $input['name'];
            $bullion_type->unit = $input['unit'];
            $bullion_type->save();

            $bullion = BullionType::all();

            return redirect()->back()
                ->with('bullionTypes', $bullion)
                ->with('success','Bullion type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $bullion = BullionType::find($id);

            if(is_null($bullion)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $bullion->delete();

            return redirect()->route('admin.bullionType.index')
                ->with('success','Selected bullion type has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
