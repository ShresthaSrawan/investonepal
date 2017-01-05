<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class ReportFormRequest extends Request
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
            'reportLabel' => 'required',
            'value' => 'required',
        ];

        if($this->has('reportLabel')):
            foreach ($this->get('reportLabel') as $key => $value):
                $rules['reportLabel.'.$key] = 'required|exists:report_label,id';
            endforeach;
        endif;

        if($this->has('value')):
            foreach ($this->get('value') as $key => $val):
                $rules['value.'.$key] = 'required|numeric';
            endforeach;
        endif;

        return $rules;
    }

    public function messages()
    {
        $messages=[];
        if($this->has('reportLabel')):
            foreach ($this->get('reportLabel') as $key => $value):
                $messages['reportLabel.'.$key.'.required'] = 'Report Label is required.';
                $messages['reportLabel.'.$key.'.exist'] = 'Report Label is invalid.';
            endforeach;
        endif;

        if($this->has('value')):
            foreach ($this->get('value') as $key => $value):
                $messages['value.'.$key.'.required'] = 'Value is required.';
                $messages['value.'.$key.'.numeric'] = 'Value must be numeric.';
            endforeach;
        endif;

        return $messages;
    }
}
