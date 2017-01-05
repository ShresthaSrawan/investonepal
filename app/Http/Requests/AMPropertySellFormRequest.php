<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMPropertySellFormRequest extends Request
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
            'property_id' => 'required|exists:am_property,id',
            'sell_date' => 'date',
            'sell_rate' => 'required|numeric',
            'sell_quantity' => 'required|numeric',
        ];
    }
}
