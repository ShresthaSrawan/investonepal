<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPOIssueManager extends Model
{
    protected $table = 'ipo_issue_manager';

    protected $fillable = ['id','issue_manager_id','ipo_pipeline_id'];

    protected $hidden = ['created_at','updated_at'];

    public function ipoPipeline()
    {
        return $this->belongsTo('App\Models\IPOPipeline', 'ipo_pipeline_id', 'id');
    }

    public function issueManager()
    {
        return $this->belongsTo('App\Models\IssueManager', 'issue_manager_id', 'id');
    }
}
