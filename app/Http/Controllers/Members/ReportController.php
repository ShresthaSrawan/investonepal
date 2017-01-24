<?php

namespace App\Http\Controllers\Members;

use App\Models\AssetsManagement\Basket;
use App\Models\Sector;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;
use App\Models\AssetsManagement\CurrencySell;
use App\Models\BullionType;
use App\Models\AssetsManagement\StockBuy;
use App\Models\AssetsManagement\Currency;
use App\Transformer\CurrencyTransformer;
use App\Models\AssetsManagement\Bullion;
use App\Models\Bullion as BullionRecord;
use App\Transformer\BullionTransformer;

class ReportController extends Controller
{
    public function stock()
    {
        $company = Basket::join('am_stocks_buy as stock','am_stock_basket.id','=','stock.basket_id')
            ->join('company','company.id','=','stock.company_id')
            ->select('company.quote','company.name')
            ->where('am_stock_basket.user_id',Auth::id())
            ->get()->lists('name','quote')->toArray();

        $basket = Basket::where('user_id',Auth::id())->get()->lists('name','id')->toArray();
        $sector = Sector::all()->lists('label','id')->toArray();

        return view('members.report.stock',compact('company','basket','sector'));
    }

    public function stockPerformance(Request $request)
    {
		  //TODO
		    return [];
        $close_price = "select `company_id`, `date` as `tran_date`, `close` as `close_price`
                from todays_price where (company_id, date) in
                ( select company_id, max(date)
                  from todays_price
                  group by company_id
                )";

        $sell = 'select buy_id,sum(quantity) as sold_quantity from am_stocks_sell group by(buy_id)';

        $stock = DB::table('am_stocks_buy as stock')
            ->leftJoin('am_stock_basket as basket','stock.basket_id','=','basket.id')
            ->leftJoin('company','stock.company_id','=','company.id')
            ->leftJoin(DB::raw('('.$sell.') as sell'),'sell.buy_id','=','stock.id')
            ->leftJoin(DB::raw('('.$close_price.') as latest_price'),'stock.company_id','=','latest_price.company_id')
            ->where('basket.user_id',Auth::id())
            ->where('company.quote',$request->get('quote'))
            ->whereRaw('(stock.quantity - IFNULL(sell.sold_quantity,0)) > 0')
            ->select('stock.basket_id','stock.id as stock_id','stock.quantity','stock.owner_name as owner'
                ,'stock.buy_rate','stock.buy_date','company.name as company_name','basket.name as basket_name',
                'company.quote as quote','stock.company_id','latest_price.tran_date','latest_price.close_price'
                ,DB::raw('(stock.quantity - IFNULL(sell.sold_quantity,0)) as r_quantity,
                 (stock.buy_rate + (stock.commission/stock.quantity)) as new_rate,
                 ((stock.buy_rate + (stock.commission/stock.quantity))*(stock.quantity - IFNULL(sell.sold_quantity,0))) as investment,
                 ((stock.quantity - IFNULL(sell.sold_quantity,0))*latest_price.close_price) as portfolio_value')
            );


        return Datatables::of($stock)->make(true);
    }

    public function stockBuyReport(Request $request)
    {
      $basket = $request->get('basket');
      $from = $request->get('from_date');
      $to = $request->get('to_date');

      $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                    , `price`.`close` as `close_price` from `todays_price` as `price`
                    INNER JOIN `last_traded_price` as `ltp`
                    on `price`.`company_id` = `ltp`.`company_id`
                    and `price`.`date` = `ltp`.`date`";

      $stocks = \DB::table('am_stocks_buy as stock')
        ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'stock.company_id','=','latest_price.cid')
        ->join('am_stock_basket as basket', 'basket.id', '=', 'stock.basket_id')
        ->join('company', 'company.id', '=', 'stock.company_id')
        ->join('am_stock_types', 'am_stock_types.id', '=', 'stock.type_id')
        ->select(
          'latest_price.close_date', 'latest_price.close_price',
          'company.name as company_name', 'company.quote',
          'stock.buy_date', 'stock.owner_name', 'stock.shareholder_number', 'stock.certificate_number', 
          'stock.buy_rate',
          'stock.quantity', 'stock.commission',
          'am_stock_types.name as stock_type_name',
          \DB::raw('(commission / quantity) as commission_rate_per_quantity')
        )
        ->where('basket_id', $basket)
        ->where('basket.user_id', auth()->id());

        if($from != '' && $to != ''):
            $stocks->whereBetween('buy_date',[$from,$to]);
        elseif($from != ''):
            $stocks->where('buy_date','>=',$from);
        elseif($to != ''):
            $stocks->where('buy_date','<=',$to);
        endif;

        $stockWithComputedValues = \DB::table(
            \DB::raw('('.$stocks->toSql().') as stocks')
        )->select(
          'close_date', 'close_price', 'company_name','quote', 'company_name', 'quote', 'buy_date', 
          'owner_name', 'shareholder_number', 'certificate_number', 'buy_rate','quantity', 'commission',
          'stock_type_name', 'commission_rate_per_quantity'
        )
        ->selectRaw(
          '(@buy_rate_with_commission:= (buy_rate + commission_rate_per_quantity)) as buy_rate_with_commission,
           (@investment:= (quantity * (buy_rate + commission_rate_per_quantity))) as investment,
           (@market_value:= (quantity * close_price)) as market_value,
           (@market_value - @investment) as profit_loss'
        )->addBinding($stocks->getBindings());

        return Datatables::of($stockWithComputedValues)->make(true);
    }

