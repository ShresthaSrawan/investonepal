<?php
/**
 * Created by PhpStorm.
 * User: Roshan
 * Date: 8/13/2015
 * Time: 11:21 AM
 */

namespace App;
use Image;

class Imager
{
    private static $_THUMBNAIL_LOCATION = 'thumbnails/';

    public static function getThumbnail($height,$width,$file,$prefix = 'T')
    {
        $location = explode('/',$file);
        $name  = $prefix.$height.$width.array_pop($location);
        $fileLocation = self::thumbnailLocation().$name;

        if(!file_exists($fileLocation)):
            self::makeThumbnail($height,$width,$file,$fileLocation);
        endif;

        return route('image.thumbs',$name);
    }

    public static function thumbnailLocation($location = null)
    {
        return is_null($location) ? self::$_THUMBNAIL_LOCATION : $location;
    }

    public static function clear($location = null)
    {
        $location = is_null($location) ? self::$_THUMBNAIL_LOCATION : $location;

        $files = glob($location); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }

    private static function makeThumbnail($height,$width,$file,$toBeFile)
    {
        $img = Image::make($file);
        $hw = self::getRatio($height,$width,$img);

        $img->resize($hw['width'],$hw['height'])->crop($width,$height,$hw['cropX'],$hw['cropY'])->save($toBeFile);
    }

    private static function getRatio($height,$width,$file)
    {
        $sourceWidth = $file->width();
        $sourceHeight = $file->height();

        $targetWidth = $width;
        $targetHeight = $height;

        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = $targetWidth / $targetHeight;

        if ( $sourceRatio < $targetRatio ) {
            $scale = $sourceWidth / $targetWidth;
        } else {
            $scale = $sourceHeight / $targetHeight;
        }

        $resizeWidth = (int)($sourceWidth / $scale);
        $resizeHeight = (int)($sourceHeight / $scale);

        $cropTop = (int)(($resizeHeight - $targetHeight) / 2);
        $cropLeft = (int)(($resizeWidth - $targetWidth) / 2);

        return ['height'=>$resizeHeight,'width'=>$resizeWidth,'cropX'=>$cropLeft,'cropY'=>$cropTop];
    }
}