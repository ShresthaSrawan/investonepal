<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewHighLow extends Model
{
    protected $table = 'new_high_low';
    protected $fillable = ['high','high_date','low','low_date','company_id'];
}