    public function stockSellReport(Request $request)
    {
        $basket = $request->get('basket');
        $from = $request->get('sell_from_date');
        $to = $request->get('sell_to_date');

        $stocks = DB::table('am_stock_basket as basket')
            ->join('am_stocks_buy as buy','basket.id','=','buy.basket_id')
            ->join('company','company.id','=','buy.company_id')
            ->join('am_stocks_sell as sell','buy.id','=','sell.buy_id')
            ->select('basket.name as basket_name','company.name as company_name',
                'company.quote as company_quote','sell.sell_date',
                'sell.quantity as sell_quantity','sell.sell_rate','sell.commission as sell_commission'
                ,'sell.total_tax as tax',
                DB::raw('(buy.buy_rate + buy.commission/buy.quantity) as buy_rate'),
                DB::raw('(buy.buy_rate + buy.commission/buy.quantity)*sell.quantity as buy_price'),
                DB::raw('((sell.quantity*sell.sell_rate) - (sell.commission + sell.total_tax)) as total_sales'),
                DB::raw('(sell.quantity*(sell.sell_rate -(buy.buy_rate+(buy.commission/buy.quantity))) - (sell.commission + sell.total_tax)) as income')
            )->where('basket.id',$request->get('basket'))
            ->where('basket.user_id', auth()->id())
            ->whereNotNull('sell.quantity');

        if($from != '' && $to != ''):
            $stocks->whereBetween('sell.sell_date',[$from,$to]);
        elseif($from != ''):
            $stocks->where('sell.sell_date','>=',$from);
        elseif($to != ''):
            $stocks->where('sell.sell_date','<=',$to);
        endif;

        $stockWithComputedValues = \DB::table(
            \DB::raw('('.$stocks->toSql().') as stocks')
        )->select(
          'basket_name','company_name','company_quote','sell_date','sell_quantity','sell_rate',
          'sell_commission','tax','buy_rate','buy_price','total_sales','income'
        )
        ->addBinding($stocks->getBindings());

        return Datatables::of($stockWithComputedValues)->make(true);
    }

    public function stockFundamentalAnalysis(Request $request)
    {
		  //TODO
		  return [];
        $close_price = "select `company_id`, `date` as `tran_date`, `close` as `close_price`
                from todays_price where (company_id, date) in
                ( select company_id, max(date)
                  from todays_price
                  group by company_id
                )";

        $max_fiscal = DB::table('financial_highlight as fh')
            ->join('fiscal_year as fiscal','fiscal.id','=','fh.fiscal_year_id')
            ->groupBy('fh.company_id')
            ->select(DB::raw('fh.company_id, MAX(fiscal.label) as label'));

        $max_all = DB::table('financial_highlight as fh')
            ->join('fiscal_year as fiscal','fiscal.id','=','fh.fiscal_year_id')
            ->join('announcement as anon','fh.announcement_id','=','anon.id')
            ->join('announcement_subtype as subtype','subtype.id','=','anon.subtype_id')
            ->whereRaw("(fh.company_id, fiscal.label) IN ({$max_fiscal->toSql()})")
            ->groupBy('fh.company_id')
            ->select(DB::raw('fh.company_id, fiscal.label, MAX(subtype.label) as quarter'));

        $fh = DB::table('financial_highlight as fh')
            ->join('fiscal_year as fiscal','fiscal.id','=','fh.fiscal_year_id')
            ->join('announcement as anon','fh.announcement_id','=','anon.id')
            ->join('announcement_subtype as subtype','subtype.id','=','anon.subtype_id')
            ->whereRaw("(fh.company_id, fiscal.label, subtype.label) IN ({$max_all->toSql()})")
            ->select('fh.company_id','fiscal.label as fiscal_year','subtype.label as quarter'
                ,'fh.paid_up_capital','fh.reserve_and_surplus'
                ,'fh.earning_per_share','fh.net_worth_per_share','fh.book_value_per_share','fh.net_profit'
                ,'fh.liquidity_ratio','fh.price_earning_ratio','fh.operating_profit');

        $company = DB::table('company')
            ->join('sector','sector.id','=','company.sector_id')
            ->leftJoin(DB::raw('('.$close_price.') as latest_price'),'company.id','=','latest_price.company_id')
            ->join(DB::raw('('.$fh->toSql().') as fh'),'fh.company_id','=','company.id')
            ->select('fh.fiscal_year','fh.quarter'
                ,'fh.paid_up_capital','fh.reserve_and_surplus'
                ,'fh.earning_per_share','fh.net_worth_per_share','fh.book_value_per_share','fh.net_profit'
                ,'fh.liquidity_ratio','fh.price_earning_ratio','fh.operating_profit','latest_price.close_price'
                ,'latest_price.tran_date','company.name as company_name','company.quote as company_quote')
            ->where('sector.id',$request->get('sector'))
        ;

        return Datatables::of($company)->make(true);
    }

