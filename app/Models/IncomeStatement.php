<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeStatement extends Model
{
    protected $table = 'income_statement';

    protected $fillable = ['label_id','financial_report_id','value'];

    const FILE_NAME = 'incomestatement';

    public function reportLabel()
    {
        return $this->belongsTo('App\Models\ReportLabel','label_id','id');
    }
}
