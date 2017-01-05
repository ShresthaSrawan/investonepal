<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AMBullionSellFormRequest;
use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\BullionSell;
use App\Models\AssetsManagement\Bullion;

class BullionSellController extends Controller
{
    public function store(AMBullionSellFormRequest $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];
        $bullion = Bullion::with('sell')->where('user_id',\Auth::id())->find($request->buy_id);
        if(is_null($bullion)) return $response;


        $quantity = $bullion->quantity - $request->sell_quantity;
        foreach ($bullion->sell as $sell) {
            $quantity -= $sell->quantity;
        }

        if($quantity < 0){
            $response['message'] = 'Sorry, bullion quantity is less than sell quantity.';
            return $response;
        }
    
        $sell = new BullionSell();
        $sell->buy_id = $request->buy_id;
        $sell->sell_date = $request->has('sell_date') && $request->sell_date != '' ? $request->sell_date : date('Y-m-d');
        $sell->sell_price = $request->sell_price;
        $sell->quantity = $request->sell_quantity;
        $sell->remarks = $request->has('sell_remarks') && $request->sell_remarks != '' ? $request->sell_remarks : null;

        if(!$sell->save()){
            $response['message'] = 'Sorry, bullion sell record could not be created at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, bullion sell record has been created.';
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.bullion.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }

    public function update(AMBullionSellFormRequest $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];

        $bullion = Bullion::where('id',$request->bullion)->where('user_id',\Auth::id())->first();
        if(is_null($bullion)) return $response;

        $sell = BullionSell::where('id',$id)->where('buy_id',$bullion->id)->first();
        if(!$sell->delete()){
            $response['message'] = 'Sorry, could not delete sell record at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, bullion sell record has been deleted.'; 
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.bullion.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }
}
