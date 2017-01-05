<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class EnergyTypeFormRequest extends Request
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
            'name' => 'required|alpha_spaces|unique:energy_type,name',
            'unit' => 'required'
        ];

        if($this->isMethod('put')){
            $rules['name'] = 'required|alpha_spaces|unique:energy_type,name,'.$this->energyType;
        }
        return $rules;
    }
}