    public function property(Request $request)
    {
      return view('members.report.property');
    }

    public function propertyBuyReport(Request $request)
    {
        $properties = \DB::table('am_property')
        ->select('id','asset_name','unit','owner_name as owner','buy_date','quantity','rate','market_rate','market_date')
        ->where('user_id',\Auth::id());

        if($request->has('from') && $request->from != ''){
            $properties->where('buy_date','>=',$request->from);
        }

        if($request->has('to') && $request->to != ''){
            $properties->where('buy_date','<=',$request->to);
        }

        $properties = $properties->get();

        foreach ($properties as $property) {
            $property->srate = $property->rate.'/'.$property->unit;
            $property->smarket_rate = $property->market_rate.'/'.$property->unit;
            $property->investment = $property->quantity * $property->rate;
            
            $property->market_value = !is_null($property->market_rate) 
                    ? $property->market_rate * $property->quantity 
                    : $property->rate * $property->quantity;

            $property->change = $property->market_value - $property->investment;
            $property->change_percent = $property->change*100/$property->investment;
        }
        
        return \Datatables::of(collect($properties))->make(true);
    }

    public function propertySellReport(Request $request)
    {
        $properties = \DB::table('am_property as prop')
        ->join('am_property_sell as sell','sell.property_id','=','prop.id')
        ->select('prop.id','prop.asset_name','prop.unit','prop.owner_name as owner','prop.buy_date','prop.quantity','prop.rate as buy_rate'
            ,'sell.id','sell.sell_date','sell.sell_quantity','sell.sell_rate','sell.remarks')
        ->where('user_id',\Auth::id());

        if($request->has('from') && $request->from != ''){
            $properties->where('sell.sell_date','>=',$request->from);
        }

        if($request->has('to') && $request->to != ''){
            $properties->where('sell.sell_date','<=',$request->to);
        }

        $properties = $properties->get();

        foreach ($properties as $property) {
            $property->sbuy_rate = $property->buy_rate.'/'.$property->unit;
            $property->ssell_rate = $property->sell_rate.'/'.$property->unit;
            $property->investment = $property->buy_rate * $property->sell_quantity;
            $property->sell_value = $property->sell_rate * $property->sell_quantity;
            $property->change = $property->sell_value - $property->investment;
            $property->change_percent = $property->change*100/$property->investment;
        }
        
        return \Datatables::of(collect($properties))->make(true);
    }

    public function currency(Request $request)
    {
      $currency = collect(\DB::table('currency_type')->select('id','name')->get())->lists('name','id')->toArray();
      return view('members.report.currency',compact('currency'));
    }

