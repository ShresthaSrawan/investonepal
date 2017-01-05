<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Excel;

class FloorSheet extends Model
{
    const FILE_LOCATION = 'assets/floorsheet/';
    const FILE_NAME = 'floorsheet';
    protected $table = 'floorsheet';

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
}
