<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class ReportUploadRequest extends Request
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
            'file' => 'required|mimes:xls|max_file_size:1024'
        ];
    }
}
