<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\AssetsManagement\Property;
use App\Models\AssetsManagement\PropertySell;
use App\Http\Requests\AMPropertySellFormRequest;

class PropertySellController extends Controller
{
    public function store(AMPropertySellFormRequest $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];
        $property = Property::with('sell')->where('user_id',\Auth::id())->find($request->property_id);
        if(is_null($property)) return $response;

        $quantity = $property->quantity - $request->sell_quantity;
        foreach ($property->sell as $sell) {
            $quantity -= $sell->sell_quantity;
        }

        if($quantity < 0){
            $response['message'] = 'Sorry, property quantity is less than sell quantity.';
            return $response;
        }
    
        $sell = new PropertySell();
        $sell->property_id = $request->property_id;
        $sell->sell_date = $request->has('sell_date') && $request->sell_date != '' ? $request->sell_date : date('Y-m-d');
        $sell->sell_rate = $request->sell_rate;
        $sell->sell_quantity = $request->sell_quantity;
        $sell->remarks = $request->has('sell_remarks') && $request->sell_remarks != '' ? $request->sell_remarks : null;

        if(!$sell->save()){
            $response['message'] = 'Sorry, property sell record could not be created at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, property sell record has been created.';
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.property.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }

    public function update(AMPropertySellFormRequest $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];

        $property = Property::where('id',$request->property)->where('user_id',\Auth::id())->first();
        if(is_null($property)) return $response;

        $sell = PropertySell::where('id',$id)->where('property_id',$request->property)->first();
        if(!$sell->delete()){
            $response['message'] = 'Sorry, could not delete sell record at the moment.';
        }else{
            $response['error'] = false;
            $response['message'] = 'Success, property sell record has been deleted.'; 
        }

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.property.index')->with($response['error'] ? 'warning' : 'success', $response['message']);
    }
}
