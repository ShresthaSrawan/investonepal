<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UserProfileFormRequest extends Request
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $id = Auth::user()->id;

        return [
            'username' => 'required|alpha_dash|unique:user,username,' .  $id,
            'email' => 'required|email|unique:user,email,' . $id,
            'profile_picture' => 'max_file_size:2048|mimes:png,jpg,jpeg,gif',
            'password'=>'min:6|confirmed',
            'password_confirmation'=>'min:6',
            'userInfo.first_name' => 'required|alpha_spaces|min:2',
            'userInfo.last_name' => 'required|alpha_spaces|min:2',
            'userInfo.address' => 'address',
            'userInfo.dob' => 'date',
            'userInfo.phone' => 'alpha_dash|min:7|max:15',
        ];
    }

    public function messages ()
    {
        return [
            'userInfo.address.address' => 'Address may only contain alphabets, number and dash.'
        ];
    }
}
