<?php

namespace App\Models;

use Excel;
use Illuminate\Database\Eloquent\Model;

class BasePriceDump extends Model
{
    protected $table = 'base_price_dump';
    protected $fillable = ['id','quote','date','price','fiscal_year_id'];

    public function countPrice()
    {
    	return self::count();
    }
    
    public function setBasePriceFromExcel()
    {
        if(Excel::load('/public/assets/baseprice/baseprice.xls')) {
            $this->basePrice = Excel::load('/public/assets/baseprice/baseprice.xls')->get()->toArray();
        }
        self::truncate();
        foreach($this->basePrice as $basePrice)
        {
            $bp = new BasePriceDump();
            $bp->quote = $basePrice['stock_symbol'];
            $bp->price = $basePrice['price'];
            $bp->save();
            
        }
        return true;
    }

    public function unknownCompanies()
    {
        $companies = self::lists('quote')->toArray();
        $all_company_quote_list = Company::lists('quote')->toArray();
        $unknown = array();
        foreach($companies as $company)
        {
            if(!in_array($company,$all_company_quote_list))
                array_push($unknown,$company);
        }
        return $unknown;
    }


    public function addtodb($date="",$fiscalYear="")
    {
    	$unknown = self::unknownCompanies();
    	if(!count($unknown)>0)
    	{
    		$allCompanies = Company::lists('quote','id')->toArray();
    		$bpds = self::all();

    		BasePrice::where('date','=',$date)->delete();
    		foreach ($bpds as $bpd) 
    		{
    			$bp = new BasePrice();
    			$bp->company_id = array_search($bpd->quote,$allCompanies);
    			$bp->fiscal_year_id = $fiscalYear;
    			$bp->date = $date;
    			$bp->price = $bpd->price;
    			$bp->save();
    		}
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    
}
