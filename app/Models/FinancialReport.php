<?php

namespace App\Models;

use Excel;
use Illuminate\Database\Eloquent\Model;
use App\Models\BalanceSheetDump;
use App\Http\Controllers\ApiController;

class FinancialReport extends Model
{
    protected $table = 'financial_report';

    protected $fillable = ['id','quarter_id','fiscal_year_id','company_id','entry_date','entry_by'];

    // protected $appends = ['previous'];

    const FILE_LOCATION = 'assets/reports/';

    public static $className = [
                        'bs'=>'\App\Models\BalanceSheet',
                        'pl'=>'\App\Models\ProfitLoss',
                        'pi'=>'\App\Models\PrincipalIndicators',
                        'is'=>'\App\Models\IncomeStatement',
                        'cr'=>'\App\Models\consolidateRevenue'
                    ];
    public static $classDump = [
                        'bs'=>'\App\Models\BalanceSheetDump',
                        'pl'=>'\App\Models\ProfitLossDump',
                        'pi'=>'\App\Models\PrincipalIndicatorsDump',
                        'is'=>'\App\Models\IncomeStatementDump',
                        'cr'=>'\App\Models\consolidateRevenueDump'
                    ];

    public function quarter(){
        return $this->hasOne('App\Models\Quarter','id','quarter_id');
    }

    public function fiscalYear(){
        return $this->hasOne('App\Models\FiscalYear','id','fiscal_year_id');
    }

    public function company(){
        return $this->hasOne('App\Models\Company','id','company_id');
    }

    public function balanceSheet(){
        return $this->hasMany('App\Models\BalanceSheet','financial_report_id','id');
    }

    public function profitLoss(){
        return $this->hasMany('App\Models\ProfitLoss','financial_report_id','id');
    }

    public function principalIndicators(){
        return $this->hasMany('App\Models\PrincipalIndicators','financial_report_id','id');
    }

    public function incomeStatement(){
        return $this->hasMany('App\Models\IncomeStatement','financial_report_id','id');
    }

    public function consolidateRevenue(){
        return $this->hasMany('App\Models\consolidateRevenue','financial_report_id','id');
    }

    public function setReportFromExcel($type)
    {
        $class = self::$className[$type];
        $dump = self::$classDump[$type];

        $report='';
        if(Excel::load('/public/assets/reports/'.$class::FILE_NAME.'.xls')):
            $report = Excel::load('/public/assets/reports/'.$class::FILE_NAME.'.xls',function($reader){
                $reader->take(1);
            })->get()->toArray();
        else:
            return false;
        endif;
        $dump::truncate();
        foreach($report[0] as $key=>$value):
            if($key!='0' && $value!='0' && $key!=null && $value!=null) 
            {
                $fr = new $dump;
                $fr->label = $key;
                $fr->value = $value;
                $fr->save();
            }
        endforeach;

        return true;
    }

    public static function match($type)
    {
        $dump = self::$classDump[$type];

        $dumpLabel = $dump::lists('value','label')->toArray();
        $originalLabels = ReportLabel::lists('label','id')->toArray();

        $cleanLabels = array();
        foreach ($originalLabels as $id=>$org) {
            $cleanLabels[$id]=ApiController::clean($org);
        }

        $unknown = array();
        $matched = [];
        foreach($dumpLabel as $dump=>$value)
        {
            $index = array_search($dump, $cleanLabels);
            if($index!==false){
                $matched[$index]=$value;
            } else {
                array_push($unknown,$dump);
            }
        }
        return ['unknown'=>$unknown,'matched'=>$matched];
    }
}
