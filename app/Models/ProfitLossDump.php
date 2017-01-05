<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitLossDump extends Model
{
    protected $table = 'profit_loss_dump';
    protected $fillable = ['label','value'];
}
