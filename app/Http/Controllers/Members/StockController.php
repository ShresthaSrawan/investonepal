<?php

namespace App\Http\Controllers\Members;

use App\Http\Requests\AMSellStockFormRequest;
use App\Http\Requests\AMStockBuyFormRequest;
use App\Models\AssetsManagement\Basket;
use App\Models\AssetsManagement\StockBuy;
use App\Models\AssetsManagement\StockSell;
use App\Models\AssetsManagement\StockType;
use App\Models\AssetsManagement\StockDetails;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\FiscalYear;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use yajra\Datatables\Datatables;

class StockController extends Controller
{
    public function index()
    {
		    $basket = Basket::where('user_id',Auth::user()->id)->get(['id','name'])->lists('name','id')->toArray();
        $company = Company::orderBy('name','ASC')->get()->lists('name','id')->toArray();
        $stockTypes = StockType::get(['id','name'])->lists('name','id')->toArray();

        return view('members.basket.index',compact('basket','company','stockTypes'));
    }
    
    public function show($id)
    {
        $fiscalYear = FiscalYear::orderBy('label','desc')->get()->lists('label','id')->toArray();
        $baskets = Basket::where('user_id',Auth::user()->id)->get();
        $company = Company::orderBy('name','ASC')->get()->lists('name','id')->toArray();
        $stockTypes = StockType::all()->lists('name','id')->toArray();

        return view('members.portfolio.stock-grouped-new',compact('baskets','company','stockTypes','fiscalYear'))->with('selected',$id);
    }
	
    public function fetch(Request $request)
    {
        $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                      , `price`.`close` as `close_price` from `todays_price` as `price`
                      INNER JOIN `last_traded_price` as `ltp`
                      on `price`.`company_id` = `ltp`.`company_id`
                      and `price`.`date` = `ltp`.`date`";

        $stock = StockBuy::with(['company'=>function($q){
            $q->select('id','name','quote');
        }])->with(['type'=>function($q){
            $q->select('id','name');
        }])->with('details')
        ->with(['details.fiscalYear'=>function($q){
            $q->select('id','label as name')->orderBy('label','desc');
        }])->with('sell')
        ->where('user_id',Auth::id())
        ->where('basket_id',$request->get('basket_id'))
        ->where('basket.user_id',auth()->id())
        ->join('am_stock_basket as basket','basket.id','=','am_stocks_buy.basket_id')
        ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'am_stocks_buy.company_id','=','latest_price.cid')
        ->select('am_stocks_buy.id','basket_id','type_id','company_id','shareholder_number','certificate_number','owner_name','buy_date','quantity','buy_rate','commission','close_date','close_price');

        if($request->has('show_sold') && $request->get('show_sold') == 0){
            $stockOnlyRemaining = Basket::where('am_stock_basket.user_id','=',auth()->id())
                ->leftJoin('am_stocks_buy as buy','buy.basket_id','=','am_stock_basket.id')
                ->leftJoin('am_stocks_sell as sell','sell.buy_id','=','buy.id')
                ->where('am_stock_basket.id',$request->get('basket_id'))
                ->select('buy.id',\DB::raw('buy.quantity - ifnull(sum(sell.quantity), 0) remaining_quantity'))
                ->having(\DB::raw('remaining_quantity'),'>',0)
                ->groupBy('buy.id')->lists('id');

            $stock->whereIn('am_stocks_buy.id',$stockOnlyRemaining);
        }

