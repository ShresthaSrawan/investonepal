<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Energy extends Model
{
    protected $table = 'energy';

    protected $fillable = ['date'];
    protected $appends = ['previous'];

    public function energyPrice()
    {
        return $this->hasMany('App\Models\EnergyPrice','energy_id','id');
    }

    public function getPreviousAttribute()
    {
        return self::with('energyPrice')->where('date','<',$this->date)->orderBy('date','desc')->first();
    }
	
	public static function getLatestDate()
    {
        return self::select(\DB::raw('max(date) as maxdate'))->first()->maxdate;
    }
}
