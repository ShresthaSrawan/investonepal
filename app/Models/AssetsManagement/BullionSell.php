<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class BullionSell extends Model
{
    protected $table = 'am_bullion_sell';
    protected $fillable = ['buy_id','sell_date','sell_price','quantity','remarks'];

    public function bullion()
    {
    	return $this->belongsTo('App\Models\AssetsManagement\Bullion','buy_id','id');
    }
}
