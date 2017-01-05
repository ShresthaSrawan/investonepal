<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class FiscalYearFormRequest extends Request
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
            $rules['label'] = 'required|unique:fiscal_year,label,'.$this->fiscalYear;
        }
        else{
            $rules = [
                'fiscalYear' => 'required|unique:fiscal_year,label'
            ];
        }
        return $rules;
    }

    public function messages (){
        $messages =[
            'label.unique' => 'Duplicate fiscal year found.'
        ];
        return $messages;
    }
}
