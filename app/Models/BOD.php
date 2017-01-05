<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BOD extends Model
{
    protected $table = 'bod';

    protected $fillable = ['company_id','post_id','name','photo','profile'];
    
    public static $imageLocation = "bod_photo/";

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function bodPost(){
        return $this->hasOne('App\Models\BodPost','id','post_id');
    }


    public function bodFiscalYear()
    {
        return $this->hasMany('App\Models\BodFiscalYear','bod_id','id');
    }

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
