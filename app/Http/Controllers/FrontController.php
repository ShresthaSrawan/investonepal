<?php

namespace App\Http\Controllers;

use App\GoogleURL;
use App\Http\Requests\ContactFormRequest;
use App\Models\AgmFiscal;
use App\Models\Announcement;
use App\Models\AnnouncementSubType;
use App\Models\AnnouncementType;
use App\Models\BalanceSheet;
use App\Models\BodPost;
use App\Models\BondDebenture;
use App\Models\BonusDividendDistribution;
use App\Models\BudgetFiscalYear;
use App\Models\Bullion;
use App\Models\BullionPrice;
use App\Models\BullionType;
use App\Models\Company;
use App\Models\CompanyReview;
use App\Models\ConsolidateRevenue;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\CurrencyType;
use App\Models\EconomyLabel;
use App\Models\EconomyValue;
use App\Models\Energy;
use App\Models\EnergyPrice;
use App\Models\EnergyType;
use App\Models\FinancialHighlight;
use App\Models\FiscalYear;
use App\Models\IncomeStatement;
use App\Models\Index;
use App\Models\IndexType;
use App\Models\IndexValue;
use App\Models\InterviewArticle;
use App\Models\IPOPipeline;
use App\Models\IPOResult;
use App\Models\IssueManager;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PrincipalIndicators;
use App\Models\ProfitLoss;
use App\Models\ReportLabel;
use App\Models\Sector;
use App\Models\Tags;
use App\Models\TodaysPrice;
use App\Models\TreasuryBill;
use App\Models\Watchlist;
use Auth;
use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use yajra\Datatables\Datatables;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->initialize();
    }

    public function index()
    {
        $lastDate = TodaysPrice::getLastTradedDate();

        $bullion = Bullion::with('bullionPrice.type')->orderBy('date', 'desc')->first();

        $energy = Energy::with('energyPrice.type')->orderBy('date', 'desc')->first();

        $currency = Currency::with('currencyRate.type')->orderBy('date', 'desc')->first();

        $currentFiscalYear = FiscalYear::has('agmFiscal')->orderBy('label', 'desc')->first();

        //Current+Upcoming Issues Start
        $subType = [ 'right', 'ipo', 'fpo', 'mutual fund' ];
        $today   = Carbon::now();

        $issues = Cache::remember('getIssue_all_issues_' . $today, 1440, function () use ($subType, $today)
        {
            $issues = [];
            foreach($subType as $sub)
            {
                $issues[$sub] = Announcement::leftJoin('announcement_type', 'announcement_type.id', '=', 'announcement.type_id')
                                ->leftJoin('announcement_subtype', 'announcement_subtype.id', '=', 'announcement.subtype_id')
                                ->leftJoin('company', 'company.id', '=', 'announcement.company_id')
                                ->leftJoin('issue', 'issue.announcement_id', '=', 'announcement.id')
                                ->select('announcement.id', 'company.name', 'announcement_subtype.label as subLabel', 'kitta', 'issue_date', 'close_date', 'quote', 'announcement_type.label as label', 'announcement.slug')
                                ->where('announcement_type.label', 'issue open')
                                ->where('announcement_subtype.label', $sub)
                                ->where('close_date', '>=', date('Y-m-d'))
                                ->limit(7)
                                ->get()
                                ->groupBy('id');
            }

            return $issues;
        });
        //Current+Upcoming Issues End

        $bodApproved = Cache::remember('index_bodApproved_' . $currentFiscalYear, 720, function () use ($currentFiscalYear)
        {
            return BonusDividendDistribution::where('fiscal_year_id', $currentFiscalYear->id)->where('is_bod_approved', '1')->with('company', 'announcement')->orderBy('distribution_date', 'desc')->limit(7)->get();
        });

        $annualGeneralMeeting = Cache::remember('index_annualGeneralMeeting_' . $currentFiscalYear, 720, function () use ($currentFiscalYear)
        {
            return AgmFiscal::where('fiscal_year_id', $currentFiscalYear->id)->with([
                'agm' => function ($q)
                {
                    $q->whereDate('agm_date', '>=', date('Y-m-d'));
                    $q->with('company', 'announcement')->orderBy('agm_date', 'desc');
                }
            ])->whereHas('agm', function ($q)
            {
                $q->whereDate('agm_date', '>=', date('Y-m-d'));
            })->limit(7)->get()->sortBy('agm.agm_date');
        });

        $certificate = Cache::remember('index_certificate_' . $currentFiscalYear, 720, function () use ($currentFiscalYear)
        {
            return BonusDividendDistribution::where('fiscal_year_id', $currentFiscalYear->id)->where('is_bod_approved', '<>', '1')->with('company', 'announcement')->orderBy('distribution_date', 'desc')->limit(7)->get();
        });

        $news = Cache::remember('index_news', 720, function ()
        {
            return News::with('imageNews', 'category')->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(20)->get();
        });

        $newsCategories = Cache::remember('index_newsCategories', 1440, function ()
        {
            return NewsCategory::whereIn('label', [ 'Stock', 'bullion', 'currency', 'Energy' ])->get();
        });

        $index      = Index::with('indexValue.type')->orderBy('date', 'desc')->first();
        $filter     = $this->filter;
        $captionize = $this->captionize;

        $announcements = Cache::remember('index_announcements', 720, function ()
        {
            return Announcement::with('type', 'subtype', 'company', 'issue.fiscalYear', 'issue.auction', 'agm', 'bonusDividend', 'bondDebenture', 'treasuryBill', 'financialHighlight')->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(12)->get();
        });

        $events = Cache::remember('index_events', 720, function ()
        {
            return Announcement::orderBy('event_date', 'asc')->where('event_date', '!=', '0000-00-00')->whereDate('event_date', '>=', date('Y-m-d'))->whereDate('pub_date', '<=', date('Y-m-d'))->limit(12)->get();
        });

        $summary = Cache::remember('index_summary_' . $lastDate, 720, function () use ($lastDate)
        {
            return TodaysPrice::getSummaryByDate($lastDate);
        });

        return view('front.index', compact('lastDate', 'bullion', 'index', 'news', 'announcements', 'events', 'newsCategories', 'filter', 'captionize', 'energy', 'currency', 'certificate', 'bodApproved', 'annualGeneralMeeting', 'issues', 'summary'));
    }

    public function getEvent(Request $request)
    {
        if ($request->has('news') || $request->has('announcement')):
            $start = Carbon::createFromTimestamp($request->start)->format('Y-m-d H:i:s');
            $end   = Carbon::createFromTimestamp($request->end)->format('Y-m-d H:i:s');

            $reFormat = function ($params, $route)
            {
                $result = [];
                foreach ($params as $param):
                    $title           = $param->title;
                    $id              = $param->id;
                    $micro           = $param->id . strtotime($param['created_at']);
                    $temp['sn']      = $id;
                    $temp['title']   = $title;
                    $temp['details'] = mb_strimwidth(strip_tags($param->details), 0, 160, '...');
                    $temp['image']   = $param->imageThumbnail(313, 450);
                    if ($param->type):
                        $start         = $param->event_date;
                        $time          = ( $param->agm ) ? 'T' . $param->agm->time : null;
                        $temp['start'] = $start . $time;
                        $temp['link']  = route($route, [ $param->type->label, $param->slug ]);
                    else:
                        $temp['link']  = route($route, [ strtolower($param->category->label), $param->slug ]);
                        $temp['start'] = $param->event_date;
                    endif;

                    $result[] = $temp;
                endforeach;

                return $result;
            };
            $response = false;

            if ($request->has('news')):
                $response = $reFormat(News::with('category')->whereBetween('event_date', [
                    $start,
                    $end
                ])->get(), 'front.news.show');
            elseif ($request->has('announcement')):
                $response = $reFormat(Announcement::with('agm', 'type', 'subtype')->whereBetween('event_date', [
                    $start,
                    $end
                ])->get(), 'front.announcement.show');
            endif;

            return $response;
        endif;

        return view('front.event.index');
    }

    public function getStock($category = "")
    {
        if ($category == "")
        {
            return redirect()->route('stock', 'today');
        }

        $lastDate = Cache::remember('getStock_lastDate', 720, function ()
        {
            return TodaysPrice::getLastTradedDate();
        });

        if (strcasecmp('index', $category) == 0)
        {
            $indexTypes = IndexType::lists('name', 'id')->toArray();

            $allCategories = NewsCategory::all();

            //Aside news item
            $newsList = [];
            foreach ($allCategories as $id => $cat)
            {
                $newsList[ $cat->id ] = News::getSortedNewsByCategory($cat->id);
            }

            return view('front/stock/indexes', compact('indexTypes', 'lastDate', 'newsList', 'allCategories'));

        }
        elseif (strcasecmp('today', $category) == 0)
        {
            $sectorList = Sector::lists('label', 'id')->toArray();

            return view('front/stock/today', compact('lastDate', 'sectorList'));

        }
        elseif (strcasecmp('floorsheet', $category) == 0)
        {
            return view('front/stock/floorsheet', compact('lastDate'));

        }
        elseif (strcasecmp('newhighlow', $category) == 0)
        {
            return view('front/stock/newhighlow', compact('lastDate'));

        }
        elseif (strcasecmp('advancedecline', $category) == 0)
        {
            return view('front/stock/advancedecline', compact('lastDate'));

        }
        elseif (strcasecmp('topperformers', $category) == 0)
        {
            return view('front/stock/topperformers', compact('lastDate'));

        }
        elseif (strcasecmp('lastprice', $category) == 0)
        {
            $sectorList = Cache::remember('getStock_sectorList', 720, function ()
            {
                return Sector::lists('label', 'id')->toArray();
            });

            return view('front/stock/lastprice', compact('lastDate', 'sectorList'));

        }
        elseif (strcasecmp('averageprice', $category) == 0)
        {
            $companyList = Cache::remember('getStock_companyList', 1440, function ()
            {
                return Company::lists('name', 'id')->toArray();
            });

            return view('front/stock/average', compact('companyList', 'lastDate'));

        }
        elseif (strcasecmp('marketreport', $category) == 0)
        {
            $indexList = Cache::remember('getStock_indexList', 1440, function ()
            {
                return IndexType::where('name', 'not like', '%market cap%')->where('name', 'not like', '%float mkt cap%')->lists('name')->toArray();
            });

            $sectorList = Sector::lists('label', 'id')->toArray();

            return view('front/stock/marketreport', compact('lastDate', 'sectorList', 'indexList'));

        }
        else
        {
            return redirect()->route('stock');
        }

    }

    public function getQuote(Request $request, $quote = "")
    {
        if ($request->isMethod('post')):
            $quote = $request->get('quote');

            return redirect()->route('quote', $quote);
        endif;
        if ( ! Company::whereQuote($quote)->first())
        {
            return null;
        }
        $company = Cache::remember('getQuote_company_' . $quote, 1440, function () use ($quote)
        {
            return Company::whereQuote($quote)->with([
                'details' => function ($q1)
                {
                    $q1->with('issueManager');
                },
                'bod'     => function ($q2)
                {
                    $q2->with([ 'bodPost', 'bodFiscalYear.fiscalYear' ]);
                }
            ])->first();
        });

        $newsList = Cache::remember('getQuote_newsList_' . $company->id, 720, function () use ($company)
        {
            return News::with('category')->where('company_id', $company->id)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(10)->take(10)->get();
        });

        $annList = Cache::remember('getQuote_annList_' . $company->id, 720, function () use ($company)
        {
            return Announcement::with('type')->where('company_id', $company->id)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(10)->take(10)->get();
        });

        $financialHighlight = Cache::remember('getQuote_financialHighlight_' . $company->id, 1440, function () use ($company)
        {
            return FinancialHighlight::with('announcement', 'fiscalYear')->where('company_id', $company->id)->orderBy('announcement_id', 'desc')->first();
        });

        $lastDate = TodaysPrice::getLastTradedDate($company->id);

        /*Start of Financial Report*/
        $report['balanceSheet'] = $this->getBalanceSheet($company->id);

        $sectorLabel = strtolower($company->sector->label);

        $reportLabel = ReportLabel::all();

        if ($sectorLabel == 'insurance' || $sectorLabel == 'life insurance'):
            $report['consolidateRevenue'] = $this->getConsolidateRevenue($company->id);
            $report['incomeStatement']    = $this->getIncomeStatement($company->id);
        elseif ($sectorLabel == 'commercial banks' || $sectorLabel == 'development bank' || $sectorLabel == 'finance'):
            $report['profitLoss']          = $this->getProfitLoss($company->id);
            $report['principalIndicators'] = $this->getPrincipalIndicators($company->id);
        else:
            $report['profitLoss'] = $this->getProfitLoss($company->id);
        endif;

        /*Start of Company Competitor*/

        $lastTradedPrices = Cache::remember('getQuote_lastTradedPrices_' . $company->id, 720, function () use ($company)
        {
            return Company::with('latestTradedPrice')->has('latestTradedPrice')->where('sector_id', $company->sector_id)->get();
        });
        if ( ! ( $lastTradedPrices->isEmpty() ) && ! ( $company->latestTradedPrice == null )):

            $upCompetitor = Cache::remember('getQuote_upCompetitor_' . $company->id, 720, function () use ($lastTradedPrices, $company)
            {
                return $lastTradedPrices->filter(function ($item) use ($company)
                {
                    return ( intval($item->latestTradedPrice->value) >= $company->latestTradedPrice->value && intval($item->latestTradedPrice->value) <= ( $company->latestTradedPrice->value * 1.2 ) && $item->id != $company->id );
                })->sortBy('value')->take(3);
            });

            $downCompetitor = Cache::remember('getQuote_downCompetitor_' . $company->id, 720, function () use ($lastTradedPrices, $company)
            {
                return $lastTradedPrices->filter(function ($item) use ($company)
                {
                    return ( intval($item->latestTradedPrice->value) <= $company->latestTradedPrice->value && intval($item->latestTradedPrice->value) >= ( $company->latestTradedPrice->value * 0.8 ) && $item->id != $company->id );
                })->sortByDesc('value')->take(3);
            });

            $competitor = $upCompetitor->merge($downCompetitor);
        else:
            $competitor = null;
        endif;

        /*Get Personal Review*/
        $review = "";
        if (Auth::check())
        {
            $personalReview = Cache::remember('getQuote_personalReview_' . $company->id . ( Auth::id() ), 10, function () use ($company)
            {
                $today            = Carbon::now()->format('Y-m-d');
                $startOfthisMonth = Carbon::now()->startOfMonth()->format('Y-m-d');

                return CompanyReview::whereBetween('date', [
                    $startOfthisMonth,
                    $today
                ])->where('company_id', $company->id)->where('user_id', Auth::id())->first();
            });

            $watchlist = Cache::remember('getQuote_watchlist_' . $company->id . ( Auth::id() ), 10, function () use ($company)
            {
                return Watchlist::whereCompanyId($company->id)->whereUserId(Auth::id())->first();
            });
        }

        $rts = Cache::remember('getQuote_rts_' . $company->id, 720, function () use ($company)
        {
            if ($company->details->issue_manager_id == 0):
                return "Self";
            else:
                return $company->details->issueManager;
            endif;
        });

        //where subtype = financial report = 6
        $publishedReports = Announcement::with('financialHighlight.fiscalYear', 'subType')
            ->where('type_id', '6')
            ->where('company_id', $company->id)
            ->orderBy('pub_date', 'desc')->get();

        return view('front/quote/view', compact('company', 'lastDate', 'competitor', 'newsList', 'annList', 'personalReview', 'reportLabel', 'report', 'financialHighlight', 'watchlist', 'rts', 'publishedReports'));
    }

    public function getBalanceSheet($id)
    {
        $balanceSheetAnnual = Cache::remember('getBalanceSheet_balanceSheetAnnual_' . $id, 1440, function () use ($id)
        {
            return BalanceSheet::leftJoin('financial_report', 'financial_report.id', '=', 'balance_sheet.financial_report_id')->leftJoin('report_label', 'balance_sheet.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('fylabel')->groupBy('fylabel')->take(4);
        });

        $balanceSheetQuarter = Cache::remember('getBalanceSheet_balanceSheetQuarter_' . $id, 1440, function () use ($id)
        {
            return BalanceSheet::leftJoin('financial_report', 'financial_report.id', '=', 'balance_sheet.financial_report_id')->leftJoin('report_label', 'balance_sheet.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', '<>', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('entry_date')->groupBy('entry_date')->take(4);
        });

        return [ 'annual' => $balanceSheetAnnual, 'quarter' => $balanceSheetQuarter ];
    }

    public function getConsolidateRevenue($id)
    {
        $consolidateRevenueAnnual = Cache::remember('getConsolidateRevenue_consolidateRevenueAnnual_' . $id, 1440, function () use ($id)
        {
            return ConsolidateRevenue::leftJoin('financial_report', 'financial_report.id', '=', 'consolidate_revenue.financial_report_id')->leftJoin('report_label', 'consolidate_revenue.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('fylabel')->groupBy('fylabel')->take(4);
        });

        $consolidateRevenueQuarter = Cache::remember('getConsolidateRevenue_consolidateRevenueQuarter_' . $id, 1440, function () use ($id)
        {
            return ConsolidateRevenue::leftJoin('financial_report', 'financial_report.id', '=', 'consolidate_revenue.financial_report_id')->leftJoin('report_label', 'consolidate_revenue.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', '<>', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('entry_date')->groupBy('entry_date')->take(4);
        });

        return [ 'annual' => $consolidateRevenueAnnual, 'quarter' => $consolidateRevenueQuarter ];
    }

    public function getIncomeStatement($id)
    {
        $incomeStatementAnnual = Cache::remember('getIncomeStatement_incomeStatementAnnual_' . $id, 1440, function () use ($id)
        {
            return IncomeStatement::leftJoin('financial_report', 'financial_report.id', '=', 'income_statement.financial_report_id')->leftJoin('report_label', 'income_statement.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('fylabel')->groupBy('fylabel')->take(4);
        });

        $incomeStatementQuarter = Cache::remember('getIncomeStatement_incomeStatementQuarter_' . $id, 1440, function () use ($id)
        {
            return IncomeStatement::leftJoin('financial_report', 'financial_report.id', '=', 'income_statement.financial_report_id')->leftJoin('report_label', 'income_statement.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', '<>', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('entry_date')->groupBy('entry_date')->take(4);
        });

        return [ 'annual' => $incomeStatementAnnual, 'quarter' => $incomeStatementQuarter ];
    }

    public function getProfitLoss($id)
    {
        $profitLossAnnual = Cache::remember('getProfitLoss_profitLossAnnual_' . $id, 1440, function () use ($id)
        {
            return ProfitLoss::leftJoin('financial_report', 'financial_report.id', '=', 'profit_loss.financial_report_id')->leftJoin('report_label', 'profit_loss.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('fylabel')->groupBy('fylabel')->take(4);
        });

        $profitLossQuarter = Cache::remember('getProfitLoss_profitLossQuarter_' . $id, 1440, function () use ($id)
        {
            return ProfitLoss::leftJoin('financial_report', 'financial_report.id', '=', 'profit_loss.financial_report_id')->leftJoin('report_label', 'profit_loss.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', '<>', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('entry_date')->groupBy('entry_date')->take(4);
        });

        return [ 'annual' => $profitLossAnnual, 'quarter' => $profitLossQuarter ];
    }

    public function getPrincipalIndicators($id)
    {
        $principalIndicatorsAnnual = Cache::remember('getPrincipalIndicators_principalIndicatorsAnnual_' . $id, 1440, function () use ($id)
        {
            return PrincipalIndicators::leftJoin('financial_report', 'financial_report.id', '=', 'principal_indicators.financial_report_id')->leftJoin('report_label', 'principal_indicators.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('fylabel')->groupBy('fylabel')->take(4);
        });

        $principalIndicatorsQuarter = Cache::remember('getPrincipalIndicators_principalIndicatorsQuarter_' . $id, 1440, function () use ($id)
        {
            return PrincipalIndicators::leftJoin('financial_report', 'financial_report.id', '=', 'principal_indicators.financial_report_id')->leftJoin('report_label', 'principal_indicators.label_id', '=', 'report_label.id')->leftJoin('fiscal_year', 'financial_report.fiscal_year_id', '=', 'fiscal_year.id')->leftJoin('quarter', 'financial_report.quarter_id', '=', 'quarter.id')->where('company_id', $id)->where('quarter.label', '<>', 'Annual')->select(DB::raw('*, fiscal_year.label as fylabel, quarter.label as qlabel, report_label.label as rlabel'))->get()->sortByDesc('entry_date')->groupBy('entry_date')->take(4);
        });

        return [ 'annual' => $principalIndicatorsAnnual, 'quarter' => $principalIndicatorsQuarter ];
    }

    public function getTechnicalAnalysis(Request $request, $quote = '')
    {
        if ($request->isMethod('post')):
            $quote = $request->get('quote');

            return redirect()->route('technical-analysis', $quote);
        endif;
        $company = Cache::rememberForever('getTechnicalAnalysis_company_' . $quote, function () use ($quote)
        {
            return Company::whereQuote($quote)->first();
        });

        $indexTypes = IndexType::all();

        return view('front/quote/analysis', compact('company', 'indexTypes'));
    }

    public function getTechnicalAnalysisOHLC(Request $request, $quote = '')
    {
        if ($request->isMethod('post')):
            $quote = $request->get('quote');

            return redirect()->route('technical-analysis.ohlc', $quote);
        endif;
        $company = Cache::rememberForever('getTechnicalAnalysis_company_' . $quote, function () use ($quote)
        {
            return Company::whereQuote($quote)->first();
        });

        $indexTypes = IndexType::all();
        $lastDate = TodaysPrice::getLastTradedDate();

        return view('front/quote/ohlc', compact('company', 'indexTypes', 'lastDate'));
    }

    public function getTechnicalAnalysisIndex(Request $request, $indexName = '')
    {
        if ($request->isMethod('post')):
            $index = $request->get('index');

            return redirect()->route('technical-analysis-index', IndexType::find($index)->name);
        endif;

        $index = Cache::rememberForever('getTechnicalAnalysis_index_' . $indexName, function () use ($indexName)
        {
            return IndexType::where('name', 'like', $indexName . '%')->first();
        });

        $indexTypes = IndexType::all();

        return view('front/index/analysis', compact('index', 'indexTypes'));
    }

    public function newsIndex()
    {
        $filterHasMany = $this->filterIfHasManyRelationIsEmpty;
        $categories    = $filterHasMany(NewsCategory::all(), 'recentNews', [ 5 ]);

        return view('front/news/index', compact('categories'));
    }

    public function newsCategory($type = null)
    {
        $allCategories = NewsCategory::all();
        $label         = str_replace('-', ' ', strtolower($type));

        $category     = NewsCategory::where('label', 'like', "%$label%")->first()->id;
        $categoryNews = Cache::remember('newsCategory_categoryNews_' . $category, 720, function () use ($category)
        {
            return News::with('category', 'user')->where('category_id', $category)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(15)->take(15)->get();
        });

        //Aside news item
        $newsList = [];
        foreach ($allCategories as $id => $cat)
        {
            $newsList[ $cat->id ] = News::getSortedNewsByCategory($cat->id);
        }

        return view('front/news/category', compact('newsList', 'allCategories', 'categoryNews', 'label'));
    }

    public function newsQuote($quote, Request $request)
    {
        $company       = Company::whereQuote($quote)->firstOrFail();
        $page          = $request->get('page', 1);
        $allCategories = NewsCategory::all();

        $companyNews = Cache::remember('newsCategory_categoryNews_' . $quote . '_page_' . $page, 720, function () use ($company, $request)
        {
            return News::with('category', 'user')->where('company_id', $company->id)->orderBy('pub_date', 'desc')->simplePaginate(15);
        });

        //Aside news item
        $newsList = [];
        foreach ($allCategories as $id => $cat)
        {
            $newsList[ $cat->id ] = News::getSortedNewsByCategory($cat->id);
        }

        return view('front/quote/news', compact('companyNews', 'company', 'allCategories', 'newsList'));
    }

    public function announcementQuote($quote, Request $request)
    {
        $company  = Company::whereQuote($quote)->firstOrFail();
        $page     = $request->get('page', 1);
        $allTypes = AnnouncementType::lists('label', 'id');

        $companyAnnouncements = Cache::remember('announcementQuote_' . $quote . '_page_' . $page, 720, function () use ($company, $request)
        {
            return Announcement::with('type', 'subtype', 'company', 'issue.fiscalYear', 'bondDebenture', 'treasuryBill')->where('company_id', $company->id)->orderBy('pub_date', 'desc')->simplePaginate(15);
        });

        //Aside news item
        $annList = [];
        foreach ($allTypes as $id => $type)
        {
            $annList[ $id ] = Announcement::getSortedAnnouncementByType($id);
        }

        return view('front/quote/announcements', compact('companyAnnouncements', 'company', 'allTypes', 'annList'));
    }

    public function newsShow($type, $slug)
    {
        $label = str_replace('-', ' ', strtolower($type));

        $category = Cache::rememberForever('newsShow_category_' . $label . $slug, function () use ($label, $slug)
        {
            return NewsCategory::with([
                'news' => function ($query) use ($slug)
                {
                    $query->with('imageNews', 'tags')->where('slug', $slug)->limit(1);
                }
            ])->where('label', $label)->first();
        });

        if (is_null($category) || is_null($category->news->first()))
        {
            abort('404');
        }


        $news = $category->news->first();

        //Aside news item
        $newsList = Cache::remember('newsShow_newsList_' . $news->id, 720, function () use ($news)
        {
            return News::with('category')->where('category_id', $news->category_id)->where('id', '!=', $news->id)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->take(12)->get();
        });

        return view('front/news/show', compact('news', 'newsList'));
    }

    public function newsTag($tag = '')
    {
        if ($tag == '')
        {
            return redirect()->route('index');
        }

        $tagNews = Tags::whereName($tag)->with('news')->first();

        //Aside news item
        $allCategories = NewsCategory::all();
        $newsList      = [];
        foreach ($allCategories as $id => $cat)
        {
            $newsList[ $cat->id ] = News::getSortedNewsByCategory($cat->id);
        }

        return view('front/news/tag', compact('tagNews', 'tag', 'allCategories', 'newsList'));
    }

    public function newsArchive()
    {
        $lastWeek = Carbon::now()->subWeek()->format('Y-m-d');
        $today    = Carbon::now()->format('Y-m-d');

        return view('front/news/archive', compact('lastWeek', 'today'));
    }

    public function getNewsByDate(Request $request)
    {
        $fromDate = $request->get('fromdate', date('Y-m-d'));
        $toDate   = $request->get('todate', date('Y-m-d'));
        if ($fromDate == $toDate):
            $news = Cache::remember('getNewsByDate_news_only' . $fromDate, 720, function () use ($fromDate)
            {
                return News::select(DB::raw('date_format(`pub_date`,"%Y-%m-%d") as date,title,pub_date,details,slug,category_id'))->with('category')->orderBy('pub_date', 'desc')->get()->where('date', $fromDate)->groupBy('date');
            });
        else:
            $news = Cache::remember('getNewsByDate_news_' . $fromDate . $toDate, 720, function () use ($fromDate, $toDate)
            {
                return News::select(DB::raw('date_format(`pub_date`,"%Y-%m-%d") as date,title,pub_date,details,slug,category_id'))->with('category')->whereBetween('pub_date', [
                        $fromDate,
                        $toDate
                    ])->orderBy('pub_date', 'desc')->get()->groupBy('date');
            });
        endif;

        return $news;
    }

    public function announcementIndex()
    {
        $lastWeek = Carbon::now()->subWeek()->format('Y-m-d');
        $today    = Carbon::now()->format('Y-m-d');

        return view('front/announcement/index', compact('lastWeek', 'today'));
    }

    public function getAnnouncementByDate(Request $request)
    {
        $fromDate = $request->get('fromdate', date('Y-m-d'));
        $toDate   = $request->get('todate', date('Y-m-d'));
        if ($fromDate == $toDate):
            $announcements = Cache::remember('getAnnouncementByDate_announcements_only' . $fromDate, 720, function () use ($fromDate)
            {
                return Announcement::select(DB::raw('date_format(`pub_date`,"%Y-%m-%d") as date,title,pub_date,details,slug,type_id'))->with('type')->orderBy('pub_date', 'desc')->get()->where('date', $fromDate)->groupBy('date');
            });
        else:
            $toDate        = date('Y-m-d H:i:s', strtotime($toDate . ' +1 day'));
            $announcements = Cache::remember('getAnnouncementByDate_announcements_' . $fromDate . $toDate, 720, function () use ($fromDate, $toDate)
            {
                return Announcement::select(DB::raw('date_format(`pub_date`,"%Y-%m-%d") as date,title,pub_date,details,slug,type_id'))->with('type')->where('pub_date', '>=', $fromDate)->where('pub_date', '<=', $toDate)->orderBy('pub_date', 'desc')->get()->groupBy('date');
            });
        endif;

        return $announcements;
    }

    public function announcementCategory(Request $request, $type)
    {
        $label    = strtolower(str_replace('-', ' ', $type));
        $page = $request->get('page');

        $type_id = Cache::rememberForever('announcementCategory_type_id_'.$label, function () use ($label) {
            return AnnouncementType::where('label', 'like', "%$label%")->firstOrFail()->id;
        });

        $subtype_id = $request->get('subtype');

        $allTypes = Cache::rememberForever('announcementCategory_alltypes', function () {
            return AnnouncementType::lists('label', 'id');
        });

        $allSubTypes = Cache::rememberForever('announcementCategories_allSubTypes_', function () {
            // announcement type =6=financial highlights
            $data = AnnouncementSubType::where('announcement_type_id', 6)->lists('label', 'id')->map(function($item){
                return ucwords($item);
            })->all();
            $data[''] = 'Select a type';
            return $data;
        });

        /*
        if ($label == "treasury bill"):
            $sub_type_id = Cache::rememberForever('announcementCategory_type_id_' . $label, function () use ($label)
            {
                return AnnouncementSubType::where('label', 'like', "%$label%")->first()->id;
            });
        elseif ($label == "bond debenture"):
            $sub_type_id = AnnouncementSubType::where('label', 'like', "%debenture%")->orWhere('label', 'like', '%bond%')->lists('id');
        else:
            $sub_type_id = Cache::rememberForever('announcementCategory_type_id_' . $label, function () use ($label)
            {
                return AnnouncementType::where('label', 'like', "%$label%")->first()->id;
            });
        endif;
        */

        if ($label == "bond debenture" || $label == "treasury bill"):
            $typeAnn = Cache::remember('announcementCategory_subtypeAnn_' . $type_id. $subtype_id . $page, 720, function () use ($type_id, $subtype_id, $request)
            {
                $data =  Announcement::with('type', 'subtype', 'company', 'issue.fiscalYear', 'bondDebenture', 'treasuryBill')
                    ->where('type_id', $type_id)
                    ->orderBy('pub_date', 'desc')
                    ->where('pub_date', '<', date('Y-m-d H:i:s'));

                if(!empty($subtype_id))
                    $data->where('subtype_id', $subtype_id);

                return $data->paginate(10);
            });
        else:
            $typeAnn = Cache::remember('announcementCategory_typeAnn_' . $type_id . $subtype_id . $page, 720, function () use ($type_id, $subtype_id, $request)
            {
                $data = Announcement::with('type', 'subtype', 'company', 'issue.fiscalYear', 'issue.auction', 'agm', 'bonusDividend', 'bondDebenture', 'treasuryBill', 'financialHighlight')
                    ->where('type_id', $type_id)
                    ->orderBy('pub_date', 'desc')
                    ->where('pub_date', '<', date('Y-m-d H:i:s'));
                    
                if(!empty($subtype_id))
                    $data->where('subtype_id', $subtype_id);

                return $data->paginate(10);
            });
        endif;

        //Aside news item
        $annList = [];
        foreach ($allTypes as $id => $type)
        {
            $annList[ $id ] = Announcement::getSortedAnnouncementByType($id);
        }

        $typeAnn = $typeAnn->appends($request->except('page'));

        return view('front/announcement/type', compact('typeAnn', 'allTypes', 'annList', 'label', 'allSubTypes'));
    }

    public function announcementShow($type, $slug)
    {
        $label = str_replace('-', ' ', strtolower($type));

        $type = Cache::rememberForever('announcementShow_type_' . $label . $slug, function () use ($label, $slug)
        {
            return AnnouncementType::with([
                'announcement' => function ($q) use ($slug)
                {
                    $q->with('issue.fiscalYear', 'issue.auction', 'agm', 'bonusDividend', 'bondDebenture', 'treasuryBill', 'financialHighlight.fiscalYear')->where('slug', $slug)->limit(1);
                }
            ])->where('label', $label)->first();
        });

        if (is_null($type) || is_null($type->announcement->first()))
        {
            abort('404');
        }

        $announcement = $type->announcement->first();

        //Aside news item
        $announcementList = Cache::remember('announcementShow_announcementList_' . $announcement->id, 1440, function () use ($announcement)
        {
            return Announcement::with('type')->where('type_id', $announcement->type_id)->where('id', '!=', $announcement->id)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->take(12)->get();
        });

        return view('front/announcement/show', compact('announcement', 'announcementList'));
    }

    public function interviewArticleIndex($type = null)
    {
        //Here type is whether interview or article
        $type = strtolower($type);
        if ($type == "interview"):
            $interviewList = Cache::remember('interviewArticleIndex_interviewList', 1440, function ()
            {
                return InterviewArticle::with('featuredImage', 'category')->where('type', 0)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(10)->get();
            });

            return view('front/interviewArticle/index', compact('interviewList', 'type'));

        elseif ($type == "article"):
            $articleList = Cache::remember('interviewArticleIndex_articleList', 1440, function ()
            {
                return InterviewArticle::with('featuredImage', 'category')->where('type', 1)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(10)->get();
            });

            return view('front/interviewArticle/index', compact('articleList', 'type'));
        endif;
    }

    public function interviewArticleShow($type, $slug)
    {
        //Here type refers to category of interview or article
        $label = str_replace('-', ' ', strtolower($type));

        $category = Cache::rememberForever('interviewArticleShow_category' . $label . $slug, function () use ($label, $slug)
        {
            return NewsCategory::with([
                'interviewArticle' => function ($query) use ($slug)
                {
                    $query->with('featuredImage')->where('slug', $slug)->limit(1);
                }
            ])->where('label', $label)->first();
        });

        if (is_null($category) || is_null($category->interviewArticle->first()))
        {
            abort('404');
        }

        $ia = $category->interviewArticle->first();

        $iaList = Cache::remember('interviewArticleShow_iaList_' . $ia->id, 1440, function () use ($ia)
        {
            return InterviewArticle::with('category', 'user')->where('category_id', $ia->category_id)->where('id', '!=', $ia->id)->orderBy('pub_date', 'desc')->where('pub_date', '<', date('Y-m-d H:i:s'))->limit(9)->take(9)->get();
        });

        return view('front/interviewArticle/show', compact('ia', 'iaList'));
    }

    public function getBullion($type = null)
    {
        $bullionID    = BullionType::where('name', 'like', "%$type%")->first()->id;
        $bullionTypes = BullionType::orderBy('id')->lists('name', 'id')->toArray();

        $newsList = Cache::remember('getBullion_newsList_' . $type, 720, function ()
        {
            $category = NewsCategory::where('label', 'like', '%bullion%')->first()->id;

            return News::with('category')->where('category_id', $category)->orderBy('pub_date', 'desc')->take(5)->get();
        });

        return view('front/bullion/index', compact('bullionTypes', 'bullionID', 'newsList'));
    }

    public function getEnergy($type = null)
    {
        $energyID    = EnergyType::where('name', 'like', "%$type%")->first()->id;
        $energyTypes = EnergyType::lists('name', 'id')->toArray();

        $newsList = Cache::remember('getEnergy_newsList_' . $type, 720, function ()
        {

            $category = NewsCategory::where('label', 'like', '%energy%')->first()->id;

            return News::with('category')->where('category_id', $category)->orderBy('pub_date', 'desc')->take(5)->get();
        });

        return view('front/energy/index', compact('energyTypes', 'energyID', 'newsList'));
    }

    public function getCurrency($type = null)
    {
        $currencyID    = CurrencyType::where('name', 'like', "%$type%")->first()->id;
        $currencyTypes = CurrencyType::lists('country_name', 'id')->toArray();

        $newsList = Cache::remember('getCurrency_newsList_' . $type, 720, function ()
        {
            $category = NewsCategory::where('label', 'like', '%currency%')->first()->id;

            return News::with('category')->where('category_id', $category)->orderBy('pub_date', 'desc')->take(5)->get();
        });

        return view('front/currency/index', compact('currencyTypes', 'currencyID', 'newsList'));
    }

    public function getPipeline()
    {
        $fiscalYear = Cache::rememberForever('getPipeline_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        return view('front/ipoPipeline/index', compact('fiscalYear'));
    }

    public function getIssueManager(Request $request)
    {
        if ($request->isMethod('post')):
            $issue_manager_id = $request->get('issue_manager_id', null);

            if (is_null($issue_manager_id))
            {
                return "Invalid issue manager id found.";
            }

            $companyList = Cache::rememberForever('getIssueManager_companyList_' . $issue_manager_id, function () use ($issue_manager_id)
            {
                return Company::whereHas('details', function ($q) use ($issue_manager_id)
                {
                    $q->where('issue_manager_id', $issue_manager_id);
                })->with([
                    'details' => function ($q2)
                    {
                        $q2->with('issueManager');
                    }
                ])->get();
            });

            return Datatables::of(collect($companyList))->make(true);
        endif;

        $issueManager = IssueManager::orderBy('company', 'asc')->lists('company', 'id');

        return view('front/issueManager/index', compact('issueManager'));
    }

    public function getPublishedReport(Request $request)
    {
        $fiscalYear = $request->get('fiscal_year_id', '');
        $subType = $request->get('sub_type_id', '');
        $company = $request->get('id', '');
        $publishedReports = Cache::rememberForever('getPublishedReport_publishedReports_'.$fiscalYear.$subType.$company, function () use ($fiscalYear, $subType, $company)
        {
            //where subtype = financial report = 6
            $data =  Announcement::with('type','financialHighlight.fiscalYear', 'subType')
                    ->where('type_id', '6')
                    ->where('company_id', $company);
                if(!empty($fiscalYear))
                    $data->whereHas('financialHighlight.fiscalYear' , function($q) use ($fiscalYear) {
                        $q->where('id', $fiscalYear);
                    });
                if(!empty($subType))
                    $data->whereHas('subType', function($q) use ($subType) {
                        $q->where('id', $subType);
                    });
                return $data->orderBy('pub_date', 'desc')->get();
        });

        return Datatables::of($publishedReports)
            ->addColumn('link', function($data){
                return route('front.announcement.show',[ $data->type->label, $data->slug]);
            })
            ->editColumn('pub_date', function($data){
                return str_limit($data->pub_date, 10,'');
            })->make(true);
    }

    public function getBrokerageFirm()
    {
        return view('front/brokerageFirm/index');
    }

    public function getBasePrice()
    {
        $fiscalYear = Cache::rememberForever('getBasePrice_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        return view('front/basePrice/index', compact('fiscalYear'));
    }

    public function getIpoResult()
    {
        $availableCompany = Cache::rememberForever('getIpoResult_availableCompany', function ()
        {
            return IPOResult::select('company_id')->groupBy('company_id')->get()->toArray();
        });

        $company = Cache::rememberForever('getIpoResult_company', function () use ($availableCompany)
        {
            return Company::orderBy('id', 'asc')->whereIn('id', $availableCompany)->get()->lists('name', 'id');
        });

        $latestResult = IPOResult::find(IPOResult::max('id'));

        return view('front/ipoResult/index', compact('company', 'latestResult'));
    }

    public function getIssue()
    {
        $subType = [ 'ipo', 'fpo', 'right', 'mutual fund' ];
        $today   = Carbon::now();

        $issues = Cache::remember('getIssue_issues_' . $today, 1440, function () use ($subType, $today)
        {
            return Announcement::leftJoin('announcement_type', 'announcement_type.id', '=', 'announcement.type_id')->leftJoin('announcement_subtype', 'announcement_subtype.id', '=', 'announcement.subtype_id')->leftJoin('company', 'company.id', '=', 'announcement.company_id')->leftJoin('issue', 'issue.announcement_id', '=', 'announcement.id')->leftJoin('im_issue', 'im_issue.issue_id', '=', 'issue.id')->leftJoin('issue_manager', 'issue_manager.id', '=', 'im_issue.im_id')->select('announcement.id', 'company.name', 'announcement_subtype.label as subLabel', 'kitta', 'issue_date', 'close_date', 'quote', 'issue_manager.company', 'announcement_type.label as label', 'announcement.slug')->where('announcement_type.label', 'issue open')->whereIn('announcement_subtype.label', $subType)->get()->groupBy('id');
        });

        return view('front/issue/index', compact('issues'));
    }

    public function getBudget()
    {
        $fiscalYear = Cache::rememberForever('getBudget_fiscalYear', function ()
        {
            return BudgetFiscalYear::has('budget')->orderBy('label', 'desc')->lists('label', 'id');
        });

        return view('front/budget/index', compact('fiscalYear'));
    }

    public function getEconomy()
    {

        $label         = EconomyLabel::all();
        $filtered      = $this->filterIfHasManyRelationIsEmpty;
        $filteredLabel = $filtered($label, 'getRecentEconomyValue');

        return view('front/economy/index', compact('filteredLabel'));
    }

    public function getBodApproved(Request $request)
    {
        if ($request->isMethod('post')):
            $fiscal_year_id = $request->get('fiscal_year_id', null);

            $sector_id = $request->get('sector_id');

            if (is_null($fiscal_year_id))
            {
                return "No fiscal year id found.";
            }

            $bodApproved = Cache::remember('getBodApproved_bodApproved_' . $fiscal_year_id . '_sector_' . $sector_id, 1440, function () use ($fiscal_year_id, $sector_id)
            {
                return BonusDividendDistribution::where('fiscal_year_id', $fiscal_year_id)->where('is_bod_approved', '1')->with('company', 'announcement')->whereHas('company', function ($company) use ($sector_id)
                    {
                        if ( ! empty( $sector_id ))
                        {
                            $company->where('sector_id', $sector_id);
                        }
                    })->get();
            });


            return Datatables::of(collect($bodApproved))->make(true);
        endif;

        $fiscalYear = Cache::rememberForever('getBodApproved_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        $fiscalYear = Cache::rememberForever('getBodApproved_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        $sectorList = Cache::rememberForever('getBodApproved_sectorList', function ()
        {
            $sectorList = Sector::lists('label', 'id');

            $sectorList->prepend('All')->sort();

            return $sectorList->toArray();
        });

        return view('front/bonusDividend/bodApproved', compact('fiscalYear', 'sectorList'));
    }

    public function getAGM(Request $request)
    {
        if ($request->isMethod('post')):
            $fiscal_year_id = $request->get('fiscal_year_id', null);
            $sector_id      = $request->get('sector_id', null);

            if (is_null($fiscal_year_id))
            {
                return "No fiscal year id found.";
            }

            $annualGeneralMeeting = Cache::remember('getAGM_annualGeneralMeeting_' . $fiscal_year_id . '_' . $sector_id, 1440, function () use ($fiscal_year_id, $sector_id)
            {
                return AgmFiscal::where('fiscal_year_id', $fiscal_year_id)->with([
                    'agm' => function ($q) use ($sector_id)
                    {
                        $q->with('company', 'announcement');
                    }
                ])->whereHas('agm.company', function ($company) use ($sector_id)
                {
                    if ( ! empty( $sector_id ))
                    {
                        $company->where('sector_id', $sector_id);
                    }
                })->get();
            });

            return Datatables::of(collect($annualGeneralMeeting))->make(true);
        endif;

        $fiscalYear = Cache::rememberForever('getAGM_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        $sectors = Sector::lists('label', 'id')->prepend('All', '')->all();

        return view('front/bonusDividend/agm', compact('fiscalYear', 'sectors'));
    }

    public function getCertificate(Request $request)
    {
        if ($request->isMethod('post')):
            $fiscal_year_id = $request->get('fiscal_year_id', null);

            if (is_null($fiscal_year_id))
            {
                return "No fiscal year id found.";
            }

            $certificate = Cache::remember('getCertificate_certificate_' . $fiscal_year_id, 1440, function () use ($fiscal_year_id)
            {
                return BonusDividendDistribution::where('fiscal_year_id', $fiscal_year_id)->where('is_bod_approved', '<>', '1')->with('company', 'announcement')->get();
            });

            return Datatables::of(collect($certificate))->make(true);
        endif;

        $fiscalYear = Cache::rememberForever('getCertificate_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        return view('front/bonusDividend/certificate', compact('fiscalYear'));
    }

    public function getTreasury(Request $request)
    {
        if ($request->isMethod('post')):
            $fiscal_year_id = $request->get('fiscal_year_id', null);

            if (is_null($fiscal_year_id))
            {
                return "No fiscal year id found.";
            }

            $treasuryBill = Cache::remember('getTreasury_treasuryBill_' . $fiscal_year_id, 1440, function () use ($fiscal_year_id)
            {
                return TreasuryBill::where('fiscal_year_id', $fiscal_year_id)->with('company', 'announcement')->get();
            });

            return Datatables::of(collect($treasuryBill))->make(true);
        endif;

        $fiscalYear = Cache::rememberForever('getTreasury_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        return view('front/treasuryBill/treasury', compact('fiscalYear'));
    }

    public function getBond(Request $request)
    {
        if ($request->isMethod('post')):
            $fiscal_year_id = $request->get('fiscal_year_id', null);

            if (is_null($fiscal_year_id))
            {
                return "No fiscal year id found.";
            }

            $bond = Cache::remember('getBond_bond_' . $fiscal_year_id, 1440, function () use ($fiscal_year_id)
            {
                return BondDebenture::where('fiscal_year_id', $fiscal_year_id)->with('company', 'announcement')->get();
            });

            return Datatables::of(collect($bond))->make(true);
        endif;

        $fiscalYear = Cache::rememberForever('getBond_fiscalYear', function ()
        {
            return FiscalYear::orderBy('id', 'desc')->lists('label', 'id')->toArray();
        });

        return view('front/bondDebenture/bond', compact('fiscalYear'));
    }

    public function siteMap()
    {
        return view('front/utilities/sitemap');
    }

    public function ourteam()
    {
        return view('front.ourteam.index');
    }

    public function getMarket(Request $request)
    {
        if ($request->isMethod('post')):

            if ($request->has('stockmarketdate')):
                $stockmarketdate = $request->get('stockmarketdate', Index::getLatestDate());

                $index = Cache::remember('getMarket_index' . $stockmarketdate, 720, function () use ($stockmarketdate)
                {
                    return IndexValue::leftJoin('index_type', 'index_value.type_id', '=', 'index_type.id')->leftJoin('index', 'index_value.index_id', '=', 'index.id')->where('date', $stockmarketdate)->orderBy('index_type.id', 'asc')->get();
                });

                $counter = 0;

                $data = [];
                foreach ($index as $in)
                {
                    $prev             = $in->previous() == null ? 0 : $in->previous()->value;
                    $data[ $counter ] = [
                        'id'       => $in->type_id,
                        'name'     => $in->type->name,
                        'value'    => $in->value,
                        'previous' => $prev,
                        'change'   => $in->change(),
                        'percent'  => $in->changePercent()
                    ];
                    $counter ++;
                }

                return Datatables::of(collect($data))->make(true);

            elseif ($request->has('bullionmarketdate')):
                $bullionmarketdate = $request->get('bullionmarketdate', Bullion::getLatestDate());

                $bullion = Cache::remember('getMarket_bullion' . $bullionmarketdate, 720, function () use ($bullionmarketdate)
                {
                    return BullionPrice::leftJoin('bullion_type', 'bullion_price.type_id', '=', 'bullion_type.id')->leftJoin('bullion', 'bullion_price.bullion_id', '=', 'bullion.id')->where('date', $bullionmarketdate)->orderBy('bullion_type.id', 'asc')->get();
                });

                $counter = 0;

                $data = [];
                foreach ($bullion as $bull)
                {
                    $prev             = $bull->previous() == null ? 0 : $bull->previous()->price;
                    $data[ $counter ] = [
                        'id'       => $bull->type_id,
                        'name'     => $bull->type->name,
                        'value'    => $bull->price,
                        'previous' => $prev,
                        'change'   => $bull->change(),
                        'percent'  => $bull->changePercent()
                    ];
                    $counter ++;
                }

                return Datatables::of(collect($data))->make(true);
            elseif ($request->has('currencymarketdate')):
                $currencymarketdate = $request->get('currencymarketdate', Currency::getLatestDate());

                $currency = Cache::remember('getMarket_currency' . $currencymarketdate, 720, function () use ($currencymarketdate)
                {
                    return CurrencyRate::leftJoin('currency_type', 'currency_rate.type_id', '=', 'currency_type.id')->leftJoin('currency', 'currency_rate.currency_id', '=', 'currency.id')->where('date', $currencymarketdate)->orderBy('currency_type.id', 'asc')->get();
                });

                $counter = 0;

                $data = [];
                foreach ($currency as $curr)
                {
                    $prevBuy          = $curr->previous() == null ? 0 : $curr->previous()->buy;
                    $prevSell         = $curr->previous() == null ? 0 : $curr->previous()->sell;
                    $data[ $counter ] = [
                        'id'           => $curr->type_id,
                        'name'         => $curr->type->name,
                        'buy'          => $curr->buy,
                        'previousBuy'  => $prevBuy,
                        'changeBuy'    => $curr->change(),
                        'sell'         => $curr->sell,
                        'previousSell' => $prevSell,
                        'changeSell'   => $curr->change('sell'),
                    ];
                    $counter ++;
                }

                return Datatables::of(collect($data))->make(true);
            elseif ($request->has('energymarketdate')):
                $energymarketdate = $request->get('energymarketdate', Currency::getLatestDate());

                $energy = Cache::remember('getMarket_energy' . $energymarketdate, 720, function () use ($energymarketdate)
                {
                    return EnergyPrice::leftJoin('energy_type', 'energy_price.type_id', '=', 'energy_type.id')->leftJoin('energy', 'energy_price.energy_id', '=', 'energy.id')->where('date', $energymarketdate)->orderBy('energy_type.id', 'asc')->get();
                });

                $counter = 0;

                $data = [];
                foreach ($energy as $ene)
                {
                    $prev             = $ene->previous() == null ? 0 : $ene->previous()->price;
                    $data[ $counter ] = [
                        'id'       => $ene->type_id,
                        'name'     => $ene->type->name,
                        'value'    => $ene->price,
                        'previous' => $prev,
                        'change'   => $ene->change(),
                        'percent'  => $ene->changePercent()
                    ];
                    $counter ++;
                }

                return Datatables::of(collect($data))->make(true);
            endif;
        endif;
        $latestDate = Cache::remember('getMarket_latestDate', 1440, function ()
        {
            return [
                'stock'    => Index::getLatestDate(),
                'bullion'  => Bullion::getLatestDate(),
                'currency' => Currency::getLatestDate(),
                'energy'   => Energy::getLatestDate()
            ];
        });

        return view('front/market/index', compact('latestDate'));
    }

    public function contact()
    {
        return view('front.utilities.contact');
    }

    public function contactSendMessage(ContactFormRequest $request)
    {
        Mail::raw('From: ' . $request->get('name') . "\nEmail: " . $request->get('email') . "\n" . $request->get('message'), function ($message) use ($request)
        {
            $message->from($request->get('email'), $request->get('email'));
            $message->to('investonepal@gmail.com')->subject($request->get('subject'));
        });

        return redirect()->route('front.contact')->with('success', 'Thanks for contacting us!');
    }

    public function about()
    {
        return view('front.utilities.about');
    }

    public function show403()
    {
        return view('errors.403');
    }
}