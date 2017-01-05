<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AMBullionFormRequest;
use App\Http\Controllers\Controller;
use App\Models\AssetsManagement\Bullion;
use App\Models\Bullion as BullionRecord;
use App\Models\BullionPrice;
use App\Transformer\BullionTransformer;

class BullionController extends Controller
{
	public function fetch(Request $request)
	{
		$lastDate = BullionRecord::selectRaw('id,max(date) as date')->toSql();

        $lastbullionPrice = \DB::table('bullion_price')
        ->join(\DB::raw('('.$lastDate.') as bullion'),'bullion.id','=','bullion_price.bullion_id')
        ->select('bullion.date','bullion_price.price','bullion_price.type_id')
        ->toSql();
        
        $bullion = Bullion::with(['sell'=>function($sell){
            $sell->select('id','buy_id','quantity','remarks','sell_date','sell_price');
        },'type'=>function($type){
            $type->select('id','name','unit');
        }])
        ->leftJoin(
            \DB::raw('('.$lastbullionPrice.') as last_price'),
            'last_price.type_id','=','am_bullion.type_id'
        )->select('last_price.date as last_date','last_price.price as last_price',
            'am_bullion.id','am_bullion.buy_date','am_bullion.owner_name',
            'am_bullion.quantity','am_bullion.type_id','am_bullion.total_amount'
        )->where('user_id','=',auth()->id());

        if($request->has('show_sold') && $request->get('show_sold') == 0){
            $bullionSoldQuantity = Bullion::where('am_bullion.user_id','=',auth()->id())
                ->leftJoin('am_bullion_sell as sell','sell.buy_id','=','am_bullion.id')
                ->selectRaw('am_bullion.id, am_bullion.quantity - ifnull(sum(sell.quantity), 0) as remaining_quantity')
                ->groupBy('am_bullion.id');

            $bullionOnlyRemaining = \DB::table(\DB::raw('('.$bullionSoldQuantity->toSql().') as bullion'))
                ->addBinding($bullion->getBindings())
                ->select('bullion.id')
                ->where('bullion.remaining_quantity','>',0)->lists('id');

            $bullion->whereIn('am_bullion.id',$bullionOnlyRemaining);
        }

        return (new BullionTransformer())->transform(\Datatables::of($bullion))->make(true);
	}
	
    public function old_fetch(Request $request)
    {
		$lastDate = BullionRecord::selectRaw('id,max(date) as date')->toSql();

        $lastbullionPrice = \DB::table('bullion_price')
        ->join(\DB::raw('('.$lastDate.') as bullion'),'bullion.id','=','bullion_price.bullion_id')
        ->select('bullion.date','bullion_price.price','bullion_price.type_id')
        ->toSql();
        
        $bullion = Bullion::with(['sell'=>function($sell){
            $sell->select('id','buy_id','quantity','remarks','sell_date','sell_price');
        },'type'=>function($type){
            $type->select('id','name','unit');
        }])
        ->leftJoin(
            \DB::raw('('.$lastbullionPrice.') as last_price'),
            'last_price.type_id','=','am_bullion.type_id'
        )->select('last_price.date as last_date','last_price.price as last_price',
            'am_bullion.id','am_bullion.buy_date','am_bullion.owner_name',
            'am_bullion.quantity','am_bullion.type_id','am_bullion.total_amount'
        )->where('user_id','=',auth()->id());

        return (new BullionTransformer())->transform(\Datatables::of($bullion))->make(true);
		
		
    }


    public function store(AMBullionFormRequest $request)
    {
        $error = true;
        $message = 'Sorry, could not add new bullion portfolio at the moment.';
        $bullion = new Bullion();
        $bullion->type_id = $request->type;
        $bullion->buy_date = ($request->has('buy_date') && $request->buy_date != '') ? $request->buy_date : date('Y-m-d');
        $bullion->owner_name = $request->owner_name;
        $bullion->total_amount = $request->total_amount;
        $bullion->quantity = $request->quantity;
        $bullion->user_id = \Auth::id();
        
        if($bullion->save()){
            $error = false;
            $message = 'Success, new bullion portfolio is created.';
        }

        if($request->ajax()){
            $response = ['error'=>$error,'message'=>$message];
        }else{
            $type = ($error) ? 'warning' : 'success';
            $response = redirect()->route('member.bullion.index')->with($type,$message);
        }

        return $response;
    }

    
    public function update(AMBullionFormRequest $request, $id)
    {
        $error = true;
        $message = 'Sorry, could not update bullion portfolio at the moment.';
        $bullion = Bullion::where('user_id',\Auth::id())->where('id',$id)->first();
        if(is_null($bullion)){
            $message = "Invalid Request";
            return ['error'=>$error,'message'=>$message];
        }

        $bullion->type_id = $request->type;
        $bullion->buy_date = ($request->has('buy_date') && $request->buy_date != '') ? $request->buy_date : date('Y-m-d');
        $bullion->owner_name = $request->owner_name;
        $bullion->total_amount = $request->total_amount;
        $bullion->quantity = $request->quantity;
        
        if($bullion->save()){
            $error = false;
            $message = 'Success, bullion portfolio has been updated.';
        }

        if($request->ajax()){
            $response = ['error'=>$error,'message'=>$message];
        }else{
            $type = ($error) ? 'warning' : 'success';
            $response = redirect()->route('member.bullion.index')->with($type,$message);
        }

        return $response;
    }

    public function destroy($id, Request $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];
        $bullion = Bullion::find($id);
        if(is_null($bullion)) return $response;

        if(!$bullion->delete()){
            $response['message'] = 'Sorry, could not delete bullion at the moment.';
            return $response;
        }

        $response['error'] = false;
        $response['message'] = 'Success, bullion record has been deleted.';

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.currency.index')
        ->with($response['error']  ? 'warning' : 'success',$response['message']);

    }
}
