<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyRateFormRequest extends Request
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
            foreach($this->request->get('buy') as $key => $val)
            {
                $rules['buy.'.$key] = 'required|numeric';
            }
            foreach($this->request->get('sell') as $key => $val)
            {
                $rules['sell.'.$key] = 'numeric';
            }
            return $rules;
        }
        else{
            $rules['date'] = 'required|date|unique:currency,date';
            foreach($this->request->get('buy') as $key => $val)
            {
                $rules['buy.'.$key] = 'required|numeric';
            }
            foreach($this->request->get('sell') as $key => $val)
            {
                $rules['sell.'.$key] = 'numeric';
            }
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'date.unique'  => 'Currency rate of the specified date and type already exists.',
            ];
    }
}
