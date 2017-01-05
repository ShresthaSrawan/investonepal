<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class NepseGroupFormRequest extends Request
{
    public function authorize()
    {
        if(!Auth::check()):
            return false;
        endif;

        return true;
    }

    public function rules()
    {
        $rules = [
            'fiscal_year_id' => 'required|exists:fiscal_year,id|unique:nepse_group,fiscal_year_id',
            'company' => 'required',
            'grade' => 'required',
        ];

        if($this->has('company')):
            foreach($this->get('company') as $key=>$value):
                $rules['company.'.$key] = 'required|exists:company,id';
            endforeach;
        endif;

        if($this->has('grade')):
            foreach($this->get('grade') as $key=>$value):
                $rules['grade.'.$key] = 'required|alpha';
            endforeach;
        endif;

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'fiscal_year_id.required' => 'Fiscal Year field is required.',
            'fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'fiscal_year_id.unique' => 'The fiscal year has already been taken.',
        ];

        if($this->has('company')):
            foreach($this->get('company') as $key=>$value):
                $messages['company.'.$key.'.required'] = 'Company field is required.';
                $messages['company.'.$key.'.exists'] = 'The selected company is invalid.';
            endforeach;
        endif;

        if($this->has('grade')):
            foreach($this->get('grade') as $key=>$value):
                $messages['grade.'.$key.'.required'] = 'Grade field is required.';
                $messages['grade.'.$key.'.numeric'] = 'The grade must be a alphabetical.';
            endforeach;
        endif;

        return $messages;
    }
}
