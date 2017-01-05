<?php

namespace App\Http\Requests;
use Session;

use App\Http\Requests\Request;

class ClientFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'unique:user,username|required|alpha_dash|min:2',
            'email' => 'unique:user,email|required|email',
            'password'=>'required|min:6|confirmed',
            'password_confirmation'=>'required|min:6',
            'g-recaptcha-response' => 'required|captcha'
        ];
        Session::flash('registerURL',true);
        return $rules;
    }
}
