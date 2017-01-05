<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class BodFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Auth::check() )
        {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required',
            'photo'=> 'mimes:jpeg,jpg,png|max_file_size:2048',
            'fiscal_year'=> 'required|exists:fiscal_year,id',
            'post_id'=> 'required|exists:bod_post,id'
        ];
    }
}
