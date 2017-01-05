<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AGM extends Model
{
    protected $table = 'agm';
    protected $fillable = ['company_id','fiscal_year_id','announcement_id'
                            ,'count','venue','book_closer_from','book_closer_to'
                            ,'agm_date','agenda'];

    public function announcement()
    {
        return $this->belongsTo('App\Models\Announcement','announcement_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function fiscal()
    {
        return $this->hasMany('App\Models\AgmFiscal','agm_id','id');
    }

    public function setAttributes($request,$announcement_id){
        $ag = $request->get('agm');

        $this->company_id = $request->get('company');
        $this->announcement_id = $announcement_id;
        $this->count = array_key_exists('count',$ag) ? $ag['count'] : NULL;
        $this->venue = array_key_exists('venue',$ag) ? $ag['venue'] : NULL;
        $this->bonus = array_key_exists('bonus',$ag) ? $ag['bonus'] : NULL;
        $this->dividend = array_key_exists('dividend',$ag) ? $ag['dividend'] : NULL;
        $this->time = array_key_exists('time',$ag) ? $ag['time'] : NULL;
        $this->book_closer_from = array_key_exists('book_closer_from',$ag) ? $ag['book_closer_from'] : NULL;
        $this->book_closer_to = array_key_exists('book_closer_to',$ag) ? $ag['book_closer_to'] : NULL;
        $this->agm_date = $request->get('event_date');
        $this->agenda = array_key_exists('agenda',$ag) ? $ag['agenda'] : NULL;
    }
}
