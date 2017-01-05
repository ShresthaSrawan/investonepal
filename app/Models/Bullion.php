<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bullion extends Model
{
    protected $table='bullion';

    protected $fillable = ['date'];
    protected $appends = ['previous'];

    public function bullionPrice()
    {
    	return $this->hasMany('App\Models\BullionPrice','bullion_id','id');
    }

    public function getPreviousAttribute()
    {
        return self::with('bullionPrice')->where('date','<',$this->date)->orderBy('date','desc')->first();
    }
	
	public static function getLatestDate()
    {
        return self::select(\DB::raw('max(date) as maxdate'))->first()->maxdate;
    }
}
