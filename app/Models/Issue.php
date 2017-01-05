<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issue';
    protected $fillable = ['company_id','fiscal_year_id','announcement_id','issue_manager_id'
        ,'face_value','issue_date','close_date','ratio'];

    public function announcement()
    {
        return $this->belongsTo('App\Models\Announcement','announcement_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function fiscalYear()
    {
        return $this->hasOne('App\Models\FiscalYear','id','fiscal_year_id');
    }

    public function manager()
    {
        return $this->hasMany('App\Models\IMIssue','issue_id','id');
    }

    public function auction()
    {
        return $this->hasOne('App\Models\Auction','issue_id','id');
    }

    public function setAttributes($request, $announcement_id)
    {
        $issue = $request->get('issue');
        $this->announcement_id = $announcement_id;
        $this->company_id = ($request->get('company') != 0) ? $request->get('company') : NULL;
        $this->fiscal_year_id = $issue['fiscal_year_id'];
        $this->face_value = $issue['face_value'];
        $this->issue_date = $issue['issue_date'];
        $this->close_date = $issue['close_date'];

        if($request->has('auction') == false){
            $this->kitta = array_key_exists('kitta',$issue) ? $issue['kitta'] : Null;
            $this->ratio = array_key_exists('ratio',$issue) ? $issue['ratio'] : Null;
        }
    }
}
