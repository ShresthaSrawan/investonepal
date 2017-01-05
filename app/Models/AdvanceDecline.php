<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceDecline extends Model
{
    protected $table = 'advance_decline';
    protected $fillable = ['advance','decline','date'];

    public static function addnew($date="")
    {
    	if($date!="")
    	{
    		$tps = TodaysPrice::where('date',$date)->get();
    		$ad = ['advance'=>0,'decline'=>0];
    		foreach ($tps as $tp) {
    			if($tp->difference>0) $ad['advance']++;
    			if($tp->difference<0) $ad['decline']++;
    		}
    		AdvanceDecline::where('date',$date)->delete();
    		$newAD = new AdvanceDecline;
    		$newAD->date = $date;
    		$newAD->advance = $ad['advance'];
    		$newAD->decline = $ad['decline'];
    		$newAD->save();
    		return true;
    	}
    	return false;
    }
}
