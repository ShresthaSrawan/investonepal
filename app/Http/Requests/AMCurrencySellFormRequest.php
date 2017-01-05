<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMCurrencySellFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (!\Auth::check()) ? false : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'buy_id' => 'required|exists:am_currency,id',
            'sell_date' =>'date',
            'sell_quantity' => 'required|numeric',
            'sell_amount' => 'required|numeric'

        ];
    }
}
