<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementSubType extends Model
{
	protected $table = 'announcement_subtype';

    protected $fillable = ['announcement_type_id','label'];

    protected $hidden = ['created_at','updated_at'];

    public function type()
    {
        return $this->belongsTo('App\Models\AnnouncementType','announcement_type_id','id');
    }

    public function announcement()
    {
        return $this->hasMany('App\Models\Announcement','subtype_id','id');
    }

    public function dynamic()
    {
        return $this->hasMany('App\Models\AnnouncementMisc','subtype_id','id');
    }

    public function getAnnouncementCount()
    {
        return Announcement::where('subtype_id',$this->id)->count('id');
    }
}
