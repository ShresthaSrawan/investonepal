<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budget';

    protected $fillable = ['id','fiscal_year_id','label_id','value'];

    public function budgetLabel()
    {
        return $this->hasOne('App\Models\BudgetLabel','id','label_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo('App\Models\BudgetFiscalYear','fiscal_year_id','id');
    }

    public function subValue()
    {
        return $this->hasMany('App\Models\BudgetSubValue','budget_id','id');
    }

    public function getType()
    {
        return $this->budgetLabel->type;
    }

}
