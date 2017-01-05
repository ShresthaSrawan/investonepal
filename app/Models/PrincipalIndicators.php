<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrincipalIndicators extends Model
{
    protected $table = 'principal_indicators';

    protected $fillable = ['label_id','financial_report_id','value'];

    const FILE_NAME = 'principalindicators';

    public function reportLabel()
    {
        return $this->belongsTo('App\Models\ReportLabel','label_id','id');
    }
}