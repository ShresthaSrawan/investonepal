<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'am_stock_basket';
    protected $fillable = ['name','user_id'];
    protected $hidden = ['user_id'];

    public function stockBuy()
    {
		  $lastPrices = "select `price`.`company_id` as `cid`, `price`.`date` as `close_date`
                      , `price`.`close` as `close_price` from `todays_price` as `price`
                      INNER JOIN `last_traded_price` as `ltp`
                      on `price`.`company_id` = `ltp`.`company_id`
                      and `price`.`date` = `ltp`.`date`";
		
        return $this->hasMany('App\Models\AssetsManagement\StockBuy','basket_id','id')
            ->leftJoin(\DB::raw('('.$lastPrices.') as latest_price'),'am_stocks_buy.company_id','=','latest_price.cid')
            ->orderBy('buy_date','desc');
    }

    public function stock()
    {
        return $this->hasMany('App\Models\AssetsManagement\StockBuy','basket_id','id');
    }

    public static function getTabular()
    {
        $baskets = static::with('stockBuy.sell')->get();
        $result = [];
        foreach($baskets as $basket):
            $bskt['id'] = $basket->id;
            $bskt['name'] = $basket->name;
            $bskt['investment'] = 0;
            $bskt['value'] = 0;
            $bskt['profit'] = 0;
            $bskt['profit_percent'] = 0;
            $bskt['url'] = route('member.stock.show',$basket->id);

            foreach($basket->stockBuy as $stock):
                $quantity = $stock->quantity;
                foreach($stock->sell as $sell):
                    $quantity -= $sell->quantity;
                endforeach;
                $bskt['investment'] += $quantity * $stock->buy_rate;

                $closePrice = is_null($stock->close_price) || $stock->close_price == '' ? 0 : $stock->close_price;
                $bskt['value'] += $quantity * $closePrice;
            endforeach;

            $bskt['profit'] = $bskt['value'] - $bskt['investment'];
            $bskt['profit_percent'] = ($bskt['investment'] == 0) ? 0 : round(($bskt['profit'] / $bskt['investment']) * 100, 2);
            $result[] = $bskt;
        endforeach;

        return $result;
    }
}
