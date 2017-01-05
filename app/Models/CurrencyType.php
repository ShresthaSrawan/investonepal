<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    protected $table = 'currency_type';

    protected $fillable = ['id','name', 'unit'];

	public static $imageLocation = "country_flag/";
	
	public function getImage()
	{
		return url('/')."/".self::$imageLocation.$this->country_flag;
	}
	
    public function currencyRate()
    {
        return $this->hasMany('App\Models\CurrencyRate','id','type_id');
    } 
}
