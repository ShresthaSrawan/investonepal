<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMCurrencyFormRequest extends Request
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
            'type' => 'required|exists:currency_type,id',
            'buy_date' => 'date',
            'total_amount' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }
}
