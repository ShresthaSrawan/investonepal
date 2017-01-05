<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class FloorSheetUploadRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::check()):
            return false;
        endif;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['file' => 'required|excel'];
    }

    public function messages()
    {
        return ['file.excel' => 'The file must be a valid excel file (xls, xlsx).'];
    }
}
