<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AnnouncementType extends Model
{
    protected $table = 'announcement_type';

    protected $fillable = ['label'];

    public static $rules = [
        'store' => [
            'label' => 'required|alpha|min:3|unique:announcement_type'
        ]
    ];

    public static $messages = array(
        'label.required' => 'Announcement Type is required.',
        'label.alpha' => 'Announcement Type should contain only alphabets.',
        'label.min:3' => 'The Announcement Type must be at least 3 characters.',
        'label.unique:announcement_type' => 'Announcement Type is not unique.'
    );

    public function announcement()
    {
        return $this->hasMany('App\Models\Announcement','type_id','id');
    }

    public function subTypes()
    {
        return $this->hasMany('App\Models\AnnouncementSubType','announcement_type_id','id');
    }

    public function dynamic()
    {
        return $this->hasMany('App\Models\AnnouncementMisc','type_id','id');
    }

    public function hasSubtype()
    {
        return 0 != AnnouncementSubType::where('announcement_type_id',$this->id)->count();
    }

    public function countAnnouncement()
    {
        return Announcement::where('type_id',$this->id)->count();
    }

    public function countSubtype()
    {
        return AnnouncementSubType::where('announcement_type_id',$this->id)->count();
    }
}
