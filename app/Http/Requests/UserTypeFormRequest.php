<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UserTypeFormRequest extends Request
{
    public function authorize()
    {
        if( ! Auth::check() ){
            return false;
        }
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|alpha_spaces|unique:user_type,label,'.$this->userType
        ];
    }
}
