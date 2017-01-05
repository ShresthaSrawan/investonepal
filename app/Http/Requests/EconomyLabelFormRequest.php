<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class EconomyLabelFormRequest extends Request
{
    public function authorize()
    {
        if ( ! Auth::check() ):
            return false;
        else:
            return true;
        endif;
    }

    public function rules()
    {
        if($this->isMethod('put')){
                $rules['name'] = 'required|unique:economy_label,name,'.$this->economyLabel;
        }

        $rules = 
                [
                    'name' => 'required|unique:economy_label,name',
                ];

        return $rules;
    }
}