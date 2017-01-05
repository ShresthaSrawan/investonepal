<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BondDebenture extends Model
{
    protected $table = 'bond_and_debenture';
    protected $fillable = ['company_id','announcement_id','title_of_securities'
        ,'face_value','kitta','maturity_period','issue_open_date','issue_close_date'
        ,'coupon_interest_rate','interest_payment_method'];

    public function announcement()
    {
        return $this->belongsTo('App\Models\Announcement','announcement_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function setAttributes($request,$announcement_id)
    {
        $bondDeb = $request->get('bondDebenture');

        $this->company_id = $request->get('company') == 0 ? NULL : $request->get('company');
        $this->fiscal_year_id = array_key_exists('fiscal_year_id',$bondDeb) ? $bondDeb['fiscal_year_id'] : NULL;
        $this->announcement_id = $announcement_id;
        $this->title_of_securities = array_key_exists('title_of_securities',$bondDeb) ? $bondDeb['title_of_securities'] : NULL;
        $this->face_value = array_key_exists('face_value',$bondDeb) ? $bondDeb['face_value'] : NULL;
        $this->kitta = array_key_exists('kitta',$bondDeb) ? $bondDeb['kitta'] : NULL;
        $this->maturity_period = array_key_exists('maturity_period',$bondDeb) ? $bondDeb['maturity_period'] : NULL;
        $this->issue_open_date = array_key_exists('issue_open_date',$bondDeb) ? $bondDeb['issue_open_date'] : NULL;
        $this->issue_close_date = array_key_exists('issue_close_date',$bondDeb) ? $bondDeb['issue_close_date'] : NULL;
        $this->coupon_interest_rate = array_key_exists('coupon_interest_rate',$bondDeb) ? $bondDeb['coupon_interest_rate'] : NULL;
        $this->interest_payment_method = array_key_exists('interest_payment_method',$bondDeb) ? $bondDeb['interest_payment_method'] : NULL;
    }
}
