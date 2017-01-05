<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Imager;


class Announcement extends Model
{
    protected $fileLocation = 'featured_image/';
    protected $table = 'announcement';
    protected $thumbnailLocation = 'featured_image/thumbnails/';

    protected $fillable = [
        'user_id','type_id','subtype_id'
        ,'company_id','event_date','pub_date'
        ,'source','title','details','featured_image','slug'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\AnnouncementType','type_id','id');
    }

    public function subtype()
    {
        return $this->belongsTo('App\Models\AnnouncementSubType','subtype_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public function image(){
        if($this->featured_image == '' || is_null($this->featured_image)):
            return route('image.featured','default.png');
        endif;

        return route('image.featured',$this->featured_image);
    }

    public function imageThumbnail($h,$w)
    {
        $featured = ($this->featured_image == '' || is_null($this->featured_image))
            ? 'default.png'
            : $this->featured_image;

        $fileName = $this->fileLocation.$featured;
        
        return file_exists($fileName) ? Imager::getThumbnail($h,$w,$fileName,'TA') : false;
    }

    public function removeImage()
    {
        $file = $this->fileLocation.$this->featured_image;
        if(file_exists($file)){
            unlink($file);
        }

        return $this;
    }

    public function uploadImage($request)
    {
        //upload destination
        $file = $request->file('featured_image');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = str_slug($file->getClientOriginalName()).'.'.time().'.'.$extension; // renameing image
        while(file_exists($this->fileLocation.$fileName)){
            $fileName = time().'.'.$extension; // renameing image
        }
        $file->move($this->fileLocation, $fileName); // uploading file to given path
        $this->featured_image = $fileName;
    }

    public function setAttributes($request)
    {
        $this->type_id = $request->get('type');
        $this->subtype_id = $request->has('subtype') ? $request->get('subtype') : NULL;
        if($request->get('company') != '0' && $request->get('company') != ''){
            $this->company_id = $request->get('company');
        }
        $event = $request->get('event_date', NULL);
        if(!empty($event))
            $this->event_date = $event;
        $this->pub_date = $request->get('pub_date', NULL);
        $this->source = $request->get('source');
        $this->title = $request->get('title');
        $this->details = $request->get('details');
        $this->slug = str_slug(strtolower($request->get('title')).' '.date('YmdHis'));
    }

    public function getLink($route,$type)
    {
        $type = str_slug(strtolower($type));

        return route($route,[$type,$this->slug]);
    }

    public function issue()
    {
        return $this->hasOne('App\Models\Issue','announcement_id','id');
    }

    public function agm()
    {
        return $this->hasOne('App\Models\AGM','announcement_id','id');
    }

    public function bonusDividend()
    {
        return $this->hasOne('App\Models\BonusDividendDistribution','announcement_id','id')
            ->where('is_bod_approved','<>',BonusDividendDistribution::BOD_APPROVED);
    }

    public function bodApproved()
    {
        return $this->hasOne('App\Models\BonusDividendDistribution','announcement_id','id')
            ->where('is_bod_approved','=',BonusDividendDistribution::BOD_APPROVED);
    }

    public function bondDebenture()
    {
        return $this->hasOne('App\Models\BondDebenture','announcement_id','id');
    }

    public function treasuryBill()
    {
        return $this->hasOne('App\Models\TreasuryBill','announcement_id','id');
    }

    public function financialHighlight()
    {
        return $this->hasOne('App\Models\FinancialHighlight','announcement_id','id');
    }

    public function timeAgo()
    {
        $hoursDays = Carbon::parse($this->pub_date)->addHour(24);
        $pubDate = Carbon::parse($this->pub_date);
        $now = Carbon::parse(date('Y-m-d h:m:i'));

        if($hoursDays > $now) return $pubDate->diffForHumans();

        return $pubDate->format('M jS');
    }

    public static function getSortedAnnouncementByType($type_id="")
    {
        if($type_id!="")
        {
            return self::with('type')->where('type_id',$type_id)->orderBy('pub_date','desc')->limit(2)->take(2)->get();
        }
        return null;
    }
}
