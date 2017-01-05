<?php

namespace App\Models;

use App\Imager;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'user';

    protected $fillable = ['id','username', 'email', 'password','type_id','info_id','status','profile_picture','expiry_date'];

    protected $appends = ['thumbnail'];

    protected $hidden = ['password', 'remember_token'];

    public static $imageLocation = "profile_picture/";

    public function userInfo(){
        return $this->hasOne('App\Models\UserInfo','id','info_id');
    }

    public function userType(){
        return $this->hasOne('App\Models\UserType','id','type_id');
    }

    public function getImage()
    {
        return url('/')."/".self::$imageLocation.$this->profile_picture;
    }

    public function getThumbnailAttribute()
    {
        if(is_null($this->profile_picture) || $this->profile_picture=='') return null;
        
        $h=150;$w=150;
        $fileName = self::$imageLocation.$this->profile_picture;
        return Imager::getThumbnail($h,$w,$fileName,'TU');
    }

    public function getThumbnail($h,$w)
    {
        $fileName = self::$imageLocation.$this->profile_picture;
        return Imager::getThumbnail($h,$w,$fileName,'TU');
    }

    public function removeImage()
    {
        $file = self::$imageLocation.$this->profile_picture;

        if(!is_null($this->profile_picture) && file_exists($file) && $this->profile_picture != ""){
            unlink($file);
        }
    }

    public function watchlist(){
        return $this->hasMany('App\Models\watchlist','user_id','id');
    }

    public function isAdmin()
    {
        return !(strtolower($this->userType->label)=="client"); // given any other user who is not client is an admin
    }

    //Get current user rights/privileges by category
    public function hasRightsTo($do=null,$category=null)
    {
        if(!(is_null($category) || is_null($category))){
            $map = [
                'create'=>0,
                'c'=>0,
                'read'=>1,
                'r'=>1,
                'update'=>2,
                'u'=>2,
                'delete'=>3,
                'd'=>3
            ];
            $allrights = $this->userType;
            $category_rights = str_split($allrights[$category.'_rights']);

            if(array_key_exists(strtolower($do), $map))
                if($category_rights[$map[strtolower($do)]]==1)
                    return true;
            return false;
        }
    }
}
