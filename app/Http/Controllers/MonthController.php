<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Quarter;

use App\Http\Requests;
use App\Http\Requests\MonthFormRequest;
use App\Http\Controllers\Controller;

class MonthController extends Controller
{
    public function index($id)
    {
        $quarter = Quarter::find($id);
        if(is_null($quarter)){
            return redirect()->back()->with('danger','Invalid Quarter Request');
        }
        return view('admin.month.all')
            ->with('quarter',$quarter)
            ->with('quarters',Quarter::all());
    }

    public function store($id,MonthFormRequest $request)
    {
        $label = $request->get('label');
        $month = new Month();
        $month->label = $label;
        $month->quarter_id = $id;
        $month->save();

        return redirect()->back()->with('success','Month has been added to the quarter.');
    }

    public function update(MonthFormRequest $request,$quarter,$month)
    {
        $month = Month::find($month);
        if(is_null($month)){
            return redirect()->back()->with('danger','Invalid Request');
        }
        $month->label = $request->get('label');
        $month->save();

        return redirect()->back()
            ->with('success','Month label has been updated.');
    }

    public function destroy($qid,$mid,Request $request)
    {
        $month = Month::where('quarter_id','=',$qid)
                        ->where('id',$mid)
                        ->first();
        if(is_null($month)){
            return redirect()->back()->with('danger','Invalid Request');
        }

        $month->delete();

        return redirect()->back()
            ->with('success','Month has been deleted.');
    }
}
