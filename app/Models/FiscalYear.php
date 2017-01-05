<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    protected $table = 'fiscal_year';

    protected $fillable = ['label'];

    public function bodFiscalYear()
    {
        return $this->belongsToMany('App\Models\BodFiscalYear','id','fiscal_year_id');
    }

    public function budget(){
        return $this->hasMany('App\Models\Budget','fiscal_year_id','id');
    }

    public function basePrice()
    {
        return $this->hasMany('App\Models\BasePrice', 'fiscal_year_id', 'id');
    }

    public function ipoPipeline()
    {
        return $this->hasMany('App\Models\IPOPipeline', 'fiscal_year_id', 'id');
    }

    public function economy()
    {
        return $this->hasMany('App\Models\Economy','fiscal_year_id','id');
    }
	
	public function agmFiscal()
    {
        return $this->hasMany('App\Models\AgmFiscal','fiscal_year_id','id');
    }

    public function getCurrentEconomy()
    {
        return \DB::table('economy')
            ->join('fiscal_year', 'economy.fiscal_year_id', '=', 'fiscal_year.id')
            ->join('economy_label', 'economy.label_id', '=', 'economy_label.id')
            ->where('fiscal_year.id','=',$this->id)
            ->orderBy('economy.label_id')
            ->get();
    }
}
