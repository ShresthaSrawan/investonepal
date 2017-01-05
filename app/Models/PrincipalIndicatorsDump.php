<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrincipalIndicatorsDump extends Model
{
    protected $table = 'principal_indicators_dump';
    protected $fillable = ['label','value'];
}
