<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class PropertySell extends Model
{
    protected $table = 'am_property_sell';
    protected $fillable = ['property_id','sell_date','sell_rate','sell_quantity','remarks'];

    public function property()
    {
    	return $this->belongsTo('App\Models\AssetsManagement\Property','property_id','id');
    }
}
