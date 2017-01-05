<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyReview extends Model
{
    protected $table = 'company_review';

    protected $fillable = ['user_id', 'company_id', 'type','review','date','up_user_id','down_user_id'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function company()
    {
    	return $this->belongsTo('App\Models\Company','company_id','id');
    }
}
