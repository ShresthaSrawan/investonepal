<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\File;
use App\Http\Requests;
use App\Http\Requests\BrokerageFirmFormRequest;
use App\Http\Controllers\Controller;
use App\Models\BrokerageFirm;

class BrokerageFirmController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $brokerageFirm = BrokerageFirm::all();
            return view('admin.brokerageFirm.index')
                ->with('brokerageFirms', $brokerageFirm);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            return view('admin.brokerageFirm.create');
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(BrokerageFirmFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();

            $brokerageFirm = new BrokerageFirm();
            $brokerageFirm->firm_name = $input['firm_name'];
            $brokerageFirm->code = $input['code'];
            $brokerageFirm->phone = $input['phone'];
            $brokerageFirm->address = $input['address'];
            $brokerageFirm->director_name = $input['director_name'];
            $brokerageFirm->mobile = $input['mobile'];
            
            //upload logo
            if($request->hasFile('photo')){
                $brokerageFirm->photo = File::upload($request->file('photo'),BrokerageFirm::$imageLocation);
            }

            $brokerageFirm->save();

            return redirect()->route('admin.brokerageFirm.index')
                ->with('message', 'Brokerage firm has been successfully created.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $brokerageFirm = BrokerageFirm::find($id);

            return view('admin.brokerageFirm.edit')
                ->with('brokerageFirm', $brokerageFirm);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(BrokerageFirmFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $brokerageFirm = BrokerageFirm::find($id);
            $brokerageFirm->firm_name = $input['firm_name'];
            $brokerageFirm->code = $input['code'];
            $brokerageFirm->phone = $input['phone'];
            $brokerageFirm->address = $input['address'];
            $brokerageFirm->director_name = $input['director_name'];
            $brokerageFirm->mobile = $input['mobile'];
            
            //upload logo
            if($request->hasFile('photo')){
                $brokerageFirm->removeImage();
                $brokerageFirm->photo = File::upload($request->file('photo'),BrokerageFirm::$imageLocation);
            }

            $brokerageFirm->save();

            return redirect()->route('admin.brokerageFirm.index')
                ->with('success', 'Brokerage firm has been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $brokerageFirm = BrokerageFirm::where('id',$id)
                                            ->first();

            if(is_null($brokerageFirm)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            else{
                $brokerageFirm->removeImage();
                $brokerageFirm->delete();
            }
            

            return redirect()->route('admin.brokerageFirm.index')
                ->with('success', 'Brokerage firm successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
