<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewArticle extends Model
{
	protected $table='interview_article';

    protected $fillable = ['type', 'category_id','title', 'pub_date','details','user_id','location','tags','slug'];

   	public function category()
    {
        return $this->belongsTo('App\Models\NewsCategory','category_id','id');
    }

	public function company()
	{
		return $this->belongsTo('App\Models\Company', 'company_id', 'id');
	}

	public function bullionType()
	{
		return $this->belongsTo('App\Models\BullionType', 'bullion_type_id', 'id');
	}

	public function featuredImage()
	{
		return $this->hasMany('App\Models\ImageInterviewArticle', 'interview_article_id', 'id');
	}

	public function firstImage()
    {
        return route('image.featured',$this->featuredImage->first()->featured_image);
    }
	
	public function externalDetail()
	{
		return $this->hasOne('App\Models\IAExternalDetail', 'interview_article_id','id' );
	}

	public function intervieweDetail()
	{
		return $this->hasOne('App\Models\IntervieweDetail', 'interview_id','id' );
	}

	public function user()
	{
		return $this->hasOne('App\Models\User','id','user_id');
	}

	public function getLink($route,$category)
    {
        $category = str_slug(strtolower($category));

        return route($route,[$category,$this->slug]);
    }
}