        return Datatables::of($stock)->make(true);
    }

    // NEW
    /*
        buy.shareholder_number, buy.certificate_number, buy.owner_name,
        type.id as type_id, type.name as type_name,
     */
    public function fetchGrouped(Request $request)
    {
      $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                    , `price`.`close` as `close_price` from `todays_price` as `price`
                    INNER JOIN `last_traded_price` as `ltp`
                    on `price`.`company_id` = `ltp`.`company_id`
                    and `price`.`date` = `ltp`.`date`";

      $stockWithLastPrice = \DB::table('am_stocks_buy as stock')
      ->join('am_stock_basket as basket', 'basket.id', '=', 'stock.basket_id')
      ->leftJoin('am_stocks_sell as sell', 'sell.buy_id', '=','stock.id')
      ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'stock.company_id','=','latest_price.cid')
      ->leftJoin('company', 'company.id', '=', 'stock.company_id')
      //->leftJoin('am_stock_types as type', 'type.id', '=', 'stock.type_id')
      ->selectRaw('
          (ifnull(CAST(sum(sell.quantity) AS SIGNED), 0)) as sell_quantity,
          (stock.quantity - ifnull(CAST(sum(sell.quantity) AS SIGNED),0)) as remaining_quantity,
          (stock.commission / stock.quantity) as commission_per_quantity,
          stock.commission, stock.buy_rate, stock.quantity as buy_quantity,
          latest_price.close_date, latest_price.close_price, company.quote as company_quote,
          company.name as company_name,company.id as company_id, stock.id
          '
      )
      ->groupBy('stock.id')
      ->where('basket_id',$request->get('basket_id'))
      ->where('basket.user_id',auth()->id());

      if($request->show_sold == 0) {
        $stockWithLastPrice = $stockWithLastPrice->having('remaining_quantity','>',0);
      }

      $stockWithComputedValues = \DB::table(
          \DB::raw('('.$stockWithLastPrice->toSql().') as stock')
      )
      ->addBinding($stockWithLastPrice->getBindings())
      ->selectRaw('
          stock.*,
          (@investment:= (
              (stock.remaining_quantity * stock.buy_rate)  + (stock.commission_per_quantity * stock.remaining_quantity)
          )) as investment,
          @market_value:= (stock.remaining_quantity * stock.close_price) as market_value,
          @market_value - @investment as profit_loss
      ');

      $stockGroupedByCompany = \DB::table(
          \DB::raw('('.$stockWithComputedValues->toSql().') as sc')
      )
      ->addBinding($stockWithComputedValues->getBindings())
      ->selectRaw('
          sell_quantity, sc.buy_quantity, sc.close_date, sc.close_price, sc.company_quote,
          sc.company_name, sc.company_id, count(sc.company_id) as total_stocks,
          sum(sc.investment) as investment, sum(sc.market_value) as market_value, sum(sc.profit_loss) as profit_loss,
          sum(sc.remaining_quantity) as remaining_quantity, sum(sc.commission) as commission, sum(sc.commission_per_quantity) as commission_per_quantity,
          (sum(investment)/sum(remaining_quantity)) as buy_rate
      ')
      ->groupBy('sc.company_id');

      return $dt = Datatables::of($stockGroupedByCompany)->make(true);
    }

    public function fetchGroup(Request $request)
    {
		    $company_id = $request->get('company_id');

        $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                      , `price`.`close` as `close_price` from `todays_price` as `price`
                      INNER JOIN `last_traded_price` as `ltp`
                      on `price`.`company_id` = `ltp`.`company_id`
                      and `price`.`date` = `ltp`.`date`";

        $stockWithLastPrice = \DB::table('am_stocks_buy as stock')
        ->join('am_stock_basket as basket', 'basket.id', '=', 'stock.basket_id')
        ->leftJoin('am_stocks_sell as sell', 'sell.buy_id', '=','stock.id')
        ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'stock.company_id','=','latest_price.cid')
        ->leftJoin('company', 'company.id', '=', 'stock.company_id')
        //->leftJoin('am_stock_types as type', 'type.id', '=', 'stock.type_id')
        ->selectRaw('
            ifnull(CAST(sum(sell.quantity) AS SIGNED), 0) as sell_quantity,
            (stock.quantity - ifnull(CAST(sum(sell.quantity) AS SIGNED),0)) as remaining_quantity,
            (stock.commission / stock.quantity) as commission_per_quantity,
            stock.commission, stock.buy_rate, stock.quantity as buy_quantity,
            latest_price.close_date, latest_price.close_price, company.quote as company_quote,
            company.name as company_name,company.id as company_id, stock.id,
            stock.buy_date, stock.certificate_number, stock.shareholder_number, stock.owner_name,
            stock.type_id, stock.basket_id
        ')
        ->groupBy('stock.id')
        ->where('company.id', $company_id)
        ->where('basket_id',$request->get('basket_id'))
        ->where('basket.user_id',auth()->id());

        if($request->has('show_sold') && $request->get('show_sold') == 0){
          $stockWithLastPrice = $stockWithLastPrice->having(\DB::raw('remaining_quantity'),'>',0);
        }

        $stockWithComputedValues = \DB::table(
            \DB::raw('('.$stockWithLastPrice->toSql().') as stock')
        )
        ->addBinding($stockWithLastPrice->getBindings())
        ->selectRaw('
            stock.*,
            (@investment:= (
                stock.remaining_quantity * (stock.buy_rate + stock.commission_per_quantity)
            )) as investment,
            @market_value:= (stock.remaining_quantity * stock.close_price) as market_value,
            @market_value - @investment as profit_loss
        ');

        return Datatables::of($stockWithComputedValues)->make(true);
    }

    public function fetchStockSell(Request $request)
    {
        $buy_id = $request->get('buy_id');
        $basket_id = $request->get('basket_id');

        $sell = \DB::table('am_stocks_sell as sell')
            ->join('am_stocks_buy as buy','buy.id','=', 'sell.buy_id')
            ->join('am_stock_basket as basket','basket.id','=', 'buy.basket_id')
            ->selectRaw('
                sell.id,sell.buy_id, sell.sell_date, sell.quantity as sell_quantity, 
                sell.sell_rate, sell.commission as sell_commission, sell.total_tax as sell_tax,
                buy.buy_rate, (buy.commission / buy.quantity) as buy_commission_per_quantity,
                (sell.quantity * sell.sell_rate) as sales_value, sell.note as sell_note
            ')
            ->where('sell.buy_id', $buy_id)
            ->where('buy.basket_id', $basket_id)
            ->where('basket.user_id', auth()->id());

        $sellWithComputedValues = \DB::table(
            \DB::raw('('.$sell->toSql().') as sell')
        )
        ->addBinding($sell->getBindings())
        ->selectRaw('
            sell.* ,
            (buy_rate + buy_commission_per_quantity) as buy_rate_computed,
            @investment:=(
                sell.sell_quantity * (buy_rate + buy_commission_per_quantity)
            ) as investment,
            (sales_value - @investment) as profit_loss
        ');

        return Datatables::of($sellWithComputedValues)->make(true);
    }

    public function store(AMStockBuyFormRequest $request)
    {
        $response['error'] = false;
        try{
            $stock = new StockBuy();
            $stock->basket_id = $request->get('basket_id');
            $stock->type_id = $request->get('type');
            $stock->company_id = $request->get('company');
            $stock->shareholder_number = $request->get('shareholder_number');
            $stock->certificate_number = $request->get('certificate_number');
            $stock->owner_name = $request->get('owner_name');
            $stock->buy_date = $request->has('buy_date') ? $request->get('buy_date') : date('Y-m-d');
            $stock->quantity = $request->get('quantity');
            $stock->buy_rate = $request->get('buy_rate');
            $stock->commission = $request->get('commission');
            if(!$stock->save())
                throw new \Exception('Stock could not be created');

            $response['message'] = 'Stock has been created.';
        }catch (\Exception $e){
            $response['error'] = true;
            $response['message'] = 'Sorry, stock could not be created at the moment.';
        }

        return $response;
    }


    public function update(AMStockBuyFormRequest $request, $id)
    {
        $response['error'] = true;
        if(is_null($stock = StockBuy::with('sell')->where('id',$id)->where('basket_id',$request->get('basket_id'))->first())):
            $response['message'] = 'Invalid Request';
            return $response;
        endif;

        $quantity = $request->get('quantity');
        foreach($stock->sell as $sell):
            $quantity -= $sell->quantity;
            if($quantity < 0):
                $response['message'] = 'Supplied quantity is less than sold quantity.';
                return $response;
            endif;
        endforeach;

        try{
            $stock->company_id = $request->get('company');
            $stock->buy_rate = $request->get('buy_rate');
            $stock->type_id = $request->get('type');
            $stock->buy_date = $request->has('buy_date') ? $request->get('buy_date') : $stock->buy_date;
            $stock->shareholder_number = $request->get('shareholder_number');
            $stock->certificate_number = $request->get('certificate_number');
            $stock->owner_name = $request->get('owner_name');
            $stock->commission = $request->get('commission');
            $stock->quantity = $request->get('quantity');

            if(!$stock->save())
                throw new \Exception('Stock could not be updated');

            $response['error'] = false;
            $response['message'] = 'Stock has been updated.';
        }catch (\Exception $e){
            $response['error'] = true;
            $response['message'] = 'Sorry, stock could not be updated at the moment.';
        }

        return $response;
    }

    public function sell(AMSellStockFormRequest $request)
    {
        $response['error'] = false;

        $stock = StockBuy::with('company','sell')->find($request->get('stock_id'));

        if(is_null($stock)):
            $response['error'] = true;
            $response['message'] = 'Invalid Stock Identifier';

            return $response;
        endif;

        $quantity = $stock->quantity;
        foreach($stock->sell as $sell):
            $quantity -= $sell->quantity;
        endforeach;

        if(($quantity - $request->get('sell_quantity')) < 0):
            $response['error'] = true;
            $response['message'] = 'Sell quantity is greater than available stock quantity.';

            return $response;
        endif;

        $stockSell = new StockSell();
        $stockSell->buy_id = $request->stock_id;
        $stockSell->sell_date = $request->sell_date ?: date('Y-m-d');
        $stockSell->quantity = $request->get('sell_quantity');
        $stockSell->sell_rate = $request->get('sell_rate');
        $stockSell->commission = $request->get('sell_commission');
        $stockSell->total_tax = $request->get('sell_tax');
        $stockSell->note = $request->get('sell_note');
        if(! $stockSell->save()):
            $response['error'] = true;
            $response['message'] = 'Sorry, stock sell record could not be created.';
        else:
            $response['message'] = 'Stock sell record has been created.';
        endif;

        return $response;
    }

    public function sellUpdate($sell_id, AMSellStockFormRequest $request)
    {
        $response['error'] = false;

        $stockSell = StockSell::where('buy_id', $request->get('stock_id'))->findOrFail($sell_id);
        $stock = StockBuy::with('company','sell')->find($request->get('stock_id'));

        if(is_null($stock)):
            $response['error'] = true;
            $response['message'] = 'Invalid Stock Identifier';

            return $response;
        endif;

        $quantity = $stock->quantity;
        foreach($stock->sell as $sell):
            if($sell->id == $sell_id) continue;
            $quantity -= $sell->quantity;
        endforeach;

        if(($quantity - $request->get('sell_quantity')) < 0):
            $response['error'] = true;
            $response['message'] = 'Sell quantity is greater than available stock quantity.';

            return $response;
        endif;

        $update = $stockSell->update([
            'sell_date' => $request->sell_date ?: $stockSell->sell_date,
            'quantity' => $request->sell_quantity,
            'sell_rate' => $request->sell_rate,
            'commission' => $request->sell_commission,
            'total_tax' => $request->sell_tax,
            'note' => $request->sell_note,
        ]);

        
        if(! $update):
            $response['error'] = true;
            $response['message'] = 'Sorry, stock sell record could not be updated.';
        else:
            $response['message'] = 'Stock sell record has been updated.';
        endif;

        return $response;
    }

    public function sellDelete($id, Request $request)
    {
        $sell = StockSell::with(['buy.basket'=>function($q){
            $q->where('user_id',\Auth::id());
        }])->find($id);

        $response = ['error'=>true,'message'=>'Invalid Request'];

        if(! is_null($sell) && !is_null($sell->buy) && !is_null($sell->buy->basket)){
            if(!$sell->delete()){
                $response['message'] = 'Sorry, could not delete sell record at the moment';
            }else{
                $response['error'] = false;
                $response['message'] = 'Success, stock sell record has been deleted.';
            }

        }

        return $this->respond($request,$response);
    }

    public function detailsDelete($id, Request $request)
    {
        $details = StockDetails::with(['buy.basket'=>function($q){
            $q->where('user_id',\Auth::id());
        }])->find($id);

        $response = ['error'=>true,'message'=>'Invalid Request'];

        if(! is_null($details) && !is_null($details->buy) && !is_null($details->buy->basket)){
            if(!$details->delete()){
                $response['message'] = 'Sorry, could not delete details record at the moment';
            }else{
                $response['error'] = false;
                $response['message'] = 'Success, stock details record has been deleted.';
            }

        }

        return $this->respond($request,$response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $buy = StockBuy::with(['basket'=>function($q){
            $q->where('user_id',\Auth::id());
        }])->find($id);

        $response = ['error'=>true,'message'=>'Invalid Request'];

        if(! is_null($buy) && !is_null($buy->basket)){
            if(!$buy->delete()){
                $response['message'] = 'Sorry, could not delete stock buy record at the moment';
            }else{
                $response['error'] = false;
                $response['message'] = 'Success, stock stock buy record has been deleted.';
            }
        }

        return $this->respond($request,$response);
    }

    private function respond(Request $request, array $data,$route = 'member.stock.index')
    {
        if($request->ajax()){ return $data;}

        return redirect()->route($route)->with($data['error'] ? 'warning' : 'success',$data['message']);
    }
}
