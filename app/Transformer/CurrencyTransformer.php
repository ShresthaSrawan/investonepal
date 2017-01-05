<?php
/**
 * Created by PhpStorm.
 * User: Roshan Kharel
 * Date: 2/13/2016
 * Time: 1:39 PM
 */

namespace App\Transformer;

class CurrencyTransformer implements TransformerContract
{

    public function transform($engine)
    {
        return $engine
            ->addColumn('url',function($currency){
                return route('member.currency.update',$currency->id);
            })
            ->editColumn('sell',function($currency){
                $buy_rate = $currency->total_amount / $currency->quantity;
                $unit = explode(' ', $currency->type->unit);
                $prefix = end($unit);
                foreach ($currency->sell as $sell) {
                    $sell->url = route('member.currency-sell.update',$sell->id);
                    $sell->sell_rate = round($sell->sell_amount / $sell->quantity,2);
                    $sell->profit_loss = $sell->sell_amount - ($buy_rate * $sell->quantity);
                }

                return $currency->sell;
            })
            ->addColumn('investment',function($currency){
                if(empty($currency->sell))
                    return $currency->total_amount;

                return $currency->remaining_quantity*($currency->total_amount/$currency->quantity);
            })
            ->addColumn('market_rate',function($currency){
                if(is_null($currency->last_sell)) return null;

                $unit = explode(' ', $currency->type->unit);
                $unitAmount = (int) $unit[0];

                return $currency->last_sell/$unitAmount;
            })
            ->addColumn('market_value',function($currency){
                if(is_null($currency->last_sell)) return null;

                $unit = explode(' ', $currency->type->unit);
                $unitAmount = (int) $unit[0];

                $quantity = $currency->remaining_quantity;

                return $quantity*($currency->last_sell/$unitAmount);
            })
            ->addColumn('change',function($currency){
                if(empty($currency->sell))
                    return $currency->total_amount;

                $unit = explode(' ', $currency->type->unit);
                $unitAmount = (int) $unit[0];

                $investment = $currency->remaining_quantity*($currency->total_amount/$currency->quantity);
                $market_value = $currency->remaining_quantity*($currency->last_sell/$unitAmount);

                $change =  $market_value - $investment;

                return [
                    'amount' => $change,
                    'percent' => ($investment == 0) ? 0 : ($change/$investment)*100
                ];
            });
    }
}