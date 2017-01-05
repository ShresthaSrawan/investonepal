<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Economy extends Model
{
    protected $table = 'economy';
    protected $fillable = ['fiscal_year_id'];


    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear','fiscal_year_id','id');
    }

    public function values()
    {
        return $this->hasMany('App\Models\EconomyValue','economy_id','id');
    }
}
