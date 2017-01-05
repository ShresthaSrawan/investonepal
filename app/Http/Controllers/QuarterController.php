<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Quarter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class QuarterController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $quarters = Quarter::all();
        return view('admin.quarter.all')
            ->with('quarters',$quarters);
    }

    public function store()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, Quarter::$rules['store'], Quarter::$messages);
        if($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        $quarter = new Quarter();
        $quarter->label = $input['label'];
        $quarter->save();
        return Redirect::back()
            ->with('success','A new quarter has been created successfully.');
    }

    public function update($id)
    {
        $input = $this->request->all();
        $rules = ['label' => "required|min:3|unique:quarter,label,".$id];
        $validator = Validator::make($input, $rules, Quarter::$messages);
        if($validator->fails()){
            return Redirect::back()
            ->with('warning',$validator->errors()->first('label'));
        }

        $quarter = Quarter::find($id);
        if($quarter == NULL){
            return Redirect::back()
            ->with('danger','Invalid Request.');
        }

        $quarter->label = $input['label'];
        $quarter->save();
        return Redirect::back()
            ->with('success','A quarter has been updated successfully.');
    }

    public function destroy($id)
    {
        $quarter = Quarter::find($id);

        if(is_null($quarter)){
            return redirect()
                ->back()
                ->with('danger','Invalid Request.');
        }
        $quarter->delete();
        
        return redirect()->back()
            ->with('success','Selected quarter has been deleted successfully.');
    }
}
