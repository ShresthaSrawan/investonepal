<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsolidateRevenue extends Model
{
    protected $table = 'consolidate_revenue';

    protected $fillable = ['label_id','financial_report_id','value'];

    const FILE_NAME = 'consolidaterevenue';

    public function reportLabel()
    {
        return $this->belongsTo('App\Models\ReportLabel','label_id','id');
    }
}
