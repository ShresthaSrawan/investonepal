<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class NewsCategoryFormRequest extends Request
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
            'label' => 'required|alpha_spaces|unique:news_category,label'
        ];

        if($this->isMethod('put')){
            $rules['label'] = 'required|alpha_spaces|unique:news_category,label,'.$this->newsCategory;
        }
        
        return $rules;
    }
}
