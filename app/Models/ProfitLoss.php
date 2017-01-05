<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitLoss extends Model
{
    protected $table = 'profit_loss';

    protected $fillable = ['label_id','financial_report_id','value'];

    const FILE_NAME = 'profitloss';

    public function reportLabel()
    {
        return $this->belongsTo('App\Models\ReportLabel','label_id','id');
    }
}
