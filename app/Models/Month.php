<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'month';

    protected $fillable = ['quarter_id','label'];

    protected $hidden = ['created_at','updated_at'];

    public function quarter()
    {
        return $this->belongsTo('App\Models\Quarter','quarter_id','id');
    }
}
