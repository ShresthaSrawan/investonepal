<?php

namespace App\Http\Controllers\Members;

use DB;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformer\CurrencyTransformer;
use App\Models\AssetsManagement\Currency;
use App\Http\Requests\AMCurrencyFormRequest;


class CurrencyController extends Controller
{
	public function fetch(Request $request)
    {
        $maxDatePerType = \DB::table('currency')
            ->join('currency_rate as rate', 'rate.currency_id','=','currency.id')
            ->join('currency_type as type', 'type.id','=','rate.type_id')
            ->selectRaw('type_id, max(date) as date, type.name as currency_name, type.unit as currency_unit')
            ->groupBy('type_id')
            ->toSql();

        $lastCurrencyPrice = \DB::table('currency_rate as rate')
            ->join('currency','currency.id','=','rate.currency_id')
            ->join(\DB::raw('('.$maxDatePerType.') as last_date'), function($query){
                $query->on('last_date.date','=','currency.date')->on('last_date.type_id','=','rate.type_id');
            })
            ->select('last_date.*','currency.id','rate.buy', 'rate.sell')
            ->toSql();

        $currencySellQuantity = \DB::table('am_currency_sell as sell')
            ->selectRaw('sell.buy_id,sum(quantity) as quantity')->groupBy('buy_id')->toSql();

        $currency = Currency::with('sell')
            ->leftJoin(
                \DB::raw('('.$lastCurrencyPrice.') as last_price'),
                'last_price.type_id','=','am_currency.type_id'
            )->leftJoin(
                \DB::raw('('.$currencySellQuantity.') as sold_currency'),
                'sold_currency.buy_id','=','am_currency.id'
            )->select('last_price.date as last_date','last_price.currency_name',
                'last_price.currency_unit','last_price.sell as last_sell',
                'last_price.buy as last_buy','am_currency.id',
                \DB::raw('(am_currency.quantity - ifnull(sold_currency.quantity,0)) as remaining_quantity'),
                'am_currency.buy_date','am_currency.quantity','am_currency.type_id',
                'am_currency.total_amount',
                \DB::raw('am_currency.total_amount/am_currency.quantity as buy_rate')
            )->where('user_id','=',auth()->id());

        if($request->has('show_sold') && $request->get('show_sold') == 0){
            $currencyOnlyRemaining = \DB::table(\DB::raw('('.$currency->toSql().') as currency'))
                ->addBinding($currency->getBindings())
                ->select('currency.id')
                ->where('currency.remaining_quantity','>',0)->lists('id');

            $currency->whereIn('am_currency.id',$currencyOnlyRemaining);
        }

        return (new CurrencyTransformer())->transform(\Datatables::of($currency))->make(true);
    } 
	
