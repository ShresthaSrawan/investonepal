<?php

namespace App\Models;

use App\Imager;
use Illuminate\Database\Eloquent\Model;

class IAExternalDetail extends Model
{
    protected $table='ia_external_detail';

	public static $imageLocation = "ia_external_photo/";

    protected $fillable = ['interview_article_id', 'name', 'organization', 'position', 'address', 'contact', 'photo'];
    
    public function interviewArticle()
    {
		return $this->belongsTo('App\Models\InterviewArticle', 'interview_article_id', 'id');
	}
	
	public function getImage()
	{
		return url('/')."/".self::$imageLocation.$this->photo;
	}

	public function getThumbnail($h,$w)
    {
        $fileName = self::$imageLocation.$this->photo;
        return Imager::getThumbnail($h,$w,$fileName,'TIA');
    }
	
	public function removeImage()
	{
		$file = self::$imageLocation.$this->photo;

		if((!is_null($this->photo) && $this->photo != "") && file_exists($file)){
            unlink($file);
        }
	}
}
