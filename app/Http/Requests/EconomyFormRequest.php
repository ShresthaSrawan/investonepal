<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class EconomyFormRequest extends Request
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
            'fiscal_year_id' => 'required|exists:fiscal_year,id|unique:economy,fiscal_year_id',
            'label' => 'required',
            'value' => 'required',
            'date'  => 'required',
        ];

        if($this->isMethod('put')){
            $rules['fiscal_year_id'] = 'required|exists:fiscal_year,id|unique:economy,fiscal_year_id,'.$this->economy;
        }

        if($this->has('label')):
            foreach($this->get('label') as $key=>$value):
                $rules['label.'.$key] = 'required|exists:economy_label,id';
            endforeach;
        endif;

        if($this->has('value')):
            foreach($this->get('value') as $key=>$value):
                $rules['value.'.$key] = 'required';
            endforeach;
        endif;

        if($this->has('date')):
            foreach($this->get('date') as $key=>$value):
                $rules['date.'.$key] = 'required|date';
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

        if($this->has('label')):
            foreach($this->get('label') as $key=>$value):
                $messages['label.'.$key.'.required'] = 'Label field is required.';
                $messages['label.'.$key.'.exists'] = 'The selected label is invalid.';
            endforeach;
        endif;

        if($this->has('value')):
            foreach($this->get('value') as $key=>$value):
                $messages['value.'.$key.'.required'] = 'Value field is required.';
                $messages['value.'.$key.'.numeric'] = 'The value must be a number.';
            endforeach;
        endif;

        if($this->has('date')):
            foreach($this->get('date') as $key=>$value):
                $messages['date.'.$key.'.required'] = 'Date field is required.';
                $messages['date.'.$key.'.date'] = 'The date field is not a valid date.';
            endforeach;
        endif;

        return $messages;
    }
}
