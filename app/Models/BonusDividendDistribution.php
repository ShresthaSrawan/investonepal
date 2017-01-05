<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusDividendDistribution extends Model
{
    const BOD_APPROVED = 1;

    protected $table = 'bonus_dividend_distribution';
    protected $fillable = ['company_id','fiscal_year_id','announcement_id'
        ,'bonus_share','cash_dividend','distribution_date','is_bod_approved'];

    public function announcement()
    {
        return $this->belongsTo('App\Models\Announcement','announcement_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function fiscalYear()
    {
        return $this->hasMany('App\Models\FiscalYear','id','fiscal_year_id');
    }

    public function setAttributes($request, $announcement_id)
    {
        $bdd = $request->has('bonusDividend') ? $request->get('bonusDividend') : $request->get('bodApproved');

        $this->announcement_id = $announcement_id;
        $this->company_id = $request->get('company');
        $this->fiscal_year_id = array_key_exists('fiscal_year_id',$bdd) ? $bdd['fiscal_year_id'] : NULL;
        $this->bonus_share = array_key_exists('bonus_share',$bdd) ? $bdd['bonus_share'] : NULL;
        $this->cash_dividend = array_key_exists('cash_dividend',$bdd) ? $bdd['cash_dividend'] : NULL;
        $this->distribution_date = array_key_exists('distribution_date',$bdd) ? $bdd['distribution_date'] : NULL;
    }
}
