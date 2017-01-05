<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'am_currency';
    protected $fillable = ['type_id','buy_date','total_amount','quantity','user_id'];
    protected $hidden = ['user_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','id','user_id');
    }

    public function type()
    {
    	return $this->belongsTo('App\Models\CurrencyType');
    }

    public function sell()
    {
        return $this->hasMany('App\Models\AssetsManagement\CurrencySell','buy_id','id');
    }
}
