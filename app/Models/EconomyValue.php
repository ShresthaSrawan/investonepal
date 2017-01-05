<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EconomyValue extends Model
{
    protected $table = 'economy_value';
    protected $fillable = ['economy_id','label_id','value','date'];

    public function label()
    {
        return $this->belongsTo('App\Models\EconomyLabel','label_id','id');
    }

    public function economy()
    {
        return $this->belongsTo('App\Models\Economy','economy_id','id');
    }
}
