<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsolidateRevenueDump extends Model
{
    protected $table = 'consolidate_revenue_dump';
    protected $fillable = ['label','value'];
}
