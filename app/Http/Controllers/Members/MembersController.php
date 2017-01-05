<?php

namespace App\Http\Controllers\Members;

use App\Models\AssetsManagement\Basket;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\BullionType;
use App\Models\CurrencyType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{

    public function index()
    {
		return redirect()->route('member.stock.index');
        return view('members.index');
    }

    public function bullion()
    {
        $bullion = BullionType::all()->lists('name','id')->toArray();
        return view('members.portfolio.bullion',compact('bullion'));
    }

    public function currency()
    {
        $currency = CurrencyType::all()->lists('name','id')->toArray();
        return view('members.portfolio.currency',compact('currency'));
    }

    public function property()
    {
        return view('members.portfolio.property');
    }

    public function fetchAll(Request $request)
    {
        $baskets = Basket::with('stockBuy.sell')->where('user_id',\Auth::id())->get();
        //$property = Basket::with('stockBuy.sell')->where('user_id',\Auth::id())->get();

        $stock_imc = $property_imc = $bullion_imc = $currency_imc 
            = ['investment'=>0,'market_value'=>0,'change'=>0];

        foreach ($baskets as $basket) {
            foreach ($basket->stockBuy as $stock) {
                $quantity = $stock->quantity;
                $rate = $stock->buy_rate + ($stock->commission/$stock->quantity);

                foreach ($stock->sell as $stockell) { $quantity -= $stockell->quantity; }

                $stock_imc['investment'] += ($rate * $quantity); 
                $stock_imc['market_value'] += ($stock->close_price * $quantity);
                $stock_imc['change'] = $stock_imc['market_value'] - $stock_imc['investment'];
            }
        }

        return $stock_imc;



    }
}
