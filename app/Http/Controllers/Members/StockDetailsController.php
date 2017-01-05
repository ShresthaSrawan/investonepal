<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AMStockDetailsFormRequest;
use App\Models\AssetsManagement\StockDetails;
use App\Http\Controllers\Controller;

class StockDetailsController extends Controller
{
    
    public function fetch(Request $request)
    {
        return \DB::table('am_stock_basket as basket')
        ->join('am_stocks_buy as buy','basket.id','=','buy.basket_id')
        ->join('am_stock_details as details','buy.id','=','details.buy_id')
        ->where('basket.id',$request->get('basket'))
        ->where('basket.user_id',\Auth::id())
        ->select('details.id','details.fiscal_year_id as fiscal_year',
            'details.stock_dividend','details.cash_dividend','details.right_share',
            'details.remarks')->get();

    }

    public function store(AMStockDetailsFormRequest $request)
    {
        $error = false;
        $sd = new StockDetails();
        $sd->buy_id = $request->get('stock_id');
        $sd->fiscal_year_id = $request->get('fiscal_year');
        $sd->stock_dividend = $request->get('stock_dividend');
        $sd->cash_dividend = $request->get('cash_dividend');
        $sd->right_share = $request->get('right_share');
        $sd->remarks = $request->get('remarks');

        if(!$sd->save()){
            $error = true;
            $message = 'Sorry, Stock Details could not be created at the moment.';
        }else{
            $message = 'Success, Stock details has been created';
        }

        if($request->ajax()){
            return ['error'=>$error,'message'=>$message];
        }else{
            if($error){
                \Session::put('success',$message);
            }else{
                \Session::put('warning',$message);
            }
            return redirect()->route('member.stock.index');
        }
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
