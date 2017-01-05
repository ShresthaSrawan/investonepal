<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
	protected $table = 'company_detail';

    protected $fillable = ['id','address','phone','email', 'web', 'operation_date','issue_manager_id'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company','id','detail_id');
    }

    public function issueManager()
    {
        return $this->hasOne('App\Models\IssueManager', 'id','issue_manager_id' );
    }
}
