<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auction';
    protected $fillable = ['issue_id','promoter','ordinary'];

    public function issue()
    {
        return $this->belongsTo('App\Models\Issue','issue_id','id');
    }

    public function setAttributes($request, $issue_id)
    {
        $this->issue_id = $issue_id;
        if(array_key_exists('promoter',$request->get('auction'))){
            $this->promoter = $request->get('auction')['promoter'];
        }
        if(array_key_exists('ordinary',$request->get('auction'))){
            $this->ordinary = $request->get('auction')['ordinary'];
        }
    }
}
