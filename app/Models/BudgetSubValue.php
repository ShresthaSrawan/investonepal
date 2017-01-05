<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetSubValue extends Model
{
    protected $table = 'budget_sub_value';

    //protected $primaryKey = ['budget_id','sub_label_id'];

    protected $fillable = [
        'id','budget_id','sub_label_id','value'
    ];

    public function subLabel()
    {
        return $this->belongsTo('App\Models\BudgetSubLabel','sub_label_id','id');
    }
}
