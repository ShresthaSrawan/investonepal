<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgmFiscal extends Model
{
    protected $table = 'agm_fiscal';

    protected $fillable = ['agm_id','fiscal_year_id'];

    public function agm()
    {
        return $this->belongsTo('App\Models\AGM','agm_id','id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear','fiscal_year_id','id');
    }
}
