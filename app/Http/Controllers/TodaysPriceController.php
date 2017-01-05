<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\FloorSheet;
use App\Models\Company;
use App\Models\TodaysPrice;
use App\Models\LastTradedPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;

class TodaysPriceController extends Controller
{
    public function __construct()
    {
        set_time_limit(0);
    }

    public function getTodaysPrice($year="",$month="",$day="")
    {
        $date = $this->validateDate($year,$month,$day);
		
		$latestDate = TodaysPrice::getLastTradedDate();
		
        if($date==false)
            return redirect()->route('admin.todaysPrice',Carbon::parse($latestDate)->format('Y/m/d'));

        $data = TodaysPrice::where('date','=',$date)->orderBy('company_id','asc')->with('company')->get()->toArray();
		
        return view('admin.todaysprice.viewTodays')->with('data',$data)->with('latestDate',$latestDate);
    }

    public function validateDate($year,$month,$day)
    {
        $year = intval($year);
        $month = intval($month);
        $day = intval($day);
        if($year=="" || $month=="" || $day=="")
        {
            return false;
        }
        else
        {
            $date = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
            if($date=='1970-01-01'){
                return false;
            }
        }
        return $date;
    }
}
