<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodFiscalYear extends Model
{
    protected $table = 'bod_fiscal_year';
    protected $fillable = ['bod_id','fiscal_year_id'];

    public function bod(){
        return $this->hasMany('App\Models\BOD', 'bod_id', 'id');
    }

    public function fiscalYear(){
        return $this->hasOne('App\Models\FiscalYear', 'id', 'fiscal_year_id');
    }
}
