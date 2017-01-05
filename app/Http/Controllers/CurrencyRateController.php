<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Http\Requests;
use App\Http\Requests\CurrencyRateFormRequest;
use Carbon\Carbon;
use App\File;
use Exception;
use DB;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\CurrencyType;

class CurrencyRateController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $currencyRates = Currency::with('currencyRate.type')->orderBy('date','desc')->limit(50)->get();
            return view('admin.currencyRate.index')
                ->with('currencyRates', $currencyRates);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $values = Currency::with('currencyRate.type')->orderBy('date','desc')
                ->limit(6)->get();

            $previousCurrency = [];
            foreach($values as $date => $currency):
                 $row = [];
                foreach($currency->currencyRate as $value):
                    $row[$value->type->name] = ['buy'=>$value->buy,'sell'=>$value->sell];
                endforeach;
                $previousCurrency[Carbon::parse($currency->date)->format('d M')] = $row;
            endforeach;

            $previousCurrency = array_reverse($previousCurrency);
            $currencyType = CurrencyType::lists('name','id')->toArray();

            return view('admin.currencyRate.create',compact('previousCurrency','currencyType'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(CurrencyRateFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $date = $request->get('date');
            $buy = $request->get('buy');
            $sell = $request->get('sell');

            if(CurrencyType::whereIn('id',array_keys($buy))->count() != CurrencyType::count()):
                return redirect()->route('admin.currencyRate.create')
                                ->withInput()
                                ->with('danger', 'Invalid request.');
            endif;

            DB::beginTransaction();
                try{
                    $currency = Currency::create(['date'=>$date]);

                    foreach ($buy as $id => $buyval) {
                        $data = ['currency_id'=>$currency->id,'type_id'=>$id, 'buy'=>$buy[$id],'sell'=>$sell[$id]!=""?$sell[$id]:null];
                        CurrencyRate::create($data);
                    }
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.currencyRate.create')->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.currencyRate.create')
                ->with('success', 'Currency Rate has been created successfully for '.$request->get('date').'.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $currency = Currency::with('currencyRate.type')->find($id);

            if(is_null($currency)):
                return redirect()->route('admin.currencyRate.index')
                                ->with('danger','Invalid request.');
            endif;

            $current = [];
            foreach ($currency->currencyRate as $v) {
                $current[$v->type->name] = ['buy'=>$v->buy,'sell'=>$v->sell];
            }

            $values = Currency::with('currencyRate.type')->orderBy('date','desc')
                    ->where('id','<>',$id)
                    ->limit(6)->get();

            $previousCurrency = [];
            foreach($values as $date => $currency):
                 $row = [];
                foreach($currency->currencyRate as $value):
                    $row[$value->type->name] = ['buy'=>$value->buy,'sell'=>$value->sell];
                endforeach;
                $previousCurrency[Carbon::parse($currency->date)->format('d M')] = $row;
            endforeach;

            $previousCurrency = array_reverse($previousCurrency);
            $currencyType = CurrencyType::lists('name','id')->toArray();

            return view('admin.currencyRate.edit',compact('previousCurrency','currencyType','current','id'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(CurrencyRateFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            DB::beginTransaction();
                try{
                    $currency = Currency::with('currencyRate')->find($id);
                    $buy = $request->get('buy');
                    $sell = $request->get('sell');

                    if(is_null($currency)):
                        return redirect()->route('admin.currencyRate.index')
                                        ->with('danger','Invalid request.');
                    endif;

                    foreach ($currency->currencyRate as  $currencyRate):
                        if(array_key_exists($currencyRate->type_id, $buy)):
                            $currencyRate->buy = $buy[$currencyRate->type_id];
                            $currencyRate->save();
                        endif;
                        if(array_key_exists($currencyRate->type_id, $sell)):
                            $currencyRate->sell = $sell[$currencyRate->type_id] != "" ? $sell[$currencyRate->type_id] : null;
                            $currencyRate->save();
                        endif;
                    endforeach;
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.currencyRate.edit',$id)->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.currencyRate.index')
                ->with('success','Currency rate has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $currency = Currency::where('id',$id);

            if(is_null($currency)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $currency->delete();

            return redirect()->back()
                ->with('success','Selected currency rate has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function upload(Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $file = $request->file('file');

            File::upload($file,Currency::FILE_LOCATION,Currency::FILE_NAME);

            $currencyRate = new Currency();
            if($currencyRate->setCurrencyFromExcel()):
                return redirect()->route('admin.currencyRate.index')
                    ->with('success','Currency Rate XLS has been uploaded successfully.');
            else:
                return redirect()->route('admin.currencyRate.index')
                    ->with('warning','Something went worng. Please check the file type and XLS headers before re-uploading');
            endif;
        else:
            return redirect()->route('403');
        endif;
    }
}
