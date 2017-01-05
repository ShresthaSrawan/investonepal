<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class CurrencySell extends Model
{
    protected $table = 'am_currency_sell';
    protected $fillable = ['buy_id','sell_date','sell_rate','quantity','remarks'];

    public function currency()
    {
    	return $this->belongsTo('App\Models\AssetsManagement\Currency','buy_id','id');
    }
}
