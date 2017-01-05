<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class BasePriceFormRequest extends Request
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

    public function rules()
    {
        if ($this->isMethod('put')) {
            $rules =[
                'price' => 'required|numeric'
            ];
        }
        elseif ($this->isMethod('post') || $this->price =='0' || $this->price ==""){
            $rules = [
                'price' => 'required|numeric',
                'fiscalYear_id'=>'required|exists:fiscal_year,id',
                'date' => 'required|date'
            ];
        }

        return $rules;
    }
}
