<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMStockDetailsFormRequest extends Request
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
            'stock_id' => 'required|exists:am_stocks_buy,id',
            'fiscal_year' => 'required|exists:fiscal_year,id',
            'stock_dividend' => 'numeric',
            'cash_dividend' => 'numeric',
            'right_share' => 'numeric',
        ];
    }
}
