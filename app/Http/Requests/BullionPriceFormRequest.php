<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class BullionPriceFormRequest extends Request
{
    public function authorize()
    {
        if ( ! Auth::check() )
        {
            return false;
        }
        return true;
    }

    public function rules()
    {
        if($this->isMethod('put')){
            foreach($this->request->get('price') as $key => $val)
            {
                $rules['price.'.$key] = 'required|numeric';
            }
            return $rules;
        }
        else{
            $rules['date'] = 'required|date';
            foreach($this->request->get('price') as $key => $val)
            {
                $rules['price.'.$key] = 'required|numeric';
            }
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'date.unique'  => 'Bullion price of the specified date and type already exists.',
            ];
    }
}
