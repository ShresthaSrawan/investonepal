<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodPost extends Model
{
    protected $fillable = ['id', 'label', 'type'];

    protected $table='bod_post';

    public function bod()
    {
        return $this->belongsTo('App\Models\BOD', 'post_id', 'id');
    }
}