    public function currencyBuyReport(Request $request)
    {
        $maxDatePerType = \DB::table('currency')
            ->join('currency_rate as rate', 'rate.currency_id','=','currency.id')
            ->join('currency_type as type', 'type.id','=','rate.type_id')
            ->selectRaw('type_id, max(date) as last_date, type.name as currency_name, type.unit as currency_unit')
            ->groupBy('type_id')
            ->toSql();

        $lastCurrencyPrice = \DB::table('currency_rate as rate')
            ->join('currency','currency.id','=','rate.currency_id')
            ->join(\DB::raw('('.$maxDatePerType.') as last_date'), function($query){
                $query->on('last_date.last_date','=','currency.date')->on('last_date.type_id','=','rate.type_id');
            })
            ->select('last_date.*','currency.id','rate.buy as last_buy', 'rate.sell as last_sell')
            ->toSql();

        $currencies = Currency::leftJoin(
            \DB::raw('('.$lastCurrencyPrice.') as last_price'),
            'last_price.type_id','=','am_currency.type_id'
        )->selectRaw(
            'last_price.*, am_currency.id, am_currency.quantity, 
            am_currency.type_id, last_price.currency_name, am_currency.buy_date,
            last_price.currency_unit, am_currency.total_amount as investment, 
            am_currency.total_amount/am_currency.quantity as buy_rate, 
            (last_price.last_sell * quantity) as market_value'
        )->where('user_id','=',auth()->id());

        if($request->has('from') && $request->has('to')){
            $currencies = $currencies->whereBetween('buy_date',[$request->from,$request->to]);
        }elseif ($request->has('from')){
            $currencies = $currencies->where('buy_date','>=',$request->from);
        }
        elseif($request->has('to')){
            $currencies = $currencies->where('buy_date','<=',$request->to);
        }

        return \Datatables::of($currencies)->make(true);
    }

    public function currencySellReport(Request $request)
    {
        $currencies = \DB::table('am_currency as amc')
        ->join('currency_type as type','amc.type_id','=','type.id')
        ->join('am_currency_sell as sell','sell.buy_id','=','amc.id')
        ->where('amc.user_id',\Auth::id())
        ->select('amc.id','amc.type_id','amc.total_amount','amc.buy_date','amc.quantity'
            ,'sell.sell_date','sell.sell_amount','sell.quantity as sell_quantity','sell.remarks'
            ,'type.name','type.unit');


        if($request->has('from') && $request->from != ''){
            $currencies->where('amc.buy_date','>=',$request->from);
        }

        if($request->has('to') && $request->to != ''){
            $currencies->where('amc.buy_date','<=',$request->to);
        }

        $currencies = $currencies->get();


        foreach ($currencies as $currency) {
            $currency->sell_rate = $currency->sell_amount/$currency->sell_quantity;
            $currency->buy_rate = $currency->total_amount/$currency->quantity;
            
            $currency->investment = $currency->sell_quantity * $currency->buy_rate;
            $currency->change = $currency->sell_amount - $currency->investment;
            $currency->change_percent = $currency->change*100/$currency->investment;
            
            $currency->ssell_rate = $currency->sell_rate.'/'.$currency->name;
            $currency->sbuy_rate = $currency->buy_rate.'/'.$currency->name;
        }
        
        return \Datatables::of(collect($currencies))->make(true);
    }

    public function currencySummary(Request $request)
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

        $currency = Currency::leftJoin(
            \DB::raw('('.$lastCurrencyPrice.') as last_price'),
            'last_price.type_id','=','am_currency.type_id'
          )->leftJoin(
            \DB::raw('('.$currencySellQuantity.') as sold_currency'),
            'sold_currency.buy_id','=','am_currency.id'
          )->select(
            'last_price.date as last_date','last_price.sell as last_sell',
            'last_price.buy as last_buy','last_price.currency_name','last_price.currency_unit', 'am_currency.id',
            \DB::raw('(am_currency.quantity - ifnull(sold_currency.quantity,0)) as remaining_quantity'),
            'am_currency.buy_date','am_currency.quantity','am_currency.type_id',
            'am_currency.total_amount',
            \DB::raw('am_currency.total_amount/am_currency.quantity as buy_rate')
          )->where('user_id','=',auth()->id());

        if($request->has('from') && $request->has('to')){
            $currency = $currency->whereBetween('buy_date',[$request->from,$request->to]);
        }elseif ($request->has('from')){
            $currency = $currency->where('buy_date','>=',$request->from);
        }elseif($request->has('to')){
            $currency = $currency->where('buy_date','<=',$request->to);
        }

        if($request->has('currency') && $request->currency != ''){
            $currency->where('am_currency.type_id','=',$request->currency);
        }

        $currencyOnlyRemaining = \DB::table(\DB::raw('('.$currency->toSql().') as currency'))
          ->addBinding($currency->getBindings())
          ->select('currency.id')
          ->where('currency.remaining_quantity','>',0)->lists('id');

        $currency->whereIn('am_currency.id',$currencyOnlyRemaining);

