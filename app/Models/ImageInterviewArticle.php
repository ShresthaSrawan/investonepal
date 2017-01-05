<?php

namespace App\Models;

use App\Imager;
use Illuminate\Database\Eloquent\Model;

class ImageInterviewArticle extends Model
{
    protected $table = 'image_interview_article';
    protected $fillable = ['interview_article_id','featured_image'];

		public static $imageLocation = "featured_image/";

    public function interviewArticle()
    {
      return $this->belongsTo('App\Models\InterviewArticle','interview_article_id','id');
    }

    public function removeImage()
	{
		$file = self::$imageLocation.$this->featured_image;

		if(file_exists($file)){
			unlink($file);
		}
	}

    public function getImage()
	{
		return url('/')."/".self::$imageLocation.$this->featured_image;
	}

	public function getThumbnail($h,$w)
    {
        $fileName = self::$imageLocation.$this->featured_image;
        return Imager::getThumbnail($h,$w,$fileName,'TIA');
    }
}
