<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class FinancialReportFormRequest extends Request
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
        if($this->isMethod('put')){
            return [
            'fiscal_year_id' => 'required|exists:fiscal_year,id',
            'quarter_id' => 'required|exists:quarter,id',
            'entry_by' => 'required|alpha_spaces',
            'entry_date' => 'required|date'
            ];
        }
        return [
        'fiscal_year_id' => 'required|exists:fiscal_year,id',
        'company_id' => 'required|exists:company,id',
        'quarter_id' => 'required|exists:quarter,id',
        'entry_by' => 'required|alpha_spaces',
        'entry_date' => 'required|date'
        ];
    }
}