        return (new CurrencyTransformer())->transform(\Datatables::of($currency))->make(true);
    }

    public function bullion(Request $request)
    {
      $bullion = BullionType::select('id','name')->get()->lists('name','id')->toArray();

      return view('members.report.bullion',compact('bullion'));
    }

    public function bullionBuyReport(Request $request)
    {
      $lastDate = BullionRecord::selectRaw('id,max(date) as date')->toSql();

      $lastbullionPrice = \DB::table('bullion_price')
        ->join(\DB::raw('('.$lastDate.') as bullion'),'bullion.id','=','bullion_price.bullion_id')
        ->select('bullion.date','bullion_price.price','bullion_price.type_id')
        ->toSql();

      $bullion = Bullion::with(['type'=>function($type){
          $type->select('id','name','unit');
      }])
        ->leftJoin(
          \DB::raw('('.$lastbullionPrice.') as last_price'),
          'last_price.type_id','=','am_bullion.type_id'
        )->join('bullion_type as bt','bt.id','=','am_bullion.type_id')
        ->select('last_price.date as last_date','last_price.price as last_price',
          'am_bullion.id','am_bullion.buy_date',
          'am_bullion.quantity','am_bullion.type_id','am_bullion.total_amount as investment',
          \DB::raw('(am_bullion.total_amount/am_bullion.quantity) as buy_rate'),
          \DB::raw('(@market_rate:=(last_price.price / (case when ((@unit:=CAST(bt.unit AS DECIMAL)) = 0) THEN 1 ELSE @unit END))) as market_rate'),
          \DB::raw('(@market_val:=(am_bullion.quantity*@market_rate)) as market_value'),
          \DB::raw('(am_bullion.total_amount - @market_val) as difference')
        )->where('user_id','=',auth()->id());

      if($request->has('from') && $request->has('to')){
      $bullion = $bullion->whereBetween('am_bullion.buy_date',[$request->from,$request->to]);
      }elseif($request->has('from')){
        $bullion = $bullion->where('am_bullion.buy_date','>=',$request->from);
      }elseif($request->has('to')){
        $bullion = $bullion->where('am_bullion.buy_date','<=',$request->to);
      }

      return \Datatables::of($bullion)->make(true);
    }

    public function bullionSellReport(Request $request)
    {

        $bullions = \DB::table('am_bullion as amb')
        ->join('bullion_type as type','amb.type_id','=','type.id')
        ->join('am_bullion_sell as sell','amb.id','=','sell.buy_id')
        ->where('amb.user_id',\Auth::id())
        ->select('amb.total_amount','amb.buy_date','amb.quantity'
            ,'type.name','type.unit','sell.sell_date','sell.sell_price'
            ,'sell.quantity as sell_quantity','sell.remarks');

        if($request->has('from') && $request->from != ''){
            $bullions->where('sell.sell_date','>=',$request->from);
        }

        if($request->has('to') && $request->to != ''){
            $bullions->where('sell.sell_date','<=',$request->to);
        }

        $bullions = $bullions->get();

        foreach ($bullions as $bullion) {
            $unit = explode(' ', $bullion->unit);
            $unit_num = floatval($bullion->unit);
            $unit_prefix = end($unit);

            $bullion->buy_rate = $bullion->total_amount/$bullion->quantity;
            $bullion->sbuy_rate = round($bullion->buy_rate,2).'/'.$unit_prefix;

            $bullion->sell_rate = $bullion->sell_price/$bullion->sell_quantity;
            $bullion->ssell_rate = round($bullion->sell_rate,2).'/'.$unit_prefix;

            
            $bullion->investment = $bullion->sell_quantity * $bullion->buy_rate;
            
            $bullion->change = $bullion->sell_price - $bullion->investment;
            $bullion->change_percent = $bullion->change*100/$bullion->investment;

            unset($bullion->unit,$bullion->total_amount,$bullion->quantity);
        }
        
        return \Datatables::of(collect($bullions))->make(true);
    }

    public function bullionSummary(Request $request)
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

      if($request->has('from') && $request->has('to')){
          $bullion = $bullion->whereBetween('am_bullion.buy_date',[$request->from,$request->to]);
      }elseif($request->has('from')){
          $bullion = $bullion->where('am_bullion.buy_date','>=',$request->from);
      }elseif($request->has('to')){
          $bullion = $bullion->where('am_bullion.buy_date','<=',$request->to);
      }

      if($request->has('bullion') && $request->bullion != ''){
          $bullion = $bullion->where('am_bullion.type_id','=',$request->bullion);
      }

      return (new BullionTransformer())->transform(\Datatables::of($bullion))->make(true);
    }
}
