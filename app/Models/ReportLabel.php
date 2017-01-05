<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportLabel extends Model
{
    protected $table = 'report_label';

    protected $fillable = ['label','type'];

    public function countBS()
    {
        return BalanceSheet::select('label_id')->where('label_id',$this->id)->count();
    }

    public function countPL()
    {
        return ProfitLoss::select('label_id')->where('label_id',$this->id)->count();
    }

    public function countPI()
    {
        return PrincipalIndicators::select('label_id')->where('label_id',$this->id)->count();
    }

    public function countIS()
    {
        return IncomeStatement::select('label_id')->where('label_id',$this->id)->count();
    }

    public function countCR()
    {
        return ConsolidateRevenue::select('label_id')->where('label_id',$this->id)->count();
    }
}
