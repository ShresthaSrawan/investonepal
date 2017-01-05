<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IssueManagerFormRequest extends Request
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
            $rules['company'] = 'required|unique:issue_manager,company,'.$this->issueManager;

            $updateRules = [
                'name' => 'required',
                'phone' => 'alpha_dash|min:7',
                'email' => 'email'
            ];
            return array_merge($rules,$updateRules);
        }else{
            $rules = [
                'company' => 'required|unique:issue_manager,company',
                'name' => 'required',
                'phone' => 'alpha_dash|min:7',
                'email' => 'email'
            ];
            return $rules;
        }
    }
}
