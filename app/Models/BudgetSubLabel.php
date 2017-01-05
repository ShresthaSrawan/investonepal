<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetSubLabel extends Model
{
    protected $table = 'budget_sub_label';

    protected $fillable = [
        'id','budget_label_id','label'
    ];

    public function headLabel()
    {
        return $this->belongsTo('App\Models\BudgetLabel','budget_label_id','id');
    }

    public function subValue()
    {
    	return $this->hasMany('App\Models\BudgetSubValue','sub_label_id','id');
    }

    public function getSubValue($budgetID)
    {
        return BudgetSubValue::where('sub_label_id',$this->id)->where('budget_id',$budgetID)->first();
    }

    public function countBudget()
    {
        return BudgetSubValue::select('sub_label_id')->where('sub_label_id',$this->id)->count();
    }

    public static $messages = array(
        'label.required' => 'Budget label is required.'
    );
}
