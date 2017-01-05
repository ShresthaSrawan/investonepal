<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMBullionSellFormRequest extends Request
{
    public function authorize()
    {
        return (!\Auth::check()) ? false : true;
    }

    public function rules()
    {
        return [
            'buy_id' => 'required|exists:am_bullion,id',
            'sell_date' =>'date',
            'sell_quantity' => 'required|numeric',
            'sell_price' =>'required|numeric'

        ];
    }
}
