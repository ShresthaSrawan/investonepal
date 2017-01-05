<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class ReportLabelFormRequest extends Request
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
                $rules['label'] = 'required|alpha_num_spaces|unique:report_label,label,'.$this->reportLabel;
        }

        $rules = 
                [
                    'label' => 'required|alpha_num_spaces|unique:report_label,label',
                ];

        return $rules;
    }
}
