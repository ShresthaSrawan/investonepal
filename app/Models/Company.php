<?php

namespace App\Models;

use App\Imager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = ['id','sector_id', 'detail_id', 'quote','name', 'listed','logo','listed_shares', 'face_value','total_paid_up_value','issue_status'];

    public static $imageLocation = "logo/";

    public function sector()
    {
        return $this->belongsTo('App\Models\Sector','sector_id','id');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News','id','company_id');
    }

    public function details(){
        return $this->hasOne('App\Models\CompanyDetail','id','detail_id');
    }

    public function bod(){
        return $this->hasMany('App\Models\BOD','company_id','id');
    }

    public function latestBods()
    {
        if(is_null($this->id)) return null;
        $bods = collect(DB::table('bod_fiscal_year')
            ->leftJoin('bod','bod_fiscal_year.bod_id','=','bod.id')
            ->leftJoin('bod_post','bod_post.id','=','bod.post_id')
            ->leftJoin('fiscal_year','fiscal_year.id','=','bod_fiscal_year.fiscal_year_id')
            ->where('company_id',$this->id)
            ->select('name','photo','profile','fiscal_year.label as label','type','bod_post.label as bodlabel')
            ->get())
            ->groupBy('type');
            
        $output = collect();
        foreach ($bods as $key => $bod) {
            $maxfy = $bod->max('label');
            $output->push($bod->where('label',$maxfy)); // return only with the max fiscal year label
        }
            
        return $output;
    }

    public function latestTradedPrice(){
        return $this->hasOne('App\Models\LastTradedPrice','company_id','id');
    }

    public function todaysPrice()
    {
        return $this->hasMany('App\Models\TodaysPrice','company_id','id');
    }

    public function basePrice()
    {
        return $this->hasMany('App\Models\BasePrice', 'company_id', 'id');
    }

    public function interviewArticle()
    {
        return $this->hasMany('App\Models\InterviewArticle', 'id','company_id');
    }

    public function ipoResult()
    {
        return $this->hasMany('App\Models\IPOResult','company_id','id');
    }

    public function nepseGroupGrade()
    {
        return $this->hasMany('App\Models\NepseGroupGrade','company_id','id');
    }

    public function countNews()
    {
        return News::select('company_id')->where('company_id',$this->id)->count();
    }

    public function countAnnouncement()
    {
        return Announcement::select('company_id')->where('company_id',$this->id)->count();
    }

    public function countInterviewArticle()
    {
        return InterviewArticle::select('company_id')->where('company_id',$this->id)->count();
    }

    public function countFloorsheet()
    {
        return Floorsheet::select('company_id')->where('company_id',$this->id)->count();
    }

    public function getImage()
    {
        return url('/')."/".self::$imageLocation.$this->logo;
    }
	
	public function getThumbnail($h,$w)
    {
        $fileName = self::$imageLocation.$this->logo;
        return Imager::getThumbnail($h,$w,$fileName,'TCL');
    }

    public function removeImage()
    {
        $file = self::$imageLocation.$this->logo;

        if((!is_null($this->logo) && $this->logo != "") && file_exists($file)){
            unlink($file);
        }
    }
}