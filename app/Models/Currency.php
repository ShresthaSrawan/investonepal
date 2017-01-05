<?php

namespace App\Models;

use DB;
use Excel;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ApiController;

class Currency extends Model
{
    protected $fillable = ['date'];
    protected $appends = ['previous'];

    protected $table='currency';

    const FILE_LOCATION = 'assets/currency/';
    const FILE_NAME = 'currencyrate';

    public function currencyRate()
    {
    	return $this->hasMany('App\Models\CurrencyRate','currency_id','id');
    }

    public function getPreviousAttribute()
    {
        return self::with('currencyRate')->where('date','<',$this->date)->orderBy('date','desc')->first();
    }
	
	public static function getLatestDate()
    {
        return self::select(\DB::raw('max(date) as maxdate'))->first()->maxdate;
    }

    public function setCurrencyFromExcel()
    {
        if(Excel::load('/public/assets/currency/'.self::FILE_NAME.'.xls')):
            $this->currencyRate = Excel::load('/public/assets/currency/'.self::FILE_NAME.'.xls')->get()->toArray();
        else:
            return false;
        endif;
        $allCurrencyName = CurrencyType::lists('code','id')->toArray();
        $cleanCurrencyName = array();
        foreach ($allCurrencyName as $key => $value) {
        	$cleanCurrencyName[$key] = ApiController::clean($value);
        }
        $indexes = array();
        $date = "";
        
        DB::beginTransaction();
        try{
	        foreach ($this->currencyRate as $day) {
	        	foreach ($day as $key => $value) {
	        		if($key=='date')
	        		{
	        			$date = $value;
	        		} else {
	        			//currencies 
	        			$isBuyPrice = strpos($key,'buy') !== false ;

	    				$name = substr($key, 0,strrpos($key,'_'));
	    				$currency_id = array_search($name, $cleanCurrencyName);
	    				
	    				$indexes[$date][$currency_id][$isBuyPrice?'buy':'sell'] = $value;
	        		}
	        	}
	        }
	        $flag =0;
	        foreach ($indexes as $date => $values) {
	        	if(Currency::where('date',$date)->first()){
	        		$flag ++;
	        		continue;
	        	}
	        	
	        	$currency = new Currency;
	        	$currency->date = $date;
	        	$currency->save();
	        	foreach ($values as $key => $value) {
	        		$currencyRate = new CurrencyRate;
	        		$currencyRate->currency_id = $currency->id;
	        		$currencyRate->type_id = $key;
	        		$currencyRate->buy = array_key_exists('buy',$value) ? $value['buy'] : null;
	        		$currencyRate->sell = array_key_exists('sell',$value) ? $value['sell'] : null;
	        		$currencyRate->save();
	        	}
	        }
	    } catch (\Exception $e) {
            // something went wrong
            DB::rollback();
            throw $e;
            return false;
        }
        DB::commit();
        if($flag>0)
        	return redirect()->back()->with('warning',"Currency rate for {$flag} date(s) already exists and have been skipped.");

        return true;        
    }
}
