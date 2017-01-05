<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EconomyLabel extends Model
{
    protected $table = 'economy_label';
    protected $fillable = ['name'];

    public function economyValue()
    {
        return $this->hasMany('App\Models\EconomyValue','label_id','id');
    }

    public function getRecentEconomyValue($limit = 5)
    {
    	return EconomyValue::with('economy.fiscalYear')->where('label_id',$this->id)->orderBy('date','desc')->limit($limit)->get();
    }


}
