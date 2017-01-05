<?php

namespace App\Http\Controllers;

use Excel;
use Cache;
use App\Models\AnnouncementMisc;
use Carbon\Carbon;
use yajra\Datatables\Datatables;

use App\Models\AdvanceDecline;
use App\Models\Announcement;
use App\Models\AnnouncementSubType;
use App\Models\AnnouncementType;
use App\Models\Company;
use App\Models\FiscalYear;
use App\Models\BudgetFiscalYear;
use App\Models\FloorSheet;
use App\Models\LastTradedPrice;
use App\Models\Index;
use App\Models\IndexValue;
use App\Models\IndexType;
use App\Models\Bullion;
use App\Models\BullionPrice;
use App\Models\Energy;
use App\Models\EnergyPrice;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\NewHighLow;
use App\Models\News;
use App\Models\TodaysPrice;
use App\Models\ReportLabel;
use App\Models\ReportLabelInsurance;
use App\Models\BudgetLabel;
use App\Models\BudgetSubLabel;
use App\Models\IPOPipeline;
use App\Models\IssueManager;
use App\Models\BrokerageFirm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;

        $lastYear = Carbon::now()->subYear();
        $lastFiveYear = Carbon::now()->subYears(5);
        $newInputs = array();

        if(!$this->request->has('skip_time_range_constraint')) {
            foreach ($this->request->all() as $key => $req) {
                if (strpos($key, 'date') !== false) {
                    $limit = $this->request->has('extended_timeline') ? $lastFiveYear : $lastYear;
                    if (Carbon::parse($req)->lt($limit)) {
                        $newInputs += [$key => $limit->format('Y-m-d')];
                        continue;
                    }
                    $newInputs += [$key => Carbon::parse($req)->format('Y-m-d')];
                } else {
                    $newInputs += [$key => $req];
                }
            }
            $this->request->replace($newInputs);    // append the altered data inputs
        }
    }

    public function getAnnouncementTypeSubTypes(Request $request)
    {
        $id = $request->get('id');
        $subtypes = AnnouncementSubType::select('id', 'label')
            ->where('announcement_type_id', '=', $id)->get();
        return $subtypes;
    }

    public function searchCompany(Request $request)
    {
        $query = $request->get('company');
        $company = Company::select(DB::raw('quote, name, quote as id'))->where('name', 'LIKE', "%{$query}%")->orWhere('quote', 'LIKE', "%{$query}%")->get();

        return $company;
    }

    public function searchFiscalYear(Request $request)
    {
        $query = $request->get('fiscalYear');
        $year = FiscalYear::select('id', 'label')->where('label', 'LIKE', "%{$query}%")->get();
        return $year;
    }

    public function getAnnouncementDynamicContents(Request $request)
    {
        $response = ['error' => true];

        $type = $request->get('type');
        $subtype = $request->get('subtype');
        $announceMisc = AnnouncementMisc::where('type_id', $type);

        if ($request->has('subtype')) $announceMisc = $announceMisc->where('subtype_id', $subtype);

        $announceMisc = $announceMisc->first();

        if (false == is_null($announceMisc)):
            $functions = $announceMisc->loadData($request->all());
            $response['error'] = false;
            $response['message']['title'] = $announceMisc->getTitle();
            $response['message']['description'] = $announceMisc->getDescription();
        endif;

        return $response;
    }

    public function searchReportLabel(Request $request)
    {
        $query = $request->get('reportLabel');
        $type = $request->get('reportType');
        $reportLabel = ReportLabel::select('id', 'label')->where('label', 'LIKE', "%{$query}%")->where('type', '=', $type)->get();
        return $reportLabel;
    }

    public function searchReportLabelInsurance(Request $request)
    {
        $query = $request->get('reportLabel');
        $type = $request->get('reportType');
        $reportLabel = ReportLabelInsurance::select('id', 'label')->where('label', 'LIKE', "%{$query}%")->where('type', '=', $type)->get();
        return $reportLabel;
    }

    public function searchBudgetLabel(Request $request)
    {
        $id = $request->get('id');
        $sub = BudgetSubLabel::where('budget_label_id', $id)->get();

        $subLabel = ['error' => true, 'message' => null];

        if (!$sub->isEmpty()) {
            $subLabel['message'] = $sub->lists('label', 'id');
            $subLabel['error'] = false;
        }

        return $subLabel;
    }

    public function getAnnouncementForm(Request $request)
    {
        $type = $request->get('type');
        $subtype = $request->get('subtype');

        $response = [
            'agm' => false,
            'auction' => ['ordinary' => false, 'promoter' => false],
            'issue' => false,
            'ratio' => false,
            'kitta' => false,
            'bond_debenture' => false,
            'bill' => false,
            'certificate' => false,
            'finance' => false,
            'other' => false,
			'bod_approved'=>false
        ];


        if ($subtype == 0 || $subtype == '') {
            $response['other'] = true;
            return $response;
        }

        $result = AnnouncementSubType::where('id', '=', $subtype)
            ->where('announcement_type_id', '=', $type)
            ->first();

        if ($result == null) {
            $response['other'] = true;
            return $response;
        }

        $resultType = $result->type->label;
        $resultSubtype = $result->label;

        if ($resultType == 'annual general meeting') {
            $response['agm'] = true;
            return $response;

        } elseif (strpos($resultType, 'issue') !== false) {
            if (strpos($resultType, 'auction') !== false) {
                $response['issue'] = true;
                if (strpos($resultSubtype, 'ordinary') !== false) {
                    $response['auction']['ordinary'] = true;
                    $response['ratio'] = $response['kitta'] = false;
                }
                if (strpos($resultSubtype, 'promoter') !== false) {
                    $response['auction']['promoter'] = true;
                    $response['ratio'] = $response['kitta'] = false;
                }
            } elseif (strpos($resultType, 'open') !== false && (strpos($resultSubtype, 'bond') !== false || strpos($resultSubtype, 'debenture') !== false)) {
                $response['bond_debenture'] = true;
            } elseif (strpos($resultSubtype, 'bill') !== false) {
                $response['bill'] = true;
            } elseif (strpos($resultType, 'close') !== false) {
                $response['other'] = true;
            } else {
                $response['ratio'] = $response['kitta'] = true;
                $response['issue'] = true;
            }

            if (strpos($resultSubtype, 'right') !== false) {
                $response['ratio'] = true;
            } else {
                $response['ratio'] = false;
            }

        } elseif (strpos($resultType, 'certificate') !== false) {
            //further check
            if (strpos($resultSubtype, 'bonus') !== false || strpos($resultSubtype, 'dividend') !== false) {
                $response['certificate'] = true;
            } else {
                $response['other'] = true;
            }
        } elseif (strpos($resultType, 'financial') !== false) {
            //except monthly
            if (strpos($resultSubtype, 'monthly') === false) {
                $response['finance'] = true;
            } else {
                $response['other'] = true;
            }

        } elseif ($resultType == 'approved by bod') {
            $response['bod_approved'] = true;
            return $response;
        } else {
            $response['other'] = true;
        }

        return $response;
    }


    public function searchRecentAnnouncement(Request $request)
    {
        $result = \DB::table('announcement')
            ->join('announcement_type', 'announcement.type_id', '=', 'announcement_type.id')
            ->join('announcement_subtype', 'announcement.subtype_id', '=', 'announcement_subtype.id')
            ->join('company', 'announcement.company_id', '=', 'company.id');

        if ($request->has('company') && $request->get('company') != 0):
            $result->where('announcement.company_id', $request->get('company'));
        endif;

        if ($request->has('type')):
            $result->where('announcement.type_id', $request->get('type'));
        endif;

        if ($request->has('subtype')):
            $result->where('announcement.subtype_id', $request->get('subtype'));
        endif;

        $row = $result->orderBy('announcement.pub_date', 'desc')
            ->select([
                'announcement.id', 'announcement.title', 'announcement.pub_date as date',
                'announcement_type.label as type', 'company.name',
                'announcement.event_date as event',
                'announcement_subtype.label as subtype'
            ])->limit(15)->get();

        $response = [];
        foreach ($row as $column):
            $response[] = [
                'id' => $column->id,
                'title' => $column->title,
                'date' => Carbon::parse($column->date)->format('Y-m-d\TH:i:s'),
                'type' => $column->type,
                'subtype' => $column->subtype,
                'name' => $column->name,
                'event' => Carbon::parse($column->event)->format('j M y'),
                'link' => route('admin.announcement.show', $column->id)
            ];
        endforeach;

        return $response;
    }


    public function searchAnnouncement(Request $request)
    {
        //This can change
        // $announce = DB::table('announcement')
        //     ->join('announcement_type', 'announcement.type_id', '=', 'announcement_type.id')
        //     ->join('announcement_subtype', 'announcement.subtype_id', '=', 'announcement_subtype.id')
        //     ->orderBy('announcement.id', 'desc')
        //     ->select([
        //         'announcement.id', 'announcement.title', 'announcement.pub_date as date',
        //         'announcement_type.label as type',
        //         'announcement_subtype.label as subtype',
        //     ]);
        $announce = Announcement::with('type', 'subtype', 'company')->get();

        return Datatables::of($announce)->make(true);
    }

    public function getSample($type)
    {
        if ($type != ''):
            $reportLabel = ReportLabel::where('type', $type)->lists('label');
            $data = array();
            foreach ($reportLabel as $label):
                $data = $data + array(self::clean($label) => '');
            endforeach;
            //dd($data);
            $excel = Excel::create('samplereport', function ($excel) use ($data) {
                $excel->sheet('sheet1', function ($sheet) use ($data) {
                    $sheet->fromArray(array($data));
                    $sheet->freezeFirstRow();
                });
            })->export('xls');

        endif;
    }

    public static function clean($string)
    {
        $string = strtolower(str_replace(' ', '_', $string));
        return preg_replace('/[^A-Za-z0-9\_]/', '', $string);
    }


    //Srawan
    public function getGainer()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());

        $gainer = Cache::remember('getGainer_loser_' . $date, 720, function () use ($date) {
            return TodaysPrice::where('date', '=', $date)
                ->leftJoin('company', 'company.id', '=', 'todays_price.company_id')
                ->get()
                ->filter(function ($item) {
                    return $item->difference > 0;
                })
                ->sortByDesc('difference');
        });
        return Datatables::of($gainer)->make(true);
    }

    public function getLoser()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());

        $loser = Cache::remember('getLoser_loser_' . $date, 720, function () use ($date) {
            return TodaysPrice::where('date', '=', $date)
                ->leftJoin('company', 'company.id', '=', 'todays_price.company_id')
                ->get()
                ->filter(function ($item) {
                    return $item->difference < 0;
                })
                ->sortBy('difference');
        });
        return Datatables::of($loser)->make(true);
    }

    public function getActive()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());

        $active = TodaysPrice::where('date', '=', $date)
            ->orderBy('tran_count', 'desc')
            ->leftJoin('company', 'company.id', '=', 'todays_price.company_id')
            ->take(10)
            ->get();

        return Datatables::of($active)->make(true);
    }

    public function getLatestTradedPrice()
    {
        if ($this->request->get('sector') != 0) {
            $sector = $this->request->get('sector');
        } else {
            $sector = '';
        }
        $tp = Cache::remember('getLatestTradedPrice_tp_' . $sector, 720, function () use ($sector) {
            if ($sector != '') {
                $companyLastPrices = Company::has('latestTradedPrice')->where('sector_id', $sector)->with('latestTradedPrice')->get();
            } else {
                $companyLastPrices = Company::has('latestTradedPrice')->with('latestTradedPrice')->get();
            }

            $todaysprice = [];
            $sn = 0;
            foreach ($companyLastPrices as $company) {
                $todaysprice[$sn] = TodaysPrice::where('date', $company->latestTradedPrice->date)->where('company_id', $company->id)->with('company')->first();
                $sn++;
            }
            return $todaysprice;
        });

        return Datatables::of(collect($tp))->make(true);

    }

    public function getAdvanceDecline()
    {
        $lastmonth = $this->request->get('lastmonth', null);
        $datatable = $this->request->get('datatable', null);

        if (!is_null($datatable)) {
            if (is_null($lastmonth))
                $ad = Cache::remember('getAdvanceDecline_ad', 720, function () {
                    return AdvanceDecline::all();
                });
            else
                $ad = AdvanceDecline::whereBetween('date', [Carbon::now()->subMonth()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])->get();
            return Datatables::of($ad)->make(true);
        } else {

            $advanceDecline = Cache::remember('getAdvanceDecline_advanceDecline', 720, function () {
                return AdvanceDecline::select(DB::raw("UNIX_TIMESTAMP(STR_TO_DATE(concat(`date`,' 12:00PM'), '%Y-%m-%d %h:%i%p'))*1000 as date"), 'advance', 'decline')
                    ->orderBy('date', 'asc')
                    ->whereBetween('date', [Carbon::now()->subYear()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
                    ->get()->toArray();
            });
            $advance = array();
            $decline = array();
            $ratio = array();
            foreach ($advanceDecline as $ad) {
                array_push($advance, [floatval($ad['date']), $ad['advance']]);
                array_push($decline, [floatval($ad['date']), $ad['decline']]);
                array_push($ratio, [floatval($ad['date']), $ad['decline'] != 0 ? round(($ad['advance'] / $ad['decline']), 2) : 0]);
            }
            return ['advance' => $advance, 'decline' => $decline, 'ratio' => $ratio];
        }
    }

    public function getNewHigh()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());

        $newHigh = Cache::remember('getNewHigh_newHigh_' . $date, 720, function () use ($date) {
            return NewHighLow::select('name', 'high', 'quote')
                ->leftJoin('company', 'new_high_low.company_id', '=', 'company.id')
                ->orderBy('name')
                ->where('high_date', $date)
                ->get();
        });
        return Datatables::of($newHigh)->make(true);
    }

    public function getNewLow()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());

        $newLow = Cache::remember('getNewLow_newLow_' . $date, 720, function () use ($date) {
            return NewHighLow::select('name', 'low', 'quote')
                ->leftJoin('company', 'new_high_low.company_id', '=', 'company.id')
                ->orderBy('name')
                ->where('low_date', $date)
                ->get();
        });
        return Datatables::of($newLow)->make(true);
    }

    public function getTodaysPriceOHLC()
    {
        $company_id = $this->request->get('id', null);
        if (is_null($company_id)) return 'no company';
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate($company_id));

        $lastYear = Carbon::parse($date)->subYear()->format('Y-m-d');
        if (!is_null($company_id)) {
            $data = Cache::remember('getTodaysPriceOHLC_data_' . $company_id . '_' . $lastYear, 720, function () use ($company_id, $lastYear) {
                return TodaysPrice::select(DB::raw("UNIX_TIMESTAMP(STR_TO_DATE(concat(`date`,'12:00PM'), '%Y-%m-%d %h:%i%p'))*1000 as date,open,high,low,close,volume"))
                    ->where('company_id', $company_id)->where('date', '>', $lastYear)->orderBy('date', 'asc')->get();
            });
            $data2 = Cache::remember('getTodaysPriceOHLC_data2_' . $company_id . '_' . $lastYear . $date, 1440, function () use ($lastYear, $company_id, $date) {
                return Announcement::select(DB::raw("UNIX_TIMESTAMP(str_to_date(event_date, '%Y-%m-%d'))*1000 as date,concat(left(title,10),'...') as title, title as text, slug,type_id"))
                    ->where('company_id', $company_id)
                    ->whereNotNull('event_date')
                    ->whereBetween('event_date', [$lastYear, $date])
                    ->get();
            });
        } else
            return "null";

        $ohlc = array();
        $events = array();
        $volume = array();
        foreach ($data as $record) {
            array_push($ohlc, [floatval($record['date']), $record['open'], $record['high'], $record['low'], $record['close']]);
            array_push($volume, [floatval($record['date']), $record['volume']]);
        }
        $announcementType = AnnouncementType::lists('label', 'id')->toArray();
        foreach ($data2 as $record) {
            $obj = new \stdClass();
            $obj->x = floatval($record['date']);
            $obj->title = "<a href='" . route('front.announcement.show', [$announcementType[$record['type_id']], $record['slug']]) . "' target='_blank'>" . $record['title'] . "</a>";
            $obj->text = $record['text'];
            array_push($events, $obj);
        }
        return ['ohlc' => $ohlc, 'events' => $events, 'volume' => $volume];
    }

    public function getTodaysPriceByDay()
    {
        $company_id = $this->request->get('id', null);
        $date = $this->request->get('date', null);
        $fromDate = $this->request->get('fromdate', null);
        $toDate = $this->request->get('todate', null);
        $limit = $this->request->get('limit', null);

        $sector = $this->request->get('sector', null);
        $datatable = $this->request->get('datatable', null);

        $getTodaysTableByDate = Cache::remember('getTodaysPriceByDay_getTableByDate_' . $date . $sector . $company_id . $fromDate . $toDate . $limit . $datatable, 720, function () use ($datatable, $date, $sector, $company_id, $fromDate, $toDate, $limit) {
            $getTableByDate = TodaysPrice::leftJoin('company', 'todays_price.company_id', '=', 'company.id')
                ->leftJoin('sector', 'sector.id', '=', 'company.sector_id');

            if (!is_null($date)) $getTableByDate->where('date', $date);
            if (!is_null($fromDate) && !is_null($toDate)) $getTableByDate->whereBetween('date', [$fromDate, $toDate]);
            if (!is_null($sector)) if ($sector != 0) $getTableByDate->where('sector_id', $sector);
            if (!is_null($company_id)) $getTableByDate->where('company_id', $company_id);
            if (!is_null($limit)) $getTableByDate->take($limit);
            if (!is_null($datatable)) return Datatables::of($getTableByDate)->make(true);
            return $getTableByDate->first();
        });

        return $getTodaysTableByDate;
    }

    public function getTodaysPriceByDuration()
    {
        $toDate = $this->request->get('todate', null);
        $fromDate = $this->request->get('fromdate', null);
        $today = Carbon::now()->format('Y-m-d');
        $lastyear = Carbon::parse($today)->subWeeks(52)->format('Y-m-d');

        if ($this->request->get('sector') != 0) $sector = $this->request->get('sector');
//        $company_id = $this->request->get('id');
//        $fromDate = date('Y-m-d',strtotime('-7 days',strtotime($toDate)));

        if (!($fromDate == $toDate)) {
            $getTodaysPrice = TodaysPrice::select(
                'company_id',
                DB::raw('sum(tran_count) as tran_c'),
                DB::raw("SUBSTRING_INDEX(
				GROUP_CONCAT(CAST(close AS CHAR) ORDER BY date),
				',',
				1
			) as open_c"),
                DB::raw('max(close) as high_c'),
                DB::raw('min(close) as low_c'),
                DB::raw("SUBSTRING_INDEX(
				GROUP_CONCAT(CAST(close AS CHAR) ORDER BY date desc),
				',',
				1
			) as close_c"),
                DB::raw('round(avg(close),2) as avg_c'),
                DB::raw('sum(amount) as amount_c'),
                DB::raw('sum(volume) as volume_c')
            )
                ->groupBy('company_id')
                ->orderBy('date', 'asc')
                ->whereBetween('date', [$fromDate, $toDate]);

        } else {
            $getTodaysPrice = TodaysPrice::select(DB::raw('tran_count as tran_c, open as open_c, close as close_c, high as high_c, low as low_c,close as avg_c,amount as amount_c,volume as volume_c,company_id'))
                ->where('date', $toDate);
        }

        $getMinMax = TodaysPrice::select('company_id', DB::raw('min(close) as min'), DB::raw('max(close) as max'))
            ->whereBetween("date", [$lastyear, $today])
            ->groupBy('company_id');

        $sql = DB::table(DB::raw("({$getTodaysPrice->toSql()}) a"))
            ->mergeBindings($getTodaysPrice->getQuery())
            ->leftJoin(DB::raw("({$getMinMax->toSql()}) b"), 'a.company_id', '=', 'b.company_id')
            ->mergeBindings($getMinMax->getQuery())
            ->leftJoin('company', 'company.id', '=', 'a.company_id')
            ->leftJoin('sector', 'company.sector_id', '=', 'sector.id')
            ->select(
                DB::raw('quote,name,tran_c,open_c,high_c,low_c,close_c,amount_c,volume_c,avg_c,min,max'),
                DB::raw('((select close_c)*listed_shares) as cap_c'),
                DB::raw('close_c-open_c as diff_c'),
                DB::raw('round(((close_c-open_c)/open_c)*100,2) as per_c')
            );
        if ($this->request->get('gainer')) $sql->whereRaw('(close_c-open_c)>0')->orderByRaw('((close_c-open_c)/open_c) desc');
        if ($this->request->get('loser')) $sql->whereRaw('(close_c-open_c)<0')->orderByRaw('((close_c-open_c)/open_c) asc');
        if ($this->request->get('active')) $sql->orderBy('tran_c', 'desc')->take(20);
        if ($this->request->get('turnover')) $sql->orderBy('amount_c', 'desc')->take(20);
        if (isset($sector)) $sql->where('sector_id', $sector);
        return Datatables::of($sql)->make(true);
    }

    public function getSectorTodaysPriceByDuration()
    {
        $toDate = $this->request->get('todate');
        $fromDate = $this->request->get('fromdate');

        $totalAmtShare = Cache::remember('getSectorTodaysPriceByDuration_totalAmtShare_' . $toDate . $fromDate, 720, function () use ($fromDate, $toDate) {
            return TodaysPrice::select(DB::raw('sum(amount) tot_amt'), DB::raw('sum(volume) tot_vol'))->whereBetween('date', [$fromDate, $toDate])->first();
        });
        $result = Cache::remember('getSectorTodaysPriceByDuration_result_' . $totalAmtShare . $toDate . $fromDate, 720, function () use ($totalAmtShare, $toDate, $fromDate) {
            return TodaysPrice::select('label',
                DB::raw('count(DISTINCT company_id) as nofcompany'),
                DB::raw('sum(listed_shares*close) as market_cap'),
                DB::raw('sum(volume) as tot_share'),
                DB::raw("round(sum(volume)/{$totalAmtShare->tot_vol}*100,2) as share_per"),
                DB::raw('sum(amount) as tot_amount'),
                DB::raw("round(sum(amount)/{$totalAmtShare->tot_amt}*100,2) as share_amt"))
                ->whereBetween('date', [$fromDate, $toDate])
                ->leftJoin('company', 'company.id', '=', 'todays_price.company_id')
                ->leftJoin('sector', 'sector.id', '=', 'company.sector_id')
                ->groupBy('sector_id')
                ->get();
        });
        return Datatables::of($result)->make(true);
    }

    public function getAverageTodaysPriceByCompanyId()
    {
        $fromDate = $this->request->get('fromdate');
        $toDate = $this->request->get('todate');
        $company_id = $this->request->get('id');

        $averageTodaysPrice = Cache::remember('getAverageTodaysPriceByCompanyId_averageTodaysPrice' . $fromDate . $toDate . $company_id, 720, function () use ($fromDate, $toDate, $company_id) {
            return TodaysPrice::select(DB::raw('avg(close) average'))
                ->whereBetween('date', [$fromDate, $toDate])
                ->groupBy('company_id')
                ->where('company_id', $company_id)
                ->first();
        });
        if (!is_null($averageTodaysPrice)) return round((float)$averageTodaysPrice->average, 2);
        return 'Not Available';
    }

    public function getAverageTodaysPriceListByCompanyId()
    {
        $fromDate = $this->request->get('fromdate');
        $toDate = $this->request->get('todate');
        $company_id = $this->request->get('id');

        $averageTodaysPrice = Cache::remember('getAverageTodaysPriceListByCompanyId_averageTodaysPrice_' . $fromDate . $toDate . $company_id, 720, function () use ($fromDate, $toDate, $company_id) {
            return TodaysPrice::where('company_id', '=', $company_id)
                ->whereBetween('date', [$fromDate, $toDate])
                ->get()
                ->sortByDesc('date');
        });

        return Datatables::of($averageTodaysPrice)->make(true);
    }

    public function getAverageTodaysPriceByTransaction()
    {
        $limit = $this->request->get('limit',180);
        $toDate = $this->request->get('todate',date('Y-m-d'));
		
		
        $avgTodaysPrice = Cache::remember('getAverageTodaysPriceListByTransaction_avgerageTodaysPrice_' . $limit . $toDate , 720, function () use ($limit, $toDate) {
			//set max length for group concat as it might get long
			DB::statement(DB::raw('SET SESSION group_concat_max_len = 10000000;'));
			
			//get all the companies with close price and date joined by @ so that it can be manipulated later 
			$closeprices =  TodaysPrice::select(DB::raw("company_id, SUBSTRING_INDEX(group_concat(concat(close,'@',date) order by date),',',10000000000) close_prices"))
                ->groupBy('company_id')
                ->get();
            $companies = Company::lists('name','id');
            $quotes = Company::lists('quote','id');
			
            $output = array();
			$averages = array();
            foreach ($closeprices as $closeprice) {
				//get close prices and dates
                $closeprices_date = explode(',', $closeprice->close_prices);
				$count=0;
				$sum = 0;
				foreach($closeprices_date as $closeprice_date){
					$row = explode('@',$closeprice_date);
					
					//get close price
					$cp = floatval($row[0]);
					
					// get date
					$date = $row[1];
					if($count<$limit && $date<=$toDate)
					{
						$count++;
						$sum += $cp;
					}
				}
                array_push($output, [
                    'name' => $companies[$closeprice->company_id],
                    'quote' => $quotes[$closeprice->company_id],
                    'average' => $count !=0 ? round($sum/$count):'N/A',
                    'count' => $count
                ]);
            }
            return $output;
        });
        return Datatables::of(collect($avgTodaysPrice))->make(true);
    }

    public function getAverageTodaysPrice()
    {
        $toDate = $this->request->get('todate');
        $fromDate = $this->request->get('fromdate');

        $average = Cache::remember('getAverageTodaysPrice_average_' . $toDate . $fromDate, 720, function () use ($toDate, $fromDate) {
            $output = json_decode(json_encode(DB::table('todays_price')->select('company_id', 'date', 'close', 'name', 'quote')->whereRaw("(company_id, date) IN ( SELECT company_id, date FROM last_traded_price)")
                    ->leftJoin('company', 'todays_price.company_id', '=', 'company.id')
                    ->whereBetween('date', [$fromDate, $toDate])
                    ->get())
                , true);

            $avg = DB::table('todays_price')->select(DB::raw("company_id, round(avg(close),2) as average"))
                ->whereBetween('date', [$fromDate, $toDate])
                ->groupBy('company_id')
                ->lists('average', 'company_id');

            foreach ($output as $key => $value) {
                if (array_key_exists($value['company_id'], $avg)) {
                    $output[$key]['average'] = $avg[$value['company_id']];
                } else {
                    $output[$key]['average'] = "N/A";
                }
            }
            return $output;
        });
        return Datatables::of(collect($average))->make(true);
    }

    public function getIndex()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());
        $fromDate = Carbon::parse($date)->subDay()->subYear()->format('Y-m-d');

        $type = $this->request->get('type', null);

        $limit = $this->request->get('limit', null);
        $order = $this->request->get('order', null);
        $datatable = $this->request->get('datatable', null);

        if ($type == null)
            return 'No Type Defined';

        $in = Cache::remember('getIndex_index_' . $fromDate . $date . $type . $limit . $order, 720, function () use ($fromDate, $date, $type, $limit, $order) {
            $index = Index::whereBetween('date', [$fromDate, $date])->with(['indexValue' => function ($q) use ($type) {
                $q->where('type_id', $type);
            }]);
            if ($limit != null)
                $index = $index->take($limit);

            $index = $index->orderBy(
                'date',
                in_array($order, ['desc', 'asc']) ? $order : 'asc'
            );

            return $index->get();
        });

        $result = array();
        $counter = 0;

        foreach ($in as $item) {
            foreach ($item->indexValue as $value) {
                $result[$counter] = [(Carbon::parse($item->date . '12:00:00')->format('U')) * 1000, $value->value];
                $counter++;
            }
        }

        return $result;
    }

    public function getIndexDatatable()
    {
        $type = $this->request->get('type', null);
        $limit = $this->request->get('limit', 20);

        if ($type == null) return "No Type Defined";

        $index = Cache::remember('getIndexDatatable_index_' . $type . $limit, 720, function () use ($type, $limit) {
            return IndexValue::leftJoin('index', 'index_value.index_id', '=', 'index.id')->where('type_id', $type)->orderBy('date', 'desc')->take($limit)->get();
        });

        $counter = 0;
        $data = array();
        foreach ($index as $in) {
            $prev = $in->previous() == null ? 0 : $in->previous()->value;
            $data[$counter] = ['date' => $in->index->date, 'value' => $in->value, 'previous' => $prev, 'change' => $in->change(), 'percent' => $in->changePercent()];
            $counter++;
        }
        return Datatables::of(collect($data))->make(true);
    }

    public function getIndexSummaryDatatable()
    {
        $date = $this->request->get('date', Index::getLatestDate());

        //exclude float mkt capitalization and market capitalization
        $excludeTypes = IndexType::where('name', 'like', '%market capitalization%')->orWhere('name', 'like', '%float mkt cap%')->lists('id')->toArray();

        $index = Cache::remember('getIndexSummaryDatatable_index_' . $date, 720, function () use ($date, $excludeTypes) {
            return IndexValue::leftJoin('index_type', 'index_value.type_id', '=', 'index_type.id')
                ->leftJoin('index', 'index_value.index_id', '=', 'index.id')
                ->where('date', $date)
                ->whereNotIn('type_id', $excludeTypes)
                ->orderBy('index_type.id', 'asc')
                ->get();
        });

        $counter = 0;

        $data = array();
        foreach ($index as $in) {
            $prev = $in->previous() == null ? 0 : $in->previous()->value;
            $data[$counter] = ['id' => $in->type_id, 'name' => $in->type->name, 'value' => $in->value, 'previous' => $prev, 'change' => $in->change(), 'percent' => $in->changePercent()];
            $counter++;
            $counter++;
        }

        return Datatables::of(collect($data))->make(true);
    }

    public function getFloorsheet()
    {
        $date = $this->request->get('date', '');
        $fromDate = $this->request->get('fromdate', '');
        $toDate = $this->request->get('todate', '');
        $buyer_broker = $this->request->get('buyer_broker', '');
        $seller_broker = $this->request->get('seller_broker', '');
        $company = strtoupper($this->request->get('company', ''));
        $company_id = $this->request->get('company_id', '');
        $quote = strtoupper($this->request->get('quote', ''));

        $dt = Cache::remember('getFloorsheet_dt' . $date . $fromDate . $toDate . $buyer_broker . $seller_broker . $company . $company_id . $quote, 720, function () use ($date, $fromDate, $toDate, $buyer_broker, $seller_broker, $company, $company_id, $quote) {
            $floorsheet = FloorSheet::select('transaction_no as t', 'buyer_broker as b', 'seller_broker as s', 'quantity as qt', 'rate as r', 'amount as a', 'name as n', 'quote as q', 'date as d');

            if (!empty($date)) $floorsheet->where('date', '=', $date);
            if (!empty($fromDate) && !empty($toDate)) $floorsheet->whereBetween('date', [$fromDate, $toDate]);

            if (!empty($company_id)) $floorsheet->where('company_id', $company_id);

            $floorsheet->leftJoin('company', 'floorsheet.company_id', '=', 'company.id')
                ->orderBy('name', 'asc');

            if (!empty($buyer_broker) && !($buyer_broker == "")) {
                $floorsheet->where('buyer_broker', '=', $buyer_broker);
            }
            if (!empty($seller_broker) && !($seller_broker == "")) {
                $floorsheet->where('seller_broker', '=', $seller_broker);
            }

            if (!empty($company) && !($company == "")) {
                $floorsheet->where('company.name', 'LIKE', "%{$company}%");
            };

            if (!empty($quote) && !($quote == "")) {
                $floorsheet->where('company.quote', 'LIKE', "%{$quote}%");
            };

            return Datatables::of($floorsheet)->make(true);
        });

        // if (sizeof($dt->getData()->data) > 600):
            return Datatables::of(collect($dt->getData()->data))->make(true);
        // endif;

        // return $dt;
    }

    function getIndexesOHLC()
    {
        $toDate = $this->request->get('date', Carbon::now()->format('Y-m-d'));
        $fromDate = $this->request->get('fromdate', Carbon::now()->subMonth()->format('Y-m-d'));

        $indexDateIDS = Index::whereBetween('date', [$fromDate, $toDate])->orderBy('date', 'asc')->lists('id')->toArray();

        $groupdeIndexes = IndexValue::whereIn('index_id', $indexDateIDS)->get()->groupBy('type_id')->sortBy('type_id'); //group by type

        $indexTypes = IndexType::lists('name', 'id')->toArray();
        $ohlc = array();
        foreach ($groupdeIndexes as $index) {
            $index->sortBy('date'); //sort by date and store
            $ohlc[$index->first()->type_id] = ['id' => $index->first()->type_id, 'type' => $indexTypes[$index->first()->type_id], 'open' => $index->first()->value, 'high' => $index->max('value'), 'low' => $index->min('value'), 'close' => $index->last()->value];
        }

        return Datatables::of(collect($ohlc))->make(true);
    }

    function getIndexesSummary()
    {
        $fromDate = $this->request->get('fromdate');
        $toDate = $this->request->get('todate');

        // get the index type ids
        $indexes = IndexValue::leftJoin('index_type', 'index_value.type_id', '=', 'index_type.id')
            ->leftJoin('index', 'index_value.index_id', '=', 'index.id')
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('name', 'not like', '%market cap%')
            ->where('name', 'not like', '%float mkt cap%')
            ->get()->groupBy('date');

        $output = [];
        foreach ($indexes as $date => $indexValues) {
            $row = [];
            $row['date'] = $date;
            foreach ($indexValues as $value) {
                $row["{$value->name}"] = $value->value;
            }
            array_push($output, $row);
        }

        return Datatables::of(collect($output))->make(true);
    }

    public function getMarketSummary()
    {
        $fromDate = $this->request->get('fromdate');
        $toDate = $this->request->get('todate');

        $summary = (array)DB::table('todays_price')->select(DB::raw('count(distinct date) as nofdays,count(distinct company_id) as nofcompany, sum(tran_count) as totaltran, sum(volume) as totalvol, round(sum(amount)/1000000,2) as totalamt, round(avg(volume),2) as avgvol, round(avg(amount)/1000000,2) as avgamt'))
            ->whereBetween('todays_price.date', [$fromDate, $toDate])->first();

        return json_decode(json_encode($summary), true);
    }

    public function getDetailedMarketSummary()
    {
        $fromDate = $this->request->get('fromdate');
        $toDate = $this->request->get('todate');

        $data = Cache::remember('getDetailedMarketSummary_data_' . $fromDate . $toDate, 720, function () use ($fromDate, $toDate) {
            $marketCap = Index::select('index.date', 'value as market_value')
                ->leftJoin('index_value', 'index_value.index_id', '=', 'index.id')
                ->leftJoin('index_type', 'index_type.id', '=', 'index_value.type_id')
                ->whereBetween('date', [$fromDate, $toDate])
                ->where('name', 'like', 'market cap%');

            $floatCap = Index::select('index.date', 'value as float_value')
                ->leftJoin('index_value', 'index_value.index_id', '=', 'index.id')
                ->leftJoin('index_type', 'index_type.id', '=', 'index_value.type_id')
                ->whereBetween('date', [$fromDate, $toDate])
                ->where('name', 'like', 'float mkt cap%');

            $todays_price = TodaysPrice::select(DB::raw('todays_price.date,count(distinct company_id) as nofcompany, sum(tran_count) as totaltran, sum(volume) as totalvol, round(sum(amount),2) as totalamt'))
                ->whereBetween('todays_price.date', [$fromDate, $toDate])->groupBy('todays_price.date');
            $data = DB::table(DB::raw("({$todays_price->toSql()}) t "))
                ->mergeBindings($todays_price->getQuery())
                ->leftJoin(DB::raw("({$marketCap->toSql()}) m"), 't.date', '=', 'm.date')
                ->mergeBindings($marketCap->getQuery())
                ->leftJoin(DB::raw("({$floatCap->toSql()}) f"), 't.date', '=', 'f.date')
                ->mergeBindings($floatCap->getQuery())
                ->select(DB::raw('t.date as date,nofcompany,totaltran,totalamt,totalvol,market_value,float_value'))
                ->get();

            return $data;
        });

        return Datatables::of(collect($data))->make(true);
    }

    public function getTodaysSummaryDatatable()
    {
        $date = $this->request->get('date', TodaysPrice::getLastTradedDate());
        $summary = TodaysPrice::getSummaryByDate($date);

        if (!$summary) return 'Something happened'; // if no summary is received

        return $summary;
    }

    public function getCompanyTrans()
    {
        $company_id = $this->request->get('id', null);
        $lastDate = $this->request->get('lastDate', null);
        $lastMonth = Carbon::parse($lastDate)->subMonth()->format('Y-m-d');

        if (is_null($company_id)) return "No company defined";

        $trans = FloorSheet::where('company_id', $company_id)
            ->select(DB::raw("date, rate"))
            ->orderBy('transaction_no', 'asc')
            ->whereBetween('date', [$lastMonth, $lastDate])
            ->get(['rate', 'date']);

        $output = [];
        $count = 1;
        foreach ($trans as $record) {
            array_push($output, [floatval($count . '.' . Carbon::createFromFormat('Y-m-d', $record->date)->format('U') . '000'), $record->rate]);
            $count++;
        }
        return $output;
    }

    public function getCompanyClose($company_id = null, $ohlc = null)
    {
        $company_id = $this->request->get('id', null);
        if ($company_id == null) return 0;
        $today = Carbon::now()->format('Y-m-d');

        $lastYear = Carbon::now()->subYear(1)->format('Y-m-d');
        $lastFiveYear = Carbon::now()->subYears(5)->format('Y-m-d');

        $limit = $this->request->has('extended_timeline') ? $lastFiveYear : $lastYear;

        $closePrice = Cache::rememberForever('getCompanyClose_' . $company_id . $today . $limit . $ohlc, function () use ($limit, $today, $company_id, $ohlc) {
            $close = TodaysPrice::where('company_id', $company_id)
                ->select(DB::raw("UNIX_TIMESTAMP(STR_TO_DATE(concat(`date`,'12:00 PM'), '%Y-%m-%d %h:%i%p'))*1000 as date, close, open, high, low"))
                ->orderBy('date', 'asc')
                ->whereBetween('date', [$limit, $today])
                ->get(['close', 'date']);

            $output = [];
            if ($ohlc == 1) {
                foreach ($close as $record) {
                    array_push($output, [floatval($record->date), $record->close, $record->open, $record->high, $record->low]);
                }
            } else {
                foreach ($close as $record) {
                    array_push($output, [floatval($record->date), $record->close]);
                }
            }
            return $output;
        });

        return $closePrice;
    }

    public function getIndexClose($index_id = null)
    {
        $index_id = $this->request->get('id', null);

        if ($index_id == null) return 0;

        $today = Carbon::now()->format('Y-m-d');

        $lastYear = Carbon::now()->subYear(1)->format('Y-m-d');
        $lastFiveYear = Carbon::now()->subYears(5)->format('Y-m-d');

        $limit = $this->request->has('extended_timeline') ? $lastFiveYear : $lastYear;

        $closePrice = Cache::rememberForever('getIndexClose_' . $index_id . $today . $limit, function () use ($limit, $today, $index_id) {
            $close = IndexValue::leftJoin('index', 'index_value.index_id', '=', 'index.id')
                ->where('type_id', $index_id)
                ->select(DB::raw("UNIX_TIMESTAMP(STR_TO_DATE(concat(`date`,'12:00 PM'), '%Y-%m-%d %h:%i%p'))*1000 as date, value"))
                ->orderBy('date', 'asc')
                ->whereBetween('date', [$limit, $today])
                ->get(['value', 'date']);

            $output = [];

            foreach ($close as $record) {
                array_push($output, [floatval($record->date), $record->value]);
            }
            return $output;
        });


        return $closePrice;
    }


    //Rojer
    public function getBullion()
    {
        $date = $this->request->get('date', Bullion::getLatestDate());
        $fromDate = Carbon::parse($date)->subYear()->format('Y-m-d');

        $type = $this->request->get('type', null);

        $limit = $this->request->get('limit', null);
        $order = $this->request->get('order', null);
        $datatable = $this->request->get('datatable', null);

        if ($type == null)
            return 'No Type has been defined. Define Type.';

        $bullion = Bullion::whereBetween('date', [$fromDate, $date])->with(['bullionPrice' => function ($q) use ($type) {
            $q->where('type_id', $type);
        }]);

        if ($limit != null)
            $bullion = $bullion->take($limit);

        $bullion = $bullion->orderBy(
            'date',
            in_array($order, ['desc', 'asc']) ? $order : 'asc'
        );

        $result = array();
        $counter = 0;

        foreach ($bullion->get() as $item) {
            foreach ($item->bullionPrice as $value) {
                $result[$counter] = [(Carbon::parse($item->date . '12:00:00')->format('U')) * 1000, $value->price];
                $counter++;
            }
        }

        return $result;
    }

    public function getBullionDatatable()
    {
        $type = $this->request->get('type', null);
        $limit = $this->request->get('limit', 20);

        if ($type == null) return "No type defined";

        $bullion = BullionPrice::leftJoin('bullion', 'bullion_price.bullion_id', '=', 'bullion.id')->where('type_id', $type)->orderBy('date', 'desc')->take($limit)->get();
        $counter = 0;
        $data = array();
        foreach ($bullion as $bull) {
            $prev = $bull->previous() == null ? 0 : $bull->previous()->price;
            $data[$counter] = ['date' => $bull->bullion->date, 'price' => $bull->price, 'previous' => $prev, 'change' => $bull->change(), 'percent' => $bull->changePercent()];
            $counter++;
        }
        return Datatables::of(collect($data))->make(true);
    }

    public function getEnergy()
    {
        $date = $this->request->get('date', Energy::getLatestDate());
        $fromDate = Carbon::parse($date)->subYear()->format('Y-m-d');

        $type = $this->request->get('type', null);

        $limit = $this->request->get('limit', null);
        $order = $this->request->get('order', null);
        $datatable = $this->request->get('datatable', null);

        if ($type == null)
            return 'No Type has been defined. Define Type.';

        $energy = Energy::whereBetween('date', [$fromDate, $date])->with(['energyPrice' => function ($q) use ($type) {
            $q->where('type_id', $type);
        }]);

        if ($limit != null)
            $energy = $energy->take($limit);

        $energy = $energy->orderBy(
            'date',
            in_array($order, ['desc', 'asc']) ? $order : 'asc'
        );

        $result = array();
        $counter = 0;

        foreach ($energy->get() as $item) {
            foreach ($item->energyPrice as $value) {
                $result[$counter] = [(Carbon::parse($item->date . '12:00:00')->format('U')) * 1000, $value->price];
                $counter++;
            }
        }

        return $result;
    }

    public function getEnergyDatatable()
    {
        $type = $this->request->get('type', null);
        $limit = $this->request->get('limit', 20);

        if ($type == null) return "No type defined";

        $energy = EnergyPrice::leftJoin('energy', 'energy_price.energy_id', '=', 'energy.id')->where('type_id', $type)->orderBy('date', 'desc')->take($limit)->get();
        $counter = 0;
        $data = array();
        foreach ($energy as $ene) {
            $prev = $ene->previous() == null ? 0 : $ene->previous()->price;
            $data[$counter] = ['date' => $ene->energy->date, 'price' => $ene->price, 'previous' => $prev, 'change' => $ene->change(), 'percent' => $ene->changePercent()];
            $counter++;
        }
        return Datatables::of(collect($data))->make(true);
    }

    public function getCurrency()
    {
        $date = $this->request->get('date', Currency::getLatestDate());
        $fromDate = Carbon::parse($date)->subYear()->format('Y-m-d');
        $buySell = $this->request->get('buySell', 0);

        $type = $this->request->get('type', null);

        $limit = $this->request->get('limit', null);
        $order = $this->request->get('order', null);
        $datatable = $this->request->get('datatable', null);

        if ($type == null)
            return 'No Type has been defined. Define Type.';

        $currency = Currency::whereBetween('date', [$fromDate, $date])->with(['currencyRate' => function ($q) use ($type) {
            $q->where('type_id', $type);
        }]);

        if ($limit != null)
            $currency = $currency->take($limit);

        $currency = $currency->orderBy(
            'date',
            in_array($order, ['desc', 'asc']) ? $order : 'asc'
        );

        $result = array();
        $counter = 0;

        foreach ($currency->get() as $item) {
            foreach ($item->currencyRate as $value) {
                $result[$counter] = [(Carbon::parse($item->date . '12:00:00')->format('U')) * 1000, $buySell == 0 ? $value->buy : $value->sell];
                $counter++;
            }
        }

        return $result;
    }

    public function getCurrencyDatatable()
    {
        $type = $this->request->get('type', null);
        $limit = $this->request->get('limit', 20);

        if ($type == null) return "No type defined";

        $currency = CurrencyRate::leftJoin('currency', 'currency_rate.currency_id', '=', 'currency.id')->where('type_id', $type)->orderBy('date', 'desc')->take($limit)->get();
        $counter = 0;
        $data = array();
        foreach ($currency as $cur) {
            $prevBuy = $cur->previous() == null ? 0 : $cur->previous()->buy;
            $prevSell = $cur->previous() == null ? 0 : $cur->previous()->sell;
            $data[$counter] = [
                'date' => $cur->currency->date,
                'buy' => $cur->buy, 'previousBuy' => $prevBuy,
                'sell' => $cur->sell, 'previousSell' => $prevSell,
                'changeBuy' => $cur->change('buy'), 'changeSell' => $cur->change('sell'),
                'percentBuy' => $cur->changePercent('buy'), 'percentSell' => $cur->changePercent('sell')];
            $counter++;
        }
        return Datatables::of(collect($data))->make(true);
    }

    public function getIpoPipeline()
    {
        $fiscal_year_id = $this->request->get('fiscal_year_id');

        $ipoPipeline = IPOPipeline::with(['company' => function ($q) {
            $q->with('sector');
        }, 'announcementSubtype', 'ipoIssueManager' => function ($q1) {
            $q1->with('issueManager');
        }]);

        if($fiscal_year_id) {
            $ipoPipeline->where('fiscal_year_id', $fiscal_year_id)->get();
        } else {
            $ipoPipeline->get();
        }

        return Datatables::of($ipoPipeline)->make(true);
    }

    public function getBrokerageFirm()
    {
        $getTable = BrokerageFirm::orderBy('firm_name', 'asc');
        return Datatables::of($getTable)->make(true);
    }

    public function getBasePrice()
    {
        $fiscal_year_id = $this->request->get('fiscal_year_id', null);

        if (is_null($fiscal_year_id)) return "No fiscal year id found.";

        $getTableByFiscalYear = FiscalYear::where('fiscal_year.id', $fiscal_year_id)
            ->rightJoin('base_price', 'base_price.fiscal_year_id', '=', 'fiscal_year.id')
            ->leftJoin('company', 'base_price.company_id', '=', 'company.id')
            ->leftJoin('sector', 'sector.id', '=', 'company.sector_id')
            ->select('company.quote', 'company.name', 'sector.label', 'price', 'date');
        return Datatables::of($getTableByFiscalYear)->make(true);
    }

    public function getBudget()
    {
        $fiscal_year_id = $this->request->get('fiscal_year_id', null);

        if (is_null($fiscal_year_id)) return "No fiscal year id found.";

        $getBudgetByFiscalYear = BudgetFiscalYear::where('budget_fiscal_year.id', $fiscal_year_id)->has('budget')->with('budget.budgetLabel.subLabel.subValue')->first();

        return $getBudgetByFiscalYear;
    }

    public function getNOFTradedDaysBetween()
    {
        $from = $this->request->get('fromdate');
        $to = $this->request->get('todate');

        return Cache::remember('getNOFTradedDaysBetween_' . $from . $to, 1440, function () use ($to, $from) {
            return TodaysPrice::select(DB::raw('count(distinct date) as traded_days'))->whereBetween('date', [$from, $to])->first()->traded_days;
        });
    }
}