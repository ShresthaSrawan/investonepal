<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IMIssue extends Model
{
    protected $table = 'im_issue';
    protected $fillable = ['im_id','issue_id'];

    public function issueManager(){
        $this->belongsTo('App\Models\IssueManager','id','im_id');
    }

    public function issue(){
        $this->belongsTo('App\Models\Issue','id','issue_id');
    }
}
