<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NepseGroupGrade extends Model
{
    protected $table = 'nepse_group_grade';
    protected $fillable = ['nepse_group_id','company_id','grade'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function nepseGroup()
    {
        return $this->belongsTo('App\Models\NepseGroup','nepse_group_id','id');
    }
}
