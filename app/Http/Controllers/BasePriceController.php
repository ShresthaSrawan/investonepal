<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\BasePriceFormRequest;
use App\Http\Requests\BasePriceUploadRequest;

use App\Models\Company;
use App\Models\BasePrice;
use App\Models\FiscalYear;
use App\Models\BasePriceDump;

class BasePriceController extends Controller
{
    public function index($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $company = Company::with('basePrice')->where('company.id','=',$id)->first();
            $fiscal_year = FiscalYear::lists('label', 'id');
            return view('admin.basePrice.all')
                ->with('fiscalYear', $fiscal_year)
                ->with('company', $company);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(BasePriceFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):

            $input = $request->all();
            
            $bp = BasePrice::where('company_id',$id)
                ->where('date',$request->get('date'))
                ->first();
            if(!is_null($bp)){
                return redirect()->back()->with('warning','Multiple base price can not exits on same date.')->withInput();
            }
            $basePrice = new BasePrice();
            $basePrice->company_id = $id;
            $basePrice->price = $input['price'];
            $basePrice->fiscal_year_id = $input['fiscalYear_id'];
            $basePrice->date = $input['date'];
            $basePrice->save();

            return redirect()->back()
                ->with('success', 'Base price has been successfully created.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(BasePriceFormRequest $request,$cid,$bid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $request->all();

            $basePrice = BasePrice::find($bid);
            $basePrice->company_id = $cid;
            $basePrice->price = $input['price'];
            $basePrice->save();

            return redirect()->back()
                ->with('success', 'Base price has been successfully updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($cid,$bid)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $basePrice = BasePrice::where('company_id',$cid)
                                    ->where('id',$bid)
                                    ->first();

            if(is_null($basePrice)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $basePrice->delete();

            return redirect()->back()
                ->with('success',"Base price has been successfully deleted.");
        else:
            return redirect()->route('403');
        endif;
    }

    public function form()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            return view('admin.basePrice.upload');
        else:
            return redirect()->route('403');
        endif;
    }


    public function upload(BasePriceUploadRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $file = $request->file('file');
            File::upload($file,BasePrice::FILE_LOCATION,BasePrice::FILE_NAME);

            $basePrice = new BasePriceDump();
            $basePrice->setBasePriceFromExcel();
            return redirect()->route('admin.basePrice.show')
                ->with('success','File uploaded successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show(Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $allBasePrice = BasePrice::all();
            $basePrice = new BasePriceDump();
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();
            $summary = array(
                'unknownCompanies'=>$basePrice->unknownCompanies(),
                'nofPrice'=>$basePrice->countPrice()
                );
            return view('admin.basePrice.show',compact('summary','fiscalYear','allBasePrice'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function save(Request $request)
    {
        $date = $request->get('date');
        $fiscalYear = $request->get('fiscalYear');

        $bpd = new BasePriceDump();
        if($bpd->addtodb($date,$fiscalYear))
            return 1;
        else
            return 0;
    }
}
