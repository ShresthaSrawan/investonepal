<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMPropertyFormRequest extends Request
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
            'asset_name' => 'required',
            'unit' => 'required',
            'buy_date' => 'date',
            'quantity' => 'required|numeric',
            'buy_rate' => 'required|numeric',
            'market_rate' => 'numeric',
            'market_date' => 'date',
        ];
    }
}
