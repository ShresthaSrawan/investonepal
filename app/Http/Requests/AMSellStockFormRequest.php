<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMSellStockFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if( ! \Auth::check() ){
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stock_id' => 'required|exists:am_stocks_buy,id',
            'sell_date' => 'date',
            'sell_quantity' => 'required|numeric',
            'sell_rate' => 'required|numeric',
            'sell_commission' => 'numeric',
            'sell_tax' => 'numeric',
        ];
    }
}
