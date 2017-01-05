<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasuryBill extends Model
{
    protected $table = 'treasury_bill';
    protected $fillable = ['company_id','announcement_id','serial_number'
        ,'highest_discount_rate','lowest_discount_rate','bill_days','issue_open_date'
        ,'issue_close_date','weighted_average_rate','slr_rate'];

    public function announcement()
    {
        return $this->belongsTo('App\Models\Announcement','announcement_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function setAttributes($request, $announcement_id)
    {
        $tb = $request->get('treasuryBill');

        $this->announcement_id = $announcement_id;
        $this->company_id = $request->get('company');
        $this->fiscal_year_id = array_key_exists('fiscal_year_id',$tb) ? $tb['fiscal_year_id'] : NULL;
        $this->issue_amount = array_key_exists('issue_amount',$tb) ? $tb['issue_amount'] : NULL;
        $this->serial_number = array_key_exists('serial_number',$tb) ? $tb['serial_number'] : NULL;
        $this->highest_discount_rate = array_key_exists('highest_discount_rate',$tb) ? $tb['highest_discount_rate'] : NULL;
        $this->lowest_discount_rate =array_key_exists('lowest_discount_rate',$tb) ? $tb['lowest_discount_rate'] : NULL;
        $this->bill_days = array_key_exists('bill_days',$tb) ? $tb['bill_days'] : NULL;
        $this->issue_open_date = array_key_exists('issue_open_date',$tb) ? $tb['issue_open_date'] : NULL;
        $this->issue_close_date = array_key_exists('issue_close_date',$tb) ? $tb['issue_close_date'] : NULL;
        $this->weighted_average_rate = array_key_exists('weighted_average_rate',$tb) ? $tb['weighted_average_rate'] : NULL;
        $this->slr_rate =array_key_exists('slr_rate',$tb) ? $tb['slr_rate'] : NULL;
    }
}
