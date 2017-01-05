<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;

class ImageController extends Controller
{
    const FEATURED_PATH = 'featured_image/';
    const THUMBNAIL_PATH = 'thumbnails/';

    private $request;
    private $mimes = [
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpg',
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function thumbnail($file)
    {
        $prop = explode('.',$file);
        $ext = strtolower(end($prop));
        $mime = array_key_exists($ext,$this->mimes) ? $this->mimes[$ext] : FALSE;

        $path = self::THUMBNAIL_PATH.$file;
        if(FALSE == $mime || FALSE == file_exists($path)) abort(404, 'Resource not found');

        return $this->getImage($path,$mime);
    }

    public function featured($file)
    {
        $prop = explode('.',$file);
        $ext = strtolower(end($prop));
        $mime = array_key_exists($ext,$this->mimes) ? $this->mimes[$ext] : FALSE;
        $path = self::FEATURED_PATH.$file;
		
        if(FALSE == $mime || FALSE == file_exists($path)) abort(404, 'Resource not found');

        return $this->getImage($path,$mime);
    }

    private function getImage($path,$mime){
        $request = $this->request;
        $size = filesize($path);
        $file = file_get_contents($path);

        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $size
        ];

        $response = response( $file, 200, $headers );
        $fileTime = filemtime($path);
        $etag = md5($fileTime);
        $time = date('r', $fileTime);
        $expires = date('r', $fileTime + 3600);

        $response->setEtag($etag);
        $response->setLastModified(new DateTime($time));
        $response->setExpires(new DateTime($expires));
        $response->setPublic();

        if($response->isNotModified($request)) return $response;
        return $response->prepare($request);
    }
}
