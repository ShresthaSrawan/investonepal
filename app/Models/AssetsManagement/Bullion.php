<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Model;

class Bullion extends Model
{
    protected $table = 'am_bullion';
    protected $fillable = ['type_id','buy_date','owner_name','total_amount','quantity','user_id'];
    protected $hidden = ['user_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','id','user_id');
    }

    public function type()
    {
    	return $this->belongsTo('App\Models\BullionType');
    }

    public function sell()
    {
        return $this->hasMany('App\Models\AssetsManagement\BullionSell','buy_id','id');
    }
}
