<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class BasePriceUploadRequest extends Request
{
    public function authorize()
    {
        if(!Auth::check()):
            return false;
        endif;

        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:xls,xlsx|max_file_size:1024'
        ];
    }
}
