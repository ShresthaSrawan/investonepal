<?php
namespace App\Transformer;

use App\Transformer\TransformerContract;

class BullionTransformer implements TransformerContract
{
	public function transform($engine)
  {
    return $engine
		->addColumn('buy_rate',function($bullion){
        return $bullion->total_amount/$bullion->quantity;
        })
        ->addColumn('url',function($bullion){
            return route('member.bullion.update',$bullion->id);
        })
        ->editColumn('sell',function($bullion){
            $buy_rate = $bullion->total_amount / $bullion->quantity;
            $unit = explode(' ', $bullion->type->unit);
            $prefix = end($unit);
            foreach ($bullion->sell as $sell) {
              $sell->url = route('member.bullion-sell.update',$sell->id);
              $sell->sell_rate = round($sell->sell_price / $sell->quantity,2)."/{$prefix}";
              $sell->squantity = $sell->quantity." {$prefix}";
              $sell->profit_loss = $sell->sell_price - $buy_rate * $sell->quantity;
            }
            return $bullion->sell;
        })
        ->addColumn('remaining_quantity',function($bullion){
            $quantity = $bullion->quantity;

            foreach ($bullion->sell as $sell) { $quantity -= $sell->quantity;}

            return $quantity;
        })
        ->addColumn('investment',function($bullion){
            if(empty($bullion->sell))
              return number_format($bullion->total_amount,2);

            $quantity = $bullion->quantity;
            foreach ($bullion->sell as $sell) {
              $quantity -= $sell->quantity;
            }

            return $quantity*($bullion->total_amount/$bullion->quantity);

        })
        ->addColumn('market_rate',function($bullion){
            if(is_null($bullion->last_price)) return null;

            $unit = explode(' ', $bullion->type->unit);
            $unitAmount = (int) $unit[0];

            return $bullion->last_price/$unitAmount;

        })
        ->addColumn('market_value',function($bullion){
            if(is_null($bullion->last_price)) return null;

            $unit = explode(' ', $bullion->type->unit);
            $unitAmount = (int) $unit[0];
            $quantity = $bullion->quantity;

            foreach ($bullion->sell as $sell) { $quantity -= $sell->quantity;}

            return $quantity*($bullion->last_price/$unitAmount);
        })
        ->addColumn('change',function($bullion){
            if(is_null($bullion->last_price)) return null;

            $unit = explode(' ', $bullion->type->unit);
            $unitAmount = (int) $unit[0];
            $quantity = $bullion->quantity;

            foreach ($bullion->sell as $sell) { $quantity -= $sell->quantity;}

            $investment = $quantity*($bullion->total_amount/$bullion->quantity);
            $market_value = $quantity*($bullion->last_price/$unitAmount);
            $change =  $market_value - $investment;

            return [
              'amount' => $change,
              'percent' => $investment == 0 ? 0 : ($change/$investment)*100
            ];
        });
	}
}