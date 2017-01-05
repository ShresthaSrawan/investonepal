<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BullionType extends Model
{
    protected $table = 'bullion_type';

    protected $fillable = ['id','name','unit'];

    public function price()
    {
        return $this->hasMany('App\Models\BullionPrice','id','type_id');
    }

    public function interviewArticle()
    {
      return $this->hasMany('App\Models\InterviewArticle', 'bullion_type_id', 'id');
    }
}
