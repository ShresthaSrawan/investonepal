<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMStockBuyFormRequest extends Request
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

    public function rules()
    {
        return [
            'basket_id' => 'required|exists:am_stock_basket,id',
            'company' => 'required|exists:company,id',
            'type' => 'required|exists:am_stock_types,id',
            'buy_date' => 'date',
            'buy_rate' => 'required|numeric',
            'quantity' => 'required|numeric',
            'commission' => 'numeric',
        ];
    }
}
