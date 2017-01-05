<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastTradedPrice extends Model
{
    protected $table = 'last_traded_price';

    protected $fillable = ['company_id','closing_price','date'];
	
	protected $appends = ['value'];

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
	
	public function getValueAttribute()
	{
		if($this==null) return null;
		return TodaysPrice::where('date',$this->date)->where('company_id',$this->company_id)->first()->close;
	}
	
}
