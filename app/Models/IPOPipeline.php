<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPOPipeline extends Model
{
    protected $table = 'ipo_pipeline';

    protected $fillable = ['id','amount_of_securities','application_date','remarks','approval_date','amount_of_public_issue','fiscal_year_id','announcement_subtype_id','issue_manager_id', 'company_id'];

    protected $hidden = ['created_at','updated_at'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function fiscalYear()
    {
        return $this->hasOne('App\Models\FiscalYear', 'id', 'fiscal_year_id');
    }

    public function announcementSubtype()
    {
        return $this->hasOne('App\Models\AnnouncementSubType', 'id', 'announcement_subtype_id');
    }

    public function ipoIssueManager()
    {
        return $this->hasMany('App\Models\IPOIssueManager', 'ipo_pipeline_id', 'id');
    }
}
