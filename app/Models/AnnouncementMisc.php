<?php

namespace App\Models;

use App\NepaliCalendar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AnnouncementMisc extends Model
{
    protected $table = 'announcement_misc';
    protected $fillable = ['type_id','subtype_id','title','description'];

    protected $pattern = '/\{\w+\}/';

    public $areCalled = [
        'loadFrom' => false,
        'loadTo' => false,
        'loadCompany' => false,
        'loadEvent' => false,
        'loadNepaliDate' => false,
        'loadSubtype' => false,
        'loadType' => false,
        'loadKitta' => false,
        'loadOrdinary' => false,
        'loadPromoter' => false,
        'loadTitleOfSecurities' => false,
        'loadIssueManager' => false,
        'loadBonusShare' => false,
        'loadCashDividend' => false,
        'loadPaidUpCapital' => false,

        'loadFiscalYear' => false,
        'loadCount' => false,
        'loadVenue' => false,
        'loadTime' => false,
        'loadNepaliEventDate' => false,
    ];

    public $keywords = [
        '{from}' => [
            'alias' => ['issue_date','issue_open_date','distribution_date'],
            'function'=>'loadFrom',
            'wait'=>false,
        ],
        '{to}' => [
            'alias' => ['close_date','issue_close_date'],
            'function'=>'loadTo',
            'wait'=>false,
        ],
        '{company_name}' => [
            'alias' => ['company_id','company'],
            'function'=>'loadCompany',
            'wait'=>false,
        ],
        '{company_quote}' => [
            'alias' => ['company_id','company'],
            'function'=>'loadCompany',
            'wait'=>false,
        ],
        '{event}' => [
            'alias' => ['event','event_date'],
            'function'=>'loadEvent',
            'wait'=>false,
        ],
        '{subtype}' => [
            'alias' => ['subtype_id','subtype'],
            'function'=>'loadSubtype',
            'wait'=>false,
        ],
        '{type}' => [
            'alias' => ['type_id','type'],
            'function'=>'loadType',
            'wait'=>false,
        ],
        '{kitta}' => [
            'alias' => ['kitta'],
            'function'=>'loadKitta',
            'wait'=>false,
        ],
        '{title_of_securities}' => [
            'alias' => ['title_of_securities'],
            'function'=>'loadTitleOfSecurities',
            'wait'=>false,
        ],
        '{ordinary}' => [
            'alias' => ['ordinary'],
            'function'=>'loadOrdinary',
            'wait'=>false,
        ],
        '{promoter}' => [
            'alias' => ['promoter'],
            'function'=>'loadPromoter',
            'wait'=>false,
        ],
        '{issue_manager}' => [
            'alias' => ['issue_manager','issue_manager_id'],
            'function'=>'loadIssueManager',
            'wait'=>false,
        ],
        '{bonus_share}' => [
            'alias' => ['bonus_share'],
            'function'=>'loadBonusShare',
            'wait'=>false,
        ],
        '{cash_dividend}' => [
            'alias' => ['cash_dividend'],
            'function'=>'loadCashDividend',
            'wait'=>false,
        ],
        '{paid_up_capital}' => [
            'alias' => ['paid_up_capital'],
            'function'=>'loadPaidUpCapital',
            'wait'=>false,
        ],
        '{reserve_surplus}' => [
            'alias' => ['reserve_surplus'],
            'function'=>'loadReserveAndSurplus',
            'wait'=>false,
        ],
        '{operating_profit}' => [
            'alias' => ['operating_profit'],
            'function'=>'loadOperatingProfit',
            'wait'=>false,
        ],
        '{fiscal_year}' => [
            'alias' => ['fiscal_year','fiscal_year_id'],
            'function'=>'loadFiscalYear',
            'wait'=>false,
        ],
        '{count}' => [
            'alias' => ['count'],
            'function'=>'loadCount',
            'wait'=>false,
        ],
        '{venue}' => [
            'alias' => ['venue'],
            'function'=>'loadVenue',
            'wait'=>false,
        ],
        '{time}' => [
            'alias' => ['time'],
            'function'=>'loadTime',
            'wait'=>false,
        ],
        '{nepali_date}' => [
            'alias' => [],
            'function'=>'loadNepaliDate',
            'wait'=>true,
        ],
        '{nepali_event}' => [
            'alias' => ['event_date'],
            'function'=>'loadNepaliEventDate',
            'wait'=>true,
        ],
    ];

    public $values = [];

    public $loaded = [];

    public function type()
    {
        return $this->belongsTo('App\Models\AnnouncementType','type_id','id');
    }

    public function subtype()
    {
        return $this->belongsTo('App\Models\AnnouncementSubType','subtype_id','id');
    }

    public function loadData(array $data)
    {
        $newData = [];
        foreach($data as $key=>$value):
            if(!is_array($value)):
                $newData[$key] = $value;
            else:
                foreach($value as $k=>$v):
                    $newData[$k] = $v;
                endforeach;
            endif;
        endforeach;

        $this->loaded = $newData;
    }

    public function getTitle()
    {
        return $this->matchAndReturn($this->title);
    }

    public function getDescription()
    {
        return $this->matchAndReturn($this->description);
    }

    private function matchAndReturn($sentence)
    {
        foreach(array_keys($this->keywords) as $key):
            if(strpos($sentence, $key) !== false) $this->callByKeyword($key);
        endforeach;

        foreach($this->values as $key=>$value){
            $sentence = str_replace($key,$value,$sentence);
        }

        return $sentence;
    }

    private function callByKeyword($keyword)
    {
        $function = $this->keywords[$keyword]['function'];
        $param = $this->getParam($keyword);
        $this->callByFunction($function,$param);
    }

    private function callByFunction($function,$param)
    {
        if(method_exists($this,$function) && !$this->areCalled[$function]):
            $this->$function($param);
            $this->areCalled[$function] = true;
        endif;
    }

    private function getParam($keyword)
    {
        $alias = $this->keywords[$keyword]['alias'];
        foreach($alias as $a):
            if(array_key_exists($a,$this->loaded)) return $this->loaded[$a];
        endforeach;

        return false;
    }

    private function loadCompany($id)
    {
        $c = Company::find($id);
        $this->values['{company_name}'] = !is_null($c) ? $c->name : NULL;
        $this->values['{company_quote}'] = !is_null($c) ? $c->quote : NULL;
    }

    private function loadSubtype($id)
    {
        $st = AnnouncementSubType::find($id);
        $this->values['{subtype}'] = !is_null($st) ? strtoupper($st->label) : NULL;
    }

    private function loadKitta($kitta)
    {
        $this->values['{kitta}'] = $kitta != '' ? $kitta : NULL;
    }

    private function loadFrom($date = null)
    {
        $this->values['{from}'] = ($date != '') ? $date : NULL;
    }

    private function loadTo($date = null)
    {
        $this->values['{to}'] = $date != '' ? $date : NULL;
    }

    private function loadEvent($date = null)
    {
        $this->values['{event}'] = $date != '' ? $date : NULL;
    }

    private function loadType($id = null)
    {
        $type = AnnouncementType::find($id);
        $typeName = (!is_null($type)) ? $type->label : NULL;

        $this->values['{type}'] = ucwords($typeName);
    }

    private function loadOrdinary($date = null)
    {
        $this->values['{ordinary}'] = $date != '' ? $date : NULL;
    }

    private function loadTitleOfSecurities($title)
    {
        $this->values['{title_of_securities}'] = $title != '' ? $title : NULL;
    }

    private function loadPromoter($date = null)
    {
        $this->values['{promoter}'] = $date != '' ? $date : NULL;
    }

    private function loadIssueManager($date = null)
    {
        $this->values['{issueManager}'] = $date != '' ? $date : NULL;
    }

    private function loadBonusShare($date = null)
    {
        $this->values['{bonusShare}'] = $date != '' ? $date : NULL;
    }

    private function loadCashDividend($date = null)
    {
        $this->values['{cashDividend}'] = $date != '' ? $date : NULL;
    }

    private function loadPaidUpCapital($date = null)
    {
        $this->values['{paidUpCapital}'] = $date != '' ? $date : NULL;
    }

    private function loadFiscalYear($fid)
    {
        $label = '';
        if(!is_null($fid)):
            if(!is_array($fid)) $fid = [$fid];

            $fYears = FiscalYear::select('label')->orderBy('label','asc')->whereIn('id',$fid)->get();
            foreach($fYears as $i=>$fy):
                if($i == 0): $label .= $fy->label;
                else: $label .= '/'.$fy->label;
                endif;
            endforeach;
        endif;

        $this->values['{fiscal_year}'] = $fid != '' ? $label : NULL;
    }

    private function loadCount($date = null)
    {
        $this->values['{count}'] = $date != '' ? $date : NULL;
    }

    private function loadVenue($fid = null)
    {
        $this->values['{venue}'] = $fid != '' ? $fid : NULL;
    }

    private function loadTime($date = null)
    {
        $this->values['{time}'] = $date != '' ? $date : NULL;
    }

    private function loadNepaliEventDate($date = null)
    {
        $date = $this->getDate($date);
        $nCalender = new NepaliCalendar();
        $nDate = '';
        if($date != false):
            $year = $date->year;
            $month = $date->month;
            $day = $date->day;
            $d = $nCalender->eng_to_nep($year,$month,$day);
            $nDate = $d['date'].' '.$d['nmonth'].' '.$d['year'];
        endif;

        $this->values['{nepali_event}'] = $date != '' ? $nDate : NULL;

    }

    private function loadNepaliDate()
    {
        $allDates = [
            'nFrom'=>[
                '{from}',
            ],
            'nTo' => [
                '{to}',
            ]
        ];

        $nCalender = new NepaliCalendar();
        $nFrom = null;
        $nTo = null;

        foreach($allDates as $type=>$values):
            foreach($values as $d):
                $date = $this->getDate($this->getParam($d));
                if($date != false):
                    $year = $date->year;
                    $month = $date->month;
                    $day = $date->day;
                    $$type = $nCalender->eng_to_nep($year,$month,$day);
                endif;
            endforeach;
        endforeach;

        $nDate = '';

        if(!is_null($nFrom) && !is_null($nTo)):
            if(empty(array_diff($nFrom,$nTo))):
                $nDate = $nFrom['date'].' '.$nFrom['nmonth'].' '.$nFrom['year'];
            else:
                if($nFrom['year'] == $nTo['year']):
                    if($nFrom['month'] == $nTo['month']):
                        if($nFrom['date'] == $nTo['date']):
                            $nDate = $nFrom['date'].' '.$nFrom['nmonth'].' '.$nFrom['year'];
                        else:
                            $nDate = $nFrom['date'].' to '
                                .$nTo['date'].' '.$nTo['nmonth'].' '.$nTo['year'];
                        endif;
                    else:
                        $nDate = $nFrom['date'].' '.$nFrom['nmonth'].' to '
                            .$nTo['date'].' '.$nTo['nmonth'].' '.$nFrom['year'];
                    endif;
                else:
                    $nDate = $nFrom['date'].' '.$nFrom['nmonth'].' '.$nFrom['year'].' to '
                        .$nTo['date'].' '.$nTo['nmonth'].' '.$nTo['year'];
                endif;
            endif;
        elseif(!is_null($nFrom)):
            $nDate = $nFrom['date'].' '.$nFrom['nmonth'].' '.$nFrom['year'];
        elseif(!is_null($nTo)):
            $nDate = $nTo['date'].' '.$nTo['nmonth'].' '.$nTo['year'];
        endif;

        $this->values['{nepali_date}'] = $nDate;
    }

    private function getDate($date)
    {
        if($date != '' && !is_null($date)):
            if($date = date_create($date)->format('Y-m-d H:i:s')){
                $date  = (new Carbon())->createFromFormat('Y-m-d H:i:s',$date);
            }
        endif;
        return ($date == '') ? false : $date;
    }
}
