<?php

namespace App\Http\Controllers\Members;

use App\Models\AssetsManagement\Basket;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use yajra\Datatables\Datatables;

class BasketController extends Controller
{
    public function store(Requests\AMBasketFormRequest $request)
    {
        $response['error'] = FALSE;
        try{
            $basket = Basket::create(['name'=>$request->get('basket_name'),'user_id'=>Auth::id()]);
            if(!$basket):
                throw new \Exception('Basket could not be created.');
            endif;

            $response['data'] = $basket;
            $response['message'] = $request->get('basket_name').' basket has been created.';
        }catch (\Exception $e){
            $response['error'] = TRUE;
            $response['message'] = $e->getMessage();
        }

        if($request->isXmlHttpRequest()):
            return $response;
        elseif($response['error'] == true):
            return redirect()->route('member.stock.index')->with('warning','Basket could not be created.');
        else:
            return redirect()->route('member.stock.show',$basket->id)->with('success','Basket has been created.');
        endif;
    }

    public function update(Requests\AMBasketFormRequest $request, $id)
    {
        $error = true;
        $basket = Basket::where('id',$id)->where('user_id',Auth::id())->first();

        if(is_null($basket)):
            $message = 'Basket not found';
        else:
            $basket->name = $request->get('basket_name');
            if($basket->save()):
                $error = false;
                $message = 'Basket has been updated.';
            else:
                $message = 'Could not be updated.';
            endif;
        endif;

        if($request->isXmlHttpRequest()):
            return ['error' => $error, 'message'=> $message];
        else:
            $error ?  Session::put('warning',$message) : Session::put('success',$message);
            return redirect()->route('member.stock.index');
        endif;

    }

    public function fetch(Request $request)
    {
      $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                    , `price`.`close` as `close_price` from `todays_price` as `price`
                    INNER JOIN `last_traded_price` as `ltp`
                    on `price`.`company_id` = `ltp`.`company_id`
                    and `price`.`date` = `ltp`.`date`";

      $stockWithLastPrice = \DB::table('am_stock_basket as basket')
      ->leftjoin('am_stocks_buy as stock', 'basket.id', '=', 'stock.basket_id')
      ->leftJoin('am_stocks_sell as sell', 'sell.buy_id', '=','stock.id')
      ->leftjoin('company', 'stock.company_id', '=','company.id')
      ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'stock.company_id','=','latest_price.cid')
      ->selectRaw('
          (ifnull(CAST(sum(sell.quantity) AS SIGNED), 0)) as sell_quantity,
          (stock.quantity - ifnull(CAST(sum(sell.quantity) AS SIGNED),0)) as remaining_quantity,
          (stock.commission / stock.quantity) as commission_per_quantity,
          stock.commission, stock.buy_rate, stock.quantity as buy_quantity,
          latest_price.close_date, latest_price.close_price, stock.company_id, stock.id,
          basket.id as basket_id, basket.name as basket_name, company.name as company_name
          '
      )
      ->groupBy('stock.id')
      ->where('basket.user_id', auth()->id());

      $stockWithComputedValues = \DB::table(
          \DB::raw('('.$stockWithLastPrice->toSql().') as stock')
      )
      ->addBinding($stockWithLastPrice->getBindings())
      ->selectRaw('
          stock.*,
          (@investment:= (
              (remaining_quantity * buy_rate)  + (commission_per_quantity * remaining_quantity)
          )) as investment,
          @market_value:= (remaining_quantity * close_price) as market_value,
          @market_value - @investment as profit_loss
      ');

      $stockGroupedByCompany = \DB::table(
          \DB::raw('('.$stockWithComputedValues->toSql().') as sc')
      )
      ->addBinding($stockWithComputedValues->getBindings())
      ->selectRaw('
          basket_id as id, basket_name as name, company_name, company_id,
          sum(investment) as investment, sum(market_value) as market_value, sum(profit_loss) as profit_loss
      ')
      ->groupBy('basket_id')
      ->groupBy('company_id');

      $stockGroupedByBasket = \DB::table(
          \DB::raw('('.$stockGroupedByCompany->toSql().') as basket')
      )
      ->addBinding($stockGroupedByCompany->getBindings())
      ->selectRaw('
          id, name, sum(investment) as investment, sum(market_value) as market_value, sum(profit_loss) as profit_loss
      ')
      ->groupBy('id');

      return $dt = Datatables::of($stockGroupedByBasket)->make(true);
    }

    public function destroy(Request $request, $id)
    {
        $basket = Basket::where('user_id',Auth::id())->where('id',$id)->first();
        $error = true;
        if(is_null($basket)){
            $message = 'Basket not found.';
        }else{
          $stock_count = $basket->stock()->count();

          if($stock_count == 0) {
            if($basket->delete()){
              $error = false;
              $message = 'Basket has been successfully deleted.';
            }else{
              $message = 'Basket could not be deleted.';
            }
          }else {
            $message = 'Basket cannot be deleted. Delete stocks first.';
          }
        }

        if($request->isXmlHttpRequest()){
            return ['error'=>$error,'message'=>$message];
        }

        return redirect()->route('member.stock.index')->with($error ? 'warning' : 'success',$message);
    }
}
