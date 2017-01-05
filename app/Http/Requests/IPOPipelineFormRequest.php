<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class IPOPipelineFormRequest extends Request
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
            'issue_manager'=>'required',
            'company_id'=>'required',
            'fiscal_year_id'=>'required',
            'announcement_subtype_id'=>'required',
            'amount_of_securities'=>'numeric',
            'amount_of_public_issue'=>'required|numeric',
            'approval_date'=>'date',
            'application_date'=>'required|date',
            'remarks'=>'alpha_spaces'
        ];
    }
}
