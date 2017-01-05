<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\FloorSheet;

class TodaysPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'company_id','date', 'tran_count', 'open', 'close', 'high', 'low', 'volume', 'amount'];
    protected $appends = ['previous','min52','max52','difference','percentage'];

    /**
     * Database table used by Model
     *
     * @var array
     */
    protected $table='todays_price';

    public static function calculateTodaysPrice($date="")
    {
        if($date!="")
        {
            $count = 0;
            $data = array();
            $requiredCompanies = FloorSheet::distinct('company_id')->where('date','=',$date)->groupBy('company_id')->orderBy('company_id')->get();
            foreach($requiredCompanies as $company)
            {
                $data[$count] = FloorSheet::distinct()->select(
                    DB::raw("
                    distinct(company_id), count(*) as no_of_transactions ,
                    max(rate) as max,
                    min(rate) as min,
                    sum(amount) as amount,
                    (SELECT rate FROM floorsheet where company_id ='$company->company_id' and date='$date' ORDER BY id desc LIMIT 1) as opening,
                    (SELECT rate FROM floorsheet where company_id ='$company->company_id' and date='$date' ORDER BY id asc LIMIT 1) as closing,
                    (SELECT close FROM todays_price where company_id ='$company->company_id' and date<'$date' ORDER BY id asc LIMIT 1) as previous_closing,
                    (SELECT rate FROM floorsheet where company_id ='$company->company_id' and date='$date' ORDER BY id asc LIMIT 1)-(SELECT rate FROM floorsheet where company_id ='$company->company_id' and date<'$date' ORDER BY id asc LIMIT 1) as difference,
                    sum(quantity) as traded_shares"))
                    ->where('date','=',$date)
                    ->where('company_id','=',$company->company_id)
                    ->orderBy('date','desc')
                    ->first();
                $count++;
            }
            return $data;
        }

        return false;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

    public static function getLastTradedDate($company="")
    {
        if($company==""){
            $lastRecord = self::orderBy('date', 'desc')->first();
        } else {
            $lastRecord = self::where('company_id',$company)->orderBy('date','desc')->take(1)->first();
        }

        if(is_null($lastRecord)) return null;
        return Carbon::parse($lastRecord->date)->format('Y-m-d');
    }

    public function previous()
    {
        $previous = self::where('company_id',$this->company_id)->where('date','<',$this->date)->orderBy('date','desc')->first();
        if(!is_null($previous))
            return $previous;
        else
            return null;
    }

    public function getPreviousAttribute()
    {
        if($this->date==null || $this->company_id==null) return null;
       
        $previous = self::where('company_id',$this->company_id)->where('date','<',$this->date)->orderBy('date','desc')->first();
        if(!is_null($previous))
            return $previous->close;
        else
            return Company::where('id',$this->company_id)->first()->face_value;
    }

    public function getMin52Attribute()
    {
         if($this->date==null || $this->company_id==null) return null;

        return self::select(DB::raw('min(close) as min'))
            ->whereRaw("date_format(date, '%Y-%m-%d') BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d')", [Carbon::parse($this->date)->subWeeks(52)->format('Y-m-d'), $this->date])
            ->groupBy('company_id')
            ->where('company_id',$this->company_id)
            ->first()
            ->min;
    }

    public function getMax52Attribute()
    {
         if($this->date==null || $this->company_id==null) return null;
        return self::select(DB::raw('max(close) as max'))
            ->whereRaw("date_format(date, '%Y-%m-%d') BETWEEN STR_TO_DATE(?, '%Y-%m-%d') AND STR_TO_DATE(?, '%Y-%m-%d')", [Carbon::parse($this->date)->subWeeks(52)->format('Y-m-d'), $this->date])
            ->groupBy('company_id')
            ->where('company_id',$this->company_id)
            ->first()
            ->max;
    }

    public function getDifferenceAttribute()
    {
        return round((float)($this->close-$this->previous),2);
    }
    
    public function getPercentageAttribute()
    {
        if($this->previous!=0)
            return round(((float)(($this->close-$this->previous)/$this->previous)*100),2);
        else
            return null;
    }

    public static function getSummaryByDate($date="")
    {
        if($date!="")
        {
            $result = self::select(
            DB::raw('count(DISTINCT company_id) as total_company'),
            DB::raw('sum(tran_count) as total_tran'),
            DB::raw('sum(volume) as total_vol'),
            DB::raw('sum(amount) as total_amt'))
            ->where('date', $date)
            ->first()
            ->toArray();
            
            $advanceDecline = AdvanceDecline::where('date',$date)->first();

            $market_cap = IndexValue::leftJoin('index','index_value.index_id','=','index.id')
                ->leftJoin('index_type','index_value.type_id','=','index_type.id')
                ->where('date',$date)
                ->where('name','like','%market capitalization%')->first();
            $float_cap = IndexValue::leftJoin('index','index_value.index_id','=','index.id')
                ->leftJoin('index_type','index_value.type_id','=','index_type.id')
                ->where('date',$date)
                ->where('name','like','%float mkt cap%')->first();

            $result['date'] = Carbon::parse($date)->format('d M, Y');
            $result['advance'] = $advanceDecline ? $advanceDecline->advance:null;
            $result['decline'] = $advanceDecline ? $advanceDecline->decline:null;
            $result['neutral'] = $advanceDecline ? intval($result['total_company'])-(intval($advanceDecline->decline)+intval($advanceDecline->advance)):null;
            $result['market_cap'] = $market_cap ? $market_cap->value:null;
            $result['float_cap'] = $float_cap ? $float_cap->value:null;
            return $result;
        }
        return false;
    }
}
