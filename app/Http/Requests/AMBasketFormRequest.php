<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AMBasketFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if( ! \Auth::check() ){
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
        $rules = [];
        $id = $this->basket;
        $name = $this->basket_name;
        $user = \Auth::id();
        $basket = \DB::table('am_stock_basket')->where('user_id',$user)->where('name',$name);

        if($this->isMethod('put')){
            $basket->where('id','<>',$this->basket);
        }

        if(!empty($basket->get()) || $name == ''){
            $rules['basket_name'] = 'required|unique:am_stock_basket,name,'.$this->basket;
        }
        
        return $rules;
    }
}
