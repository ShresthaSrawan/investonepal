<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = 'index';

    protected $fillable = ['date'];
    protected $appends = ['previous'];

    public function indexValue()
    {
        return $this->hasMany('App\Models\IndexValue','index_id','id');
    }

    public function getPreviousAttribute()
    {
        return self::with('indexValue')->where('date','<',$this->date)->orderBy('date','desc')->first();
    }

    public static function getLatestDate()
    {
        return self::select(\DB::raw('max(date) as maxdate'))->first()->maxdate;
    }
}
