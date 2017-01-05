<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeStatementDump extends Model
{
    protected $table = 'income_statement_dump';
    protected $fillable = ['label','value'];
}
