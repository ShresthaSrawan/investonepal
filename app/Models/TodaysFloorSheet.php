<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Excel;
use DB;
use Carbon\Carbon;

class TodaysFloorSheet extends Model
{
    //
    public function __construct()
    {
        ini_set("memory_limit","1G");
//        ini_set('max_execution_time', '900');
//        ini_set('max_input_time', '0');
        // DB::connection()->disableQueryLog();
        DB::statement("SET SESSION group_concat_max_len = 1000000"); // length for group concat to incorporate all transaction numbers which are concatenated into a single string
        set_time_limit(0);
    }

    protected $table = 'todays_floorsheet';

    protected $fillable = ['id','transaction_no','stock_symbol','buyer_broker','seller_broker','quantity','rate','amount'];

    public function setFloorsheetFromExcel()
    {
        if(Excel::load('/public/assets/floorsheet/floorsheet.xls')) {
            $this->floorsheet = Excel::load('/public/assets/floorsheet/floorsheet.xls')->get()->toArray();
        } elseif(Excel::load('/public/assets/floorsheet/floorsheet.xlsx')) {
            $this->floorsheet = Excel::load('/public/assets/floorsheet/floorsheet.xlsx')->get()->toArray();
        }
        self::truncate();

        $sql = "INSERT INTO todays_floorsheet(`transaction_no`,`stock_symbol`,`buyer_broker`,`seller_broker`,`quantity`,`rate`,`amount`) values";

        foreach($this->floorsheet as $floorsheet)
        {
            if
                (
                $floorsheet['transaction_no'] == "" || 
                $floorsheet['stock_symbol'] == "" || 
                $floorsheet['buyer_broker'] == "" || 
                $floorsheet['seller_broker'] == "" || 
                $floorsheet['quantity'] == "" || 
                $floorsheet['rate'] == "" || 
                $floorsheet['amount'] == ""
                )
                continue;
            $sql .= "(
                '{$floorsheet['transaction_no']}',
                '{$floorsheet['stock_symbol']}',
                '{$floorsheet['buyer_broker']}',
                '{$floorsheet['seller_broker']}',
                '{$floorsheet['quantity']}',
                '{$floorsheet['rate']}',
                '{$floorsheet['amount']}'

            ),";
        }
        $sql = substr($sql, 0,-1).';';
        