    public function old_fetch(Request $request)
    {
        $types = 'select id from currency_type';

        $latest = \DB::table('currency')
        ->leftJoin('currency_rate as price','price.currency_id','=','currency.id')
        ->whereRaw('(price.type_id) in ('.$types.')')
        ->select(\DB::raw('price.type_id,max(date) as last_date'));

        $latestDate = $latest->groupBy('price.type_id');

        //dd($latestDate->get());

        $currency = \DB::table('currency')
        ->leftJoin('currency_rate as price','price.currency_id','=','currency.id')
        ->leftJoin('currency_type as type','type.id','=','price.type_id')
        ->join('am_currency as amc','amc.type_id','=','type.id')
        ->whereRaw('(price.type_id,currency.date) in ('.$latestDate->toSql().')')
        ->where('amc.user_id',\Auth::id())
        ->select('amc.id','price.type_id','currency.date as last_date','price.buy as last_buy'
                ,'price.sell as last_sell','type.name as type_name'
                ,'type.unit','amc.buy_date','amc.quantity','amc.total_amount')->get();

        //dd($currency);

        $sell = collect(\DB::table('am_currency_sell')
            ->whereIn('buy_id',collect($currency)->lists('id')->toArray())
            ->select('id','buy_id','sell_date as date','sell_amount','quantity','remarks')
            ->get())->groupBy('buy_id')->toArray();

        $newcurrency = [];

        foreach ($currency as $key => $row) {
            $row->buy_rate = $row->total_amount/$row->quantity;
            $row->sbuy_rate = $row->buy_rate.'/'.$row->type_name;
            $row->slast_buy = $row->last_buy/$row->unit.'/'.$row->type_name;
            $row->slast_sell = $row->last_sell/$row->unit.'/'.$row->type_name;
            $row->url = route('member.currency.update',$row->id);
            $row->quantityLeft = $row->quantity;
            $row->sell = [];

            $row->sellProfit = 0;
            
            if(array_key_exists($row->id, $sell)){
                $sales = $sell[$row->id];
                foreach ($sales as $sold) {
                    $sold->rate = $sold->sell_amount/$sold->quantity;
                    $sold->sRate = $sold->rate.'/'.$row->type_name;
                    $sold->url = route('member.currency-sell.update',$sold->id);
                    $sold->profit_loss = ($sold->rate - $row->buy_rate)*$sold->quantity;
                    $row->quantityLeft -= $sold->quantity;
                    $row->sellProfit += $sold->profit_loss;
                }

                $row->sell = $sales;
            }


            $row->investment = $row->market_value = $row->profit_loss = $row->percent = 0;
            
            if($row->quantityLeft > 0){
                $row->investment = $row->quantityLeft * $row->buy_rate;
                $row->market_value = ($row->last_sell/$row->unit)*$row->quantityLeft;
                $row->profit_loss = $row->market_value - $row->investment;
                $row->percent = ($change = $row->profit_loss*100/$row->investment) == 0 ? 0 : $change;
            }

            if($row->quantityLeft > 0 || $request->show_sold == 1){ $newcurrency[] = $row;}
        }

        return \Datatables::of(collect($newcurrency))->make(true);
    }

    public function store(AMCurrencyFormRequest $request)
    {
        $error = true;

        $currency = new Currency();
        $currency->user_id = \Auth::id();
        $currency->type_id = $request->type;
        $currency->buy_date = ( $request->has('buy_date') && $request->buy_date != '') ? $request->buy_date : date('Y-m-d');
        $currency->total_amount = $request->total_amount;
        $currency->quantity = $request->quantity;

        

        if(! $currency->save()){
            $message = 'Sorry, could not add new currency portfolio at the moment.';
        }else{
            $error = false;
            $message = 'Success, new currency portfolio is created.';
        }

        if($request->ajax()){
            return ['error'=>$error,'message'=>$message];
        }

        return redirect()->route('member.currency.index')->with($error ? 'warning' : 'success', $message);

    }

    public function update(AMCurrencyFormRequest $request, $id)
    {
        $error = true;
        $currency = Currency::where('user_id',\Auth::id())->where('id',$id)->first();

        if(is_null($currency)){
            return ['error'=>$error,'message'=>'Invalid Request'];
        }

        $currency->type_id = $request->type;
        $currency->buy_date = ($request->has('buy_date') && $request->buy_date != '') 
                ? $request->buy_date : date('Y-m-d');
        $currency->total_amount = $request->total_amount;
        $currency->quantity = $request->quantity;
        
        if(!$currency->save()){
            $message = 'Sorry, could not update currency portfolio at the moment.';
        }else{
            $error = false;
            $message = 'Success, currency portfolio has been updated.';
        }

        if($request->ajax()){
            $response = ['error'=>$error,'message'=>$message];
        }else{
            $type = ($error) ? 'warning' : 'success';
            $response = redirect()->route('member.currency.index')->with($type,$message);
        }

        return $response;
    }

    public function destroy($id, Request $request)
    {
        $response = ['error'=>true,'message'=>'Invalid Request'];
        $currency = Currency::find($id);
        if(is_null($currency)) return $response;

        if(!$currency->delete()){
            $response['message'] = 'Sorry, could not delete currency at the moment.';
            return $response;
        }

        $response['error'] = false;
        $response['message'] = 'Success, currency record has been deleted.';

        if($request->ajax()){
            return $response;
        }

        return redirect()->route('member.currency.index')
        ->with($response['error']  ? 'warning' : 'success',$response['message']);
    }
}
