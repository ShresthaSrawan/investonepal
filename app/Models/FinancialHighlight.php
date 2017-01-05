<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialHighlight extends Model
{
    protected $table = 'financial_highlight';
    protected $fillable = ['company_id','fiscal_year_id','announcement_id','quarter_id'
        ,'paid_up_capital','reserve_and_surplus','earning_per_share','net_worth_per_share'
        ,'book_value_per_share','net_profit','liquidity_ratio'
        ,'price_earning_ratio','operating_profit'];

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
        return $this->belongsTo('App\Models\FiscalYear','fiscal_year_id','id');
    }

    public function quarter()
    {
        return $this->hasOne('App\Models\Quarter','id','quarter_id');
    }

    public function setAttributes($request, $announcement_id)
    {
        $fh = $request->get('financialHighlight');

        $this->announcement_id = $announcement_id;
        $this->company_id = $request->get('company');

        $this->fiscal_year_id = $request->get('financialHighlight_fiscalYear')['fiscal_year_id'];
        $this->paid_up_capital = array_key_exists('paid_up_capital',$fh) ? $fh['paid_up_capital'] : NULL;
        $this->reserve_and_surplus = array_key_exists('reserve_and_surplus',$fh) ? $fh['reserve_and_surplus'] : NULL;
        $this->earning_per_share = array_key_exists('earning_per_share',$fh) ? $fh['earning_per_share'] : NULL;
        $this->net_worth_per_share = array_key_exists('net_worth_per_share',$fh) ? $fh['net_worth_per_share'] : NULL;
        $this->book_value_per_share = array_key_exists('book_value_per_share',$fh) ? $fh['book_value_per_share'] : NULL;
        $this->net_profit = array_key_exists('net_profit',$fh) ? $fh['net_profit'] : NULL;
        $this->liquidity_ratio = array_key_exists('liquidity_ratio',$fh) ? $fh['liquidity_ratio'] : NULL;
        $this->price_earning_ratio = array_key_exists('price_earning_ratio',$fh) ? $fh['price_earning_ratio'] : NULL;
        $this->operating_profit = array_key_exists('operating_profit',$fh) ? $fh['operating_profit'] : NULL;
    }
}
