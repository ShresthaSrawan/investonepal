<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SectorFormRequest extends Request
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
            'label' => 'required|alpha_spaces|unique:sector,label'
        ];

        if($this->isMethod('put')){
            $rules['label'] = 'required|alpha_spaces|unique:sector,label,'.$this->sector;
        }
        
        return $rules;
    }
}
