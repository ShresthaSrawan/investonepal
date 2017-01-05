<?php
namespace App;

class File
{
    public static function upload($file,$location,$newName = null)
    {
        $extension = $file->getClientOriginalExtension(); // getting image extension

		if(is_null($newName)):
			$fileName = str_slug($file->getClientOriginalName()).'.'.sha1(time()).'.'.$extension; // renameing image
			while(file_exists($location.$fileName)):
				$fileName = str_slug($file->getClientOriginalName()).'.'.sha1(time()).'.'.$extension; // renameing image
			endwhile;
		else:
			$fileName = $newName.'.'.$extension;
			if(file_exists($location.$fileName)):
				unlink($location.$fileName);
			endif;
		endif;

		$file->move($location, $fileName);

		return $fileName;
    }
}
