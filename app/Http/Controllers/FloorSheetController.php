<?php

namespace App\Http\Controllers;

use Auth;
use Artisan;
use DB;
use App\File;
use App\Http\Requests\FloorSheetUploadRequest;
use App\Models\FloorSheet;
use App\Models\Company;
use App\Models\TodaysFloorSheet;
use App\Models\TodaysPrice;
use App\Models\NewHighLow;
use App\Models\LastTradedPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;

class FloorSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($year="",$month="",$day="")
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','crawl')):
            $year = intval($year);
            $month = intval($month);
            $day = intval($day);
            if($year=="" || $month=="" || $day=="")
            {
                $date = Carbon::parse(TodaysPrice::getLastTradedDate())->format('Y/m/d');
                return redirect()->route('admin.floorsheet',$date);
            }
            else
            {
                $date = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
                if($date=='1970-01-01'){
                    $date = Carbon::parse(TodaysPrice::getLastTradedDate())->format('Y/m/d');
                    return redirect()->route('admin.floorsheet',$date);
                }
            }

            $floorsheetData = FloorSheet::where('date','=',$date)->get();

            $transposedFloorSheetData = array();

            foreach($floorsheetData->toArray() as $row_key => $column_array)
            {
                foreach($column_array as $column_key => $value)
                {
                    $transposedFloorSheetData[$column_key][$row_key] = $value;
                }
            }

            $companys = Company::lists('quote','id');
            return view('admin.floorsheet.view')
                ->with('floorsheetData',$floorsheetData)
                ->with('companys',$companys)
                ->with('transposedFloorsheetData',$transposedFloorSheetData)
				->with('date',$date);
        else:
            return redirect()->route('403');
        endif;
    }

    public function show()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','crawl')):
            return view('admin.floorsheet.add');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getHeaders()
    {
        $crawler = new FloorSheetCrawler();
        $crawler->fetch('get',1);
        $headers = $crawler->getHeaders();
        return $headers;
    }

    public function fetch($limit = 50000)
    {
        $crawler = new FloorSheetCrawler();
        $crawler->setSnIndex($this->request->has('sn') ? $this->request->get('sn') : 0);
        $crawler->setContractNoIndex($this->request->has('transaction_no')?$this->request->get('transaction_no'):1);
        $crawler->setStockSymbolIndex($this->request->has('stock_symbol')?$this->request->get('stock_symbol'):2);
        $crawler->setBuyerBrokerIndex($this->request->has('buyer_broker')?$this->request->get('buyer_broker'):3);
        $crawler->setSellerBrokerIndex($this->request->has('seller_broker')?$this->request->get('seller_broker'):4);
        $crawler->setQuantityIndex($this->request->has('quantity')?$this->request->get('quantity'):5);
        $crawler->setRateIndex($this->request->has('rate')?$this->request->get('rate'):6);
        $crawler->setAmountIndex($this->request->has('amount')?$this->request->get('amount'):7);
        $crawler->fetch($limit);
        if($crawler->floorsheetDump())
        {
            $tfs = new TodaysFloorSheet();
            $unknownCompanies = $tfs->unknownCompanies();
            if(count($unknownCompanies)==0){
                $summary = array(
                    'nofTransactions' => $tfs->nofTransaction(),
                    'nofCompanies'=> $tfs->nofCompany(),
                    'totalQuantity'=> $tfs->totalQuantity(),
                    'totalAmount'=> $tfs->totalAmount()
                );
                return ['summary'=>$summary,'unknown'=>null];
            } else {
                return ['unknown'=>$unknownCompanies,'summary'=>null];
            }
        } else {
            return 0;
        }
    }

    public function excel()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','crawl')):
            $tfs = new TodaysFloorSheet();
            $summary = array(
                'unknownCompanies' => $tfs->unknownCompanies(),
                'nofCompanies' => $tfs->nofCompany(),
                'nofTransactions' => $tfs->nofTransaction(),
                'totalAmount' => $tfs->totalAmount(),
                'totalQuantity' => $tfs->totalQuantity(),
                'date' => $tfs->getDate()
            );
            return view('admin.floorsheet.addexcel',compact('summary'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function crawl()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','crawl')):
            $crawler = new FloorSheetCrawler();
            $crawler->fetch(1);
            $headers = $crawler->getHeaders();
            $date = Carbon::parse($crawler->getDate())->format('Y-m-d');
            return view('admin.floorsheet.addcrawl',compact('headers','date'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function crawlSummary()
    {
        $crawler = new FloorSheetCrawler();
        $crawler->fetch(50000);
        $crawler->floorsheetDump();
        $tf = new TodaysFloorSheet();
        return ['nofTransactions'=> $tf->nofCompany(),'nofCompanies'=>$tf->nofCompany(),'totalAmount'=>$tf->totalAmount(),'totalQuantity'=>$tf->totalQuantity()];
    }

    public function save()
    {
        $date = $this->request->get('date')?Carbon::parse($this->request->get('date'))->format('Y-m-d'):date('Y-m-d');
        $tfs = new TodaysFloorSheet();
        if($tfs->updateAll($date))
            return 1;
        return 0;
    }

    public function upload(FloorSheetUploadRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','crawl')):
            $file = $request->file('file');
            File::upload($file,FloorSheet::FILE_LOCATION,FloorSheet::FILE_NAME);

            $tfs = new TodaysFloorSheet();
            $tfs->setFloorsheetFromExcel();

            return redirect()->route('admin.addFloorsheetExcel')->with('message','File uploaded successfully and stored temporarily.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getSample()
    {
        $data = array(
            array('ID'=>1, 'transaction_no'=>'201507022606275','stock_symbol'=>'PLIC','buyer_broker'=>1,'seller_broker'=>26,'quantity'=>100,'rate'=>1160,'amount'=>116000),
            array('ID'=>2, 'transaction_no'=>'201507022606276','stock_symbol'=>'KAFIL','buyer_broker'=>19,'seller_broker'=>47,'quantity'=>466,'rate'=>233,'amount'=>108578)
        );
        $excel = Excel::create('floorsheet',function($excel) use ($data){
            $excel->sheet('sheet1',function($sheet) use ($data){
                $sheet->fromArray($data);
                $sheet->freezeFirstRow();
            });
        })->export('xls');
    }
	
	public function delete($date)
	{
		if(strtotime($date) == false)
			return "invalid date";
		DB::beginTransaction();

		FloorSheet::where('date',$date)->delete();
		TodaysPrice::where('date',$date)->delete();
		
		foreach(LastTradedPrice::where('date',$date)->get() as $lastPrice)
		{
			$lastPrice->date = TodaysPrice::where('company_id',$lastPrice->company_id)->orderBy('date','desc')->take(1)->first()->date;
			$lastPrice->save();
		};
		foreach(NewHighLow::where('high_date',$date)->get() as $high)
		{
			$newHigh = TodaysPrice::where('company_id',$high->company_id)->orderBy('close','desc')->take(1)->first();
			$high->high = $newHigh->close;
			$high->high_date = $newHigh->date;
			$high->save();
		}
		foreach(NewHighLow::where('low_date',$date)->get() as $low)
		{
			$newLow = TodaysPrice::where('company_id',$low->company_id)->orderBy('close','asc')->take(1)->first();
			$low->low = $newLow->close;
			$low->low_date = $newLow->date;
			$low->save();
		}
		DB::commit();
		Artisan::call('cache:clear');
		return redirect()->route('admin.floorsheet')->with('success','Floorsheet deleted and synced.');
	}
}
