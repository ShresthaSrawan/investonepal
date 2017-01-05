<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    protected $fillable = ['id','first_name', 'last_name', 'address','work','dob','phone'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','id','info_id');
    }

    public function fullname()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }
}
