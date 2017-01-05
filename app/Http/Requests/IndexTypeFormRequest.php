<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class IndexTypeFormRequest extends Request
{
    public function authorize()
    {
        if( ! Auth::check()) 
        {
            return false;
        }

        return true;
    }

    public function rules()
    {    
        if($this->isMethod('put')){
            $rules['name'] = 'required|alpha_spaces|unique:index_type,name,'.$this->indexType;
        }else
        {
            $rules = [
            'label' => 'required|alpha_spaces|unique:index_type,name'
        ];}
        
        return $rules;
    }
}
