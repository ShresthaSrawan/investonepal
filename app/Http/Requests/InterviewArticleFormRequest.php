<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class InterviewArticleFormRequest extends Request
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
        $externalRules=[];
        $interviewRules=[];

        $rules = [
            'newsCategory' => 'required|exists:news_category,id',
            'title' => 'required',
            'pub_date' => 'required|date',
            'details' => 'required',
            'featured_image' =>  'required_multiple|mimes_multiple:png,jpg,jpeg,gif|max_file_size:2048'
        ];

        if($this->has('user_id')){
            $rules['user_id'] = 'required|exists:user,id';
        }

        if($this->get('source') == "external"){
            $externalRules = [
                'externalDetail.name' => 'required',
                'externalDetail.organization' => 'required',
                'externalDetail.address' => 'required|address',
                'externalDetail.contact' => 'required',
                'external_photo' => 'mimes:png,jpg,jpeg,gif|max_file_size:2048'
            ];
        }
        if($this->get('type')==0){
            $interviewRules = [
                'intervieweDetail.name' => 'required',
                'intervieweDetail.address' => 'address',
                'interviewe_photo' => 'mimes:png,jpg,jpeg,gif|max_file_size:2048',
            ];
        }

        $rules = array_merge($rules,$interviewRules,$externalRules);

        if($this->isMethod('put')):
            $rules['featured_image'] = 'mimes_multiple:png,jpg,jpeg,gif|max_file_size:2048';
        endif;
        
        return $rules;
    }

    public function messages ()
    {
        $messages =[
            'subject_address.address' => 'Address may only contain alphabets, number and dash.',
            'address.address' => 'Address may only contain alphabets, number and dash.',
            'featured_image.mimes_multiple' => 'Featured image must be of file type png, jpg or jpeg.',
            'featured_image.required_multiple' => 'At least one featured image is required.'
        ];
        return $messages;
    }
}
