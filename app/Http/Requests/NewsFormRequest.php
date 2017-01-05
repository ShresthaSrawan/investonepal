<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class NewsFormRequest extends Request
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
            'newsCategory' => 'required|exists:news_category,id',
            'title' => 'required',
            'pub_date' => 'required|date',
            'details' => 'required',
            'user_id'=>'required|exists:user,id', 
            'featured_image' =>  'required_multiple|mimes_multiple:png,jpg,jpeg,gif|max_file_size:2048',
			'tags'=>'required'
        ];


        if($this->has('event') && $this->get('event') == 1){
            $rules['start_date'] = 'required|date';
        }

        if($this->has('company_id') && $this->get('company_id') != 0){
            $rules['company_id'] = 'required|exists:company,id';
        }
        if($this->has('bullion_id') && $this->get('bullion_id') != 0){
            $rules['bullion_id'] = 'required|exists:bullion_type,id';
        }

        if($this->isMethod('put')):
            $rules['featured_image'] = 'mimes_multiple:png,jpg,jpeg,gif|max_file_size:2048' ;
        endif;

        return $rules;
    }

    public function messages()
    {
        return [
            'featured_image.required_multiple' => 'Featured image is required.',
            'featured_image.mimes_multiple' => 'Featured image must be of file type png, jpg or jpeg.',
        ];
    }
}
