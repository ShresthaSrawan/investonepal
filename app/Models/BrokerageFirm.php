<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrokerageFirm extends Model
{
    protected $table = 'brokerage_firm';

    protected $fillable = ['firm_name','code','phone','photo','address', 'director_name', 'mobile'];

    public static $imageLocation = "brokerageFirm_photo/";

    public function getImage()
    {
        return url('/')."/".self::$imageLocation.$this->photo;
    }

    public function removeImage()
    {
        $file = self::$imageLocation.$this->photo;

        if(file_exists($file)){
            unlink($file);
        }
    }
}
