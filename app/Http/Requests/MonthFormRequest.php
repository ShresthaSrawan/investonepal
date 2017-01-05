<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class MonthFormRequest extends Request
{
    public function authorize()
    {
        if(!Auth::check()){
          return false;
        }
        return true;
    }

    public function rules()
    {
        if($this->isMethod('put')){
            $rules['label'] = 'required|alpha_spaces|unique:month,label,'.$this->month;
        }
        else
        {
            $rules = [
                'label' => 'required|alpha_spaces|unique:month,label'
            ];
        }
        return $rules;
    }
}
