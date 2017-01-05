<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasePrice extends Model
{
    protected $table = 'base_price';
    protected $fillable = ['id','company_id','date','price','fiscal_year_id'];

    const FILE_LOCATION = 'assets/baseprice/';
    const FILE_NAME = 'baseprice';

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear', 'fiscal_year_id', 'id');
    }
}
