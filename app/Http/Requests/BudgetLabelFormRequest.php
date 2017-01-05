<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class BudgetLabelFormRequest extends Request
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
        $rules = 
                [
                    'label' => 'required|unique:budget_label,label',
                ];
                
        if($this->isMethod('put')){
            $rules['label'] = 'required|unique:budget_label,label,'.$this->budgetLabel;
        }


        return $rules;
    }
}

