<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class MarketIndexFormRequest extends Request
{
    public function authorize()
    {
        if( ! Auth::check()) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        if($this->isMethod('put')){
            foreach($this->request->get('value') as $key => $val)
            {
                $rules['value.'.$key] = 'required|numeric';
            }
            return $rules;
        }
        else{
            $rules['date'] = 'required|date|unique:index,date';
            foreach($this->request->get('value') as $key => $val)
            {
                $rules['value.'.$key] = 'required|numeric';
            }
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'date.unique'  => 'Index value of the specified date and type already exists.',
            ];
    }
}
