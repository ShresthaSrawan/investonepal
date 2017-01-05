<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BudgetFiscalYear extends Model
{
    protected $table = 'budget_fiscal_year';

    protected $fillable = ['label'];

    public function budget(){
        return $this->hasMany('App\Models\Budget','fiscal_year_id','id');
    }
	
	public function hasType($type)
    {
        $count = \DB::table('budget')
            ->join('fiscal_year', 'budget.fiscal_year_id', '=', 'fiscal_year.id')
            ->join('budget_label', 'budget.label_id', '=', 'budget_label.id')
            ->where('fiscal_year.id','=',$this->id)
            ->where('budget_label.type','=',$type)
            ->count('budget.id');

        return ($count > 0);
    }
}

