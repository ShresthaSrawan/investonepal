<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexType extends Model
{
    protected $table = 'index_type';

    protected $fillable = ['id','name'];

    public function index()
    {
        return $this->hasMany('App\Models\Index','id','type_id');
    }
}
