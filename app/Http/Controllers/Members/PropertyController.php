<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\Property;
use App\Models\AssetsManagement\PropertySell;
use App\Http\Requests\AMPropertyFormRequest;

class PropertyController extends Controller
{
    public function fetch(Request $request)
    {
        $properties = \DB::table('am_property')
        ->select('id','asset_name','unit','owner_name as owner','buy_date','quantity','rate','market_rate','market_date')
        ->where('user_id',\Auth::id())->get();
        $idx = collect($properties)->lists('id')->toArray();

        $sell = collect(\DB::table('am_property_sell')->whereIn('property_id',$idx)
            ->select('id','property_id','sell_date','sell_rate','sell_quantity','remarks')->get())
        ->groupBy('property_id')->toArray();

        $prop = [];

        foreach ($properties as $property) {
            $property->quantityLeft = $property->quantity;
            $property->srate = $property->rate/*.'/'.$property->unit*/;
            $property->smarket_rate = $property->market_rate/*.'/'.$property->unit*/;
            $property->url = route('member.property.destroy',$property->id);
            $property->sellProfit = 0;
            $property->sellInvest = 0;
            $property->sellAmount = 0;
            $property->market_value = null;
            $property->change = null;
            $property->change_percent = null;
            $property->investment = 0;
            $property->sell = [];

            if(array_key_exists($property->id,$sell)){
                $sales = $sell[$property->id];
                foreach ($sales as $sold) {
                    $property->quantityLeft -= $sold->sell_quantity;

                    $sold->investment = $property->rate * $sold->sell_quantity;
                    $sold->ssell_rate = $sold->sell_rate/*.'/'.$property->unit*/;
                    $sold->value = $sold->sell_quantity * $sold->sell_rate;
                    $sold->change = $sold->value - $sold->investment;
                    $sold->change_percent = $sold->change*100/$sold->investment;
                    $sold->schange_percent = round($sold->change_percent,2);
                    $sold->url = route('member.property-sell.destroy',$sold->id);
                    $property->sellProfit += $sold->change;
                    $property->sellInvest += $sold->investment;
                    $property->sellAmount += $sold->value;

                    $property->sell[] = $sold;  
                }              
            }

            if($property->quantityLeft > 0){
                $property->investment = $property->quantityLeft * $property->rate;
                $property->market_value = is_null($property->market_rate) 
                    ? $property->rate * $property->quantityLeft
                    : $property->market_rate * $property->quantityLeft;

                $property->change = $property->market_value - $property->investment;
                $property->change_percent = $property->change*100/$property->investment;
            }

            if($property->quantityLeft > 0 || $request->show_sold == 1)  $prop[] = $property;

        }
        
        return \Datatables::of(collect($prop))->make(true);
    }

    public function store(AMPropertyFormRequest $request)
    {
        $error = true;

        $property = new Property();
        $property->asset_name = $request->asset_name;
        $property->unit = $request->unit;
        $property->buy_date = ($request->has('buy_date') && $request->buy_date != '') ? $request->buy_date : date('Y-m-d');
        $property->quantity = $request->quantity;
        $property->rate = $request->buy_rate;
        $property->owner_name = $request->has('owner_name') && $request->owner_name != '' 
                                ? $request->owner_name : null;
        $property->market_rate = $request->has('market_rate') && $request->market_rate != '' 
                            ?  $request->market_rate : null;
        $property->market_date = $request->has('market_date') && $request->market_date != '' 
                            ?  $request->market_date : null;
        $property->user_id = \Auth::id();

        if(! $property->save() ){
            $message = 'Sorry, property portfolio could not be created at the moment.';
        }else{
            $error = false;
            $message = 'Success, property prtofolio has been created.';
        }

        if($request->ajax()){
            return ['error'=>$error,'message'=>$message];
        }


        return redirect()->route('member.property.index')->with($error ? 'warning' : 'success',$message);
    }

    public function update(AMPropertyFormRequest $request, $id)
    {
        $error = true;

        $property = Property::where('id',$id)->where('user_id',\Auth::id())->first();
        if(is_null($property)) return ['error'=>$error,'message' => 'Invalid Request'];

        $property->asset_name = $request->asset_name;
        $property->unit = $request->unit;
        $property->buy_date = $request->buy_date;
        $property->quantity = $request->quantity;
        $property->rate = $request->buy_rate;
        $property->owner_name = $request->has('owner_name') && $request->owner_name != '' 
                                ? $request->owner_name : null;
        $property->market_rate = $request->has('market_rate') && $request->market_rate != '' 
                            ?  $request->market_rate : null;
        $property->market_date = $request->has('market_date') && $request->market_date != '' 
                            ?  $request->market_date : null;

        if(! $property->save() ){
            $message = 'Sorry, property portfolio could not be updated at the moment.';
        }else{
            $error = false;
            $message = 'Success, property prtofolio has been updated.';
        }

        if($request->ajax()){
            return ['error'=>$error,'message'=>$message];
        }


        return redirect()->route('member.property.index')->with($error ? 'warning' : 'success',$message);
    }

    public function destroy($id, Request $request)
    {

        $response = ['error'=>true,'message'=>'Invalid Request'];
        $property = Property::where('user_id',\Auth::id())->where('id',$id)->first();
        if(is_null($property)) return $response;

        if(!$property->delete()){
            $response['message'] = 'Sorry, could not delete property at the moment.';
            return $response;
        }

        $response['error'] = false;
        $response['message'] = 'Success, property record has been deleted.';

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.property.index')
        ->with($response['error']  ? 'warning' : 'success',$response['message']);
    }
}
