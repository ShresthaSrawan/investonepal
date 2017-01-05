<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueManager extends Model
{
    protected $table = 'issue_manager';

    protected $fillable = ['name','address','phone','email','web','company'];

    public function companyIssueManager(){
        return $this->hasMany('App\Models\CompanyIssueManager');
    }

    public function companyDetail(){
        return $this->hasMany('App\Models\CompanyDetail', 'id', 'issue_manager_id');
    }

    public function countIssue()
    {
        return IMIssue::select('im_id')->where('im_id',$this->id)->count();
    }

    public function countCompany()
    {
        return CompanyDetail::select('issue_manager_id')->where('issue_manager_id',$this->id)->count();
    }
} 