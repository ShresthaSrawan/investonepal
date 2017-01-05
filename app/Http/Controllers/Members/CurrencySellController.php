<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AMCurrencySellFormRequest;
use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\Currency;
use App\Models\AssetsManagement\CurrencySell;

class CurrencySellController extends Controller
{
    public function store(AMCurrencySellFormRequest $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];
        $currency = Currency::with('sell')->where('user_id',\Auth::id())->find($request->buy_id);
        if(is_null($currency)) return $response;


        $quantity = $currency->quantity - $request->sell_quantity;
        foreach ($currency->sell as $sell) {
            $quantity -= $sell->quantity;
        }

        if($quantity < 0){
            $response['message'] = 'Sorry, currency quantity is less than sell quantity.';
            return $response;
        }
    
        $sell = new CurrencySell();
        $sell->buy_id = $request->buy_id;
        $sell->sell_date = $request->has('sell_date') && $request->sell_date != '' ? $request->sell_date : date('Y-m-d');
        $sell->sell_amount = $request->sell_amount;
        $sell->quantity = $request->sell_quantity;
        $sell->remarks = $request->has('sell_remarks') && $request->sell_remarks != '' ? $request->sell_remarks : null;

        if(!$sell->save()){
            $response['message'] = 'Sorry, currency sell record could not be created at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, currency sell record has been created.';
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.currency.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }

    public function update(AMCurrencySellFormRequest $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];

        $currency = Currency::where('id',$request->currency)->where('user_id',\Auth::id())->first();
        if(is_null($currency)) return $response;

        $sell = CurrencySell::where('id',$id)->where('buy_id',$currency->id)->first();
        if(!$sell->delete()){
            $response['message'] = 'Sorry, could not delete sell record at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, currency sell record has been deleted.'; 
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.currency.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }
}
