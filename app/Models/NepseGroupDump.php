<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NepseGroupDump extends Model
{
    protected $table = 'nepse_group_dump';
    protected $fillable = ['quote','grade'];
}
