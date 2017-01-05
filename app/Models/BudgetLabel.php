<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetLabel extends Model
{
    const TYPE_SOURCE = 0;
    const TYPE_EXPENSE = 1;
    protected $table = 'budget_label';

    protected $fillable = [
        'id','label','type'
    ];

    public function subLabel()
    {
        return $this->hasMany('App\Models\BudgetSubLabel','budget_label_id','id');
    }

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget','id','label_id');
    }

    public function countBudget()
    {
        return Budget::select('label_id')->where('label_id',$this->id)->count();
    }

    public static $messages = array(
        'label.required' => 'Budget label is required.'
    );
}
