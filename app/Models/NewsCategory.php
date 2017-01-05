<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{    
    protected $fillable = ['label'];
    protected $visible = ['id', 'label'];

    protected $table='news_category';

    public function news()
    {
        return $this->hasMany('App\Models\News','category_id','id');
    }

    public function interviewArticle()
    {
        return $this->hasMany('App\Models\InterviewArticle','category_id','id');
    }

    public function recentNews($limit = 4)
    {
        return News::with('imageNewsFirst')->where('category_id',$this->id)
            ->orderBy('pub_date','desc')->limit($limit)->get();
    }

    public function countNews()
    {
        return News::where('category_id',$this->id)->count();
    }

    public function getLabel()
    {
        return $this->label;
    }
}
