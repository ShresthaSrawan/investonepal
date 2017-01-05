<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
	protected $table='user_type';
    protected $fillable = ['label','news_rights','portfolio_rights','data_rights','user_rights','crawl_rights'];

    public function countUser()
    {
        return User::select('type_id')->where('type_id',$this->id)->count();
    }
}
