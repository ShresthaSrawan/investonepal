<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    protected $table = 'balance_sheet';

    protected $fillable = ['label_id','financial_report_id','value'];

    const FILE_NAME = 'balancesheet';

    public function reportLabel()
    {
        return $this->belongsTo('App\Models\ReportLabel','label_id','id');
    }

    public function financialReport()
    {
        return $this->belongsTo('App\Models\FinancialReport','financial_report_id','id');
    }
}
