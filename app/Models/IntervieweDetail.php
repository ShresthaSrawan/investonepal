<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Imager;

class IntervieweDetail extends Model
{
    protected $table='interviewe_detail';

	public static $imageLocation = "interviewe_photo/";

    protected $fillable = ['interview_id','name','organization', 'contact','address','position','photo'];

    public function interviewArticle()
    {
		return $this->belongsTo('App\Models\InterviewArticle', 'interview_id', 'id');
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
