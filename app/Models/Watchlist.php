<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $table = 'watchlist';

    protected $fillable = ['user_id', 'company_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function company(){
        return $this->hasOne('App\Models\Company','id','company_id');
    }
}
