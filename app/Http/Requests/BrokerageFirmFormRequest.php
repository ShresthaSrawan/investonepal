<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class BrokerageFirmFormRequest extends Request
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
        $updateRules = [];
        if($this->isMethod('put')){
            $rules['code'] = 'required|alpha_num|unique:brokerage_firm,code,'.$this->brokerageFirm;

            $updateRules = [
                'address' => 'address',
                'mobile' => 'alpha_dash|min:7',
                'photo'=>'max_file_size:2048|mimes:png,jpg,jpeg',
                'firm_name' => 'required'
            ];
            return array_merge($rules,$updateRules);
        }else{
            $rules = [
                'code' => 'required|alpha_num|unique:brokerage_firm,code',
                'address' => 'address',
                'mobile' => 'alpha_dash|min:7',
                'photo'=>'max_file_size:2048|mimes:png,jpg,jpeg',
                'firm_name' => 'required'
            ];
            return $rules;
        }
    }

    public function messages (){
        $messages =[
            'address.address' => 'Address may only contain alphabets, number and dash.'
        ];
        return $messages;
    }
}
