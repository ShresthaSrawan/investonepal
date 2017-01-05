<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyTypeFormRequest extends Request
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
        $rules = [
            'label' => 'required|alpha_spaces|unique:currency_type,label',
            'unit' => 'required',
            'country_name'=>'required|alpha_spaces',
            'country_flag'=>'required|mimes:png,jpg,jpeg|max_file_size:2048'
        ];

        
        if($this->isMethod('put')){
            $rules['label'] = 'required|alpha_spaces|unique:currency_type,label,'.$this->currencyType;
        }
        
       return $rules;
    }
}
