<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceSheetDump extends Model
{
    protected $table = 'balance_sheet_dump';
    protected $fillable = ['label','value'];
}