        return DB::select(DB::raw($sql));
    }

    public static function unknownCompanies()
    {
        $companies = self::groupBy('stock_symbol')->lists('stock_symbol')->toArray();
        $all_company_quote_list = Company::lists('quote')->toArray();
        $unknown = array();
        foreach($companies as $company)
        {
            if(!in_array($company,$all_company_quote_list))
                array_push($unknown,$company);
        }
        return $unknown;
    }

    public function nofTransaction()
    {
        $count = self::count();
        return $count;
    }

    public function nofCompany()
    {
        $count = self::select('stock_symbol')->groupBy('stock_symbol')->get()->count();
        return $count;
    }

    public function totalQuantity()
    {
        return self::sum('quantity');
    }

    public function totalAmount()
    {
        return self::sum('amount');
    }

    public function updateAll($date="")
    {
        if($date=="" || $date==null)
            $date = date("Y-m-d");
		
		$lastTradedPrice = LastTradedPrice::all();
		
		if(self::addToDB($date))
		{
			DB::beginTransaction();
			$query = 'select c.id as company_id,
				  GROUP_CONCAT(CAST(transaction_no AS CHAR) ORDER BY transaction_no ASC) as transaction_no,
				  GROUP_CONCAT(CAST(buyer_broker AS CHAR) ORDER BY transaction_no ASC) as buyer_broker,
				  GROUP_CONCAT(CAST(seller_broker AS CHAR) ORDER BY transaction_no ASC) as seller_broker,
				  GROUP_CONCAT(CAST(quantity AS CHAR) ORDER BY transaction_no ASC) as quantity,
				  GROUP_CONCAT(CAST(rate AS CHAR) ORDER BY transaction_no ASC) as rate,
				  GROUP_CONCAT(CAST(amount AS CHAR) ORDER BY transaction_no ASC) as amount
				FROM todays_floorsheet f join company c ON c.quote = f.stock_symbol GROUP BY stock_symbol';
			$floorsheet = json_decode(json_encode(DB::select(DB::raw($query))),true);

			TodaysPrice::where('date',$date)->delete();
			$advance = 0;
			$decline = 0;

			$todaysPrices = array();

			foreach($floorsheet as $company)
			{
				$id = $company['company_id'];
				$transaction_no = explode(',',$company['transaction_no']);
				$quantity = explode(',',$company['quantity']);
				$rate = explode(',',$company['rate']);
				$amount = explode(',',$company['amount']);
				
				//update todays price
				$t_transaction_count = count($transaction_no);
				$t_open = reset($rate);
				$t_close = end($rate);
				$t_high = max($rate);
				$t_low = min($rate);
				$t_traded_volume = (int)array_sum($quantity);
				$t_traded_amount = (double)array_sum($amount);

				array_push($todaysPrices,[
					'company_id'=>$id,
					'date'=>$date,
					'tran_count'=>$t_transaction_count,
					'open'=>$t_open,
					'high'=>$t_high,
					'low'=>$t_low,
					'close'=>$t_close,
					'volume'=>$t_traded_volume,
					'amount'=>$t_traded_amount
					]);
					
				//update last traded price
				$recordExists = $lastTradedPrice->where('company_id',$id)->first(); 
				if(is_null($recordExists)) {
					DB::select("INSERT INTO last_traded_price(`company_id`,`date`) values(?,?)",[$id,$date]);
				} else {
					if(Carbon::parse($recordExists->date)->lt(Carbon::parse($date)))
						DB::select("UPDATE last_traded_price set `date`=? WHERE company_id=?",[$date,$id]);
				}

				//update new high low
				$highLow = NewHighLow::where('company_id',$id)->first();
				if($highLow) {
					if($t_close>$highLow->high) {
						DB::select("UPDATE new_high_low set `high`=?,`high_date`=? where id=?",[$t_close,$date,$highLow->id]);
					}
					if($t_close<$highLow->low) {
						DB::select("UPDATE new_high_low set `low`=?,`low_date`=? where id=?",[$t_close,$date,$highLow->id]);
					}
					$highLow->save();
				} else {
					DB::select("INSERT into new_high_low(`company_id`,`high`,`high_date`,`low`,`low_date`) values(?,?,?,?,?)",[$id,$t_close,$date,$t_close,$date]);
				}
			}
			if(
				TodaysPrice::insert($todaysPrices) &&
				AdvanceDecline::addnew($date)
				)
				DB::commit();
			else 
				DB::rollback();
		}        
        return true;
    }

    public function getDate()
    {
        $transaction_no = self::orderBy('id','desc')->first()->transaction_no;
        $date = substr($transaction_no,0,4).'-'.substr($transaction_no,4,2).'-'.substr($transaction_no,6,2);
        return $date;
    }

    public function addToDB($date="")
    {
        if(!count(self::unknownCompanies())>0)
        {
            $allCompanies = Company::lists('quote','id')->toArray();
            $tfss = self::all();

            FloorSheet::where('date','=',$date)->delete();
            
            $data = array();
            $counter=0;
            foreach($tfss as $tfs)
            {
                $company_id = array_search($tfs->stock_symbol,$allCompanies);
                array_push($data , [
                    'transaction_no'=>$tfs->transaction_no,
                    'company_id'=>$company_id,
                    'buyer_broker'=>$tfs->buyer_broker,
                    'seller_broker'=>$tfs->seller_broker,
                    'quantity'=>$tfs->quantity,
                    'rate'=>$tfs->rate,
                    'amount'=>$tfs->amount,
                    'date'=>$date
                ]);
                $counter++;
            }
            foreach (array_chunk($data, 5000) as $chunk) {
                Floorsheet::insert($chunk);
            }
            return true;
        } else {
            return false;
        }
    }
}
