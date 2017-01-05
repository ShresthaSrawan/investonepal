<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\File;
use App\Models\CurrencyType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyTypeFormRequest;

class CurrencyTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $currency = CurrencyType::all();
    		
            return view('admin.currencyType.index')
                ->with('currencyTypes', $currency);
        else:
            return redirect()->route('403');
        endif;
    }
    
    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            return view('admin.currencyType.create');
        else:
            return redirect()->route('403');
        endif;
	}

    public function store(CurrencyTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
        	$input = $request->all();
        	     
            $currency_type = new CurrencyType();
            $currency_type->country_name = $input['country_name'];
            $currency_type->name = $input['name'];
            $currency_type->unit = $input['unit'];
    	    if($request->hasFile('country_flag')){
    	        $currency_type->country_flag = File::upload($request->file('country_flag'),CurrencyType::$imageLocation);
    	     }
            $currency_type->save();

            return redirect()->route('admin.currencyType.index')
                ->with('success', 'Currency type has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
    
    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
    		$currencyType = CurrencyType::find($id);
    		
    		return view('admin.currencyType.edit')->with('currencyType', $currencyType);
        else:
            return redirect()->route('403');
        endif;
	}

    public function update(CurrencyTypeFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();
            $currency_type = CurrencyType::find($id);
            $currency_type->country_name = $input['country_name'];
            $currency_type->name = $input['name'];
            $currency_type->unit = $input['unit'];
    	    if($request->hasFile('country_flag')){
    	        $currency_type->country_flag = File::upload($request->file('country_flag'),CurrencyType::$imageLocation);
    	     }
            $currency_type->save();
            

            return redirect()->route('admin.currencyType.index')
                ->with('success','Currency type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $currency = CurrencyType::find($id);

            if(is_null($currency)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $currency->delete();

            return redirect()->back()
                ->with('success','Selected currency type has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
