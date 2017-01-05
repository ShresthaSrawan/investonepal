<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'am_property';
    protected $fillable = ['asset_name','unit','owner_name','buy_date','quantity'
    						,'rate','market_rate','market_date','user_id'];
    						
    protected $hidden = ['user_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','id','user_id');
    }

    public function sell()
    {
        return $this->hasMany('App\Models\AssetsManagement\PropertySell','property_id','id');
    }
}
