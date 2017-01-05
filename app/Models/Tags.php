<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
	protected $table='tags';

    protected $fillable = ['name'];

    public function news()
    {
    	return $this->belongsToMany('App\Models\News','news_tags','tags_id','news_id');
    }
}
