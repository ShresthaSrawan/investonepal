<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UserFormRequest extends Request
{
    public function authorize()
    {
        if (! Auth::check()) {
            return false;
        }
        return true;
    }

    public function rules()
    {
        $updateRules = [];
        if ($this->isMethod('put')) {
            $rules['username'] = 'required|alpha_dash|unique:user,username,'.$this->user;
            $rules['email'] = 'required|email|unique:user,email,'.$this->user;

            $updateRules = [
                'userInfo.first_name' => 'alpha_spaces|min:2',
                'userInfo.last_name' => 'alpha_spaces|min:2',
                'userInfo.address' => 'address',
                'userInfo.work' => 'alpha_spaces',
                'userInfo.dob' => 'date',
                // 'userInfo.phone' => 'alpha_dash|min:7|max:15',
                'password'=>'alpha_num|min:6|confirmed',
                'password_confirmation'=>'alpha_num|min:6',
                'profile_picture' => 'max_file_size:2048|mimes:png,jpg,jpeg,gif',
                'expiry_date' => 'required|date'
            ];
            return array_merge($rules, $updateRules);
        } else {
            $rules = [
                'userInfo.first_name' => 'alpha_spaces|min:2',
                'userInfo.last_name' => 'alpha_spaces|min:2',
                'userInfo.address' => 'address',
                'userInfo.work' => 'alpha_spaces',
                'userInfo.dob' => 'date',
                // 'userInfo.phone' => 'alpha_dash|min:7|max:15',
                'username' => 'unique:user,username|required|alpha_dash|min:2',
                'email' => 'unique:user,email|required|email',
                'password'=>'required|alpha_num|min:6|confirmed',
                'password_confirmation'=>'required|alpha_num|min:6',
                'profile_picture' => 'max_file_size:2048|mimes:png,jpg,jpeg,gif',
                'expiry_date' => 'required|date'
            ];
            return $rules;
        }
    }

    public function messages()
    {
        $messages =[
            'userInfo.address.address' => 'Address may only contain alphabets, number and dash.'
        ];
        return $messages;
    }
}
