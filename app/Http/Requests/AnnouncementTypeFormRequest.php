<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class AnnouncementTypeFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()) return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['label' => "required|alpha_spaces|min:3|unique:announcement_type,label"];

        if($this->isMethod('put')):
            $rules = ['label' => "required|alpha_spaces|min:3|unique:announcement_type,label,".$this->announcement_type];
        endif;

        return $rules;

    }
}
