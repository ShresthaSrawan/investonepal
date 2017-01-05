<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use App\Imager;

class ImageNews extends Model
{
    protected $table = 'image_news';
    public $thumbnailLocation = 'thumbnails/';
    protected $fillable = ['news_id','featured_image'];

    public static $imageLocation = "featured_image/";

    public function news()
    {
      return $this->belongsTo('App\Models\News', 'id', 'news_id');
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
        return route('image.featured',$this->featured_image);
    }

    public function getThumbnail($h,$w)
    {
        $fileName = self::$imageLocation.$this->featured_image;
		
        return file_exists($fileName) ? Imager::getThumbnail($h,$w,$fileName,'TN') : false;
    }
}
