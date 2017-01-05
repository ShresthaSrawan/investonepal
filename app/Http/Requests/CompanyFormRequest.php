<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class CompanyFormRequest extends Request
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
            $rules['quote'] = 'required|alpha_dash|unique:company,quote,'.$this->company;
            $rules['name'] = 'required|unique:company,name,'.$this->company;

            $updateRules = [
                // 'details.phone' => 'alpha_dash|min:7',
                'logo'=>'max_file_size:2048|mimes:png,jpg,jpeg,gif',
                'listed_shares' => 'numeric',
                'face_values' => 'numeric',
            ];
            return array_merge($rules, $updateRules);
        } else {
            $rules = [
                // 'details.phone' => 'alpha_dash|min:7',
                'logo'=>'max_file_size:2048|mimes:png,jpg,jpeg,gif',
                'quote' => 'required|alpha_dash|unique:company,quote',
                'name' => 'required|unique:company,name',
                'listed_shares' => 'numeric',
                'face_values' => 'numeric',
            ];
            return $rules;
        }
    }

    public function messages()
    {
        $messages =[
            'address.address' => 'Address may only contain alphabets, number and dash.'
        ];
        return $messages;
    }
}
