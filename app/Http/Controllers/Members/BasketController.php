<?php

namespace App\Http\Controllers\Members;

use App\Models\AssetsManagement\Basket;
use App\Models\AssetsManagement\StockType;
use App\Models\Company;
use App\Models\FiscalYear;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use yajra\Datatables\Datatables;

class BasketController extends Controller
{
    public function store(Requests\AMBasketFormRequest $request)
    {
        $response['error'] = FALSE;
        try{
            $basket = Basket::create(['name'=>$request->get('basket_name'),'user_id'=>Auth::id()]);
            if(!$basket):
                throw new \Exception('Basket could not be created.');
            endif;

            $response['data'] = $basket;
            $response['message'] = $request->get('basket_name').' basket has been created.';
        }catch (\Exception $e){
            $response['error'] = TRUE;
            $response['message'] = $e->getMessage();
        }

        if($request->isXmlHttpRequest()):
            return $response;
        elseif($response['error'] == true):
            return redirect()->route('member.stock.index')->with('warning','Basket could not be created.');
        else:
            return redirect()->route('member.stock.show',$basket->id)->with('success','Basket has been created.');
        endif;
    }

    public function update(Requests\AMBasketFormRequest $request, $id)
    {
        $error = true;
        $basket = Basket::where('id',$id)->where('user_id',Auth::id())->first();

        if(is_null($basket)):
            $message = 'Basket not found';
        else:
            $basket->name = $request->get('basket_name');
            if($basket->save()):
                $error = false;
                $message = 'Basket has been updated.';
            else:
                $message = 'Could not be updated.';
            endif;
        endif;

        if($request->isXmlHttpRequest()):
            return ['error' => $error, 'message'=> $message];
        else:
            $error ?  Session::put('warning',$message) : Session::put('success',$message);
            return redirect()->route('member.stock.index');
        endif;

    }

    public function fetch(Request $request)
    {
        $dt = Datatables::of(Basket::with('stockBuy.sell')->where('user_id',Auth::id()))->make(true);

        return $dt;
    }

    public function destroy(Request $request, $id)
    {
        $basket = Basket::where('user_id',Auth::id())->where('id',$id)->first();
        $error = true;
        if(is_null($basket)){
            $message = 'Basket not found.';
        }else{
            if($basket->delete()){
                $error = false;
                $message = 'Basket has been successfully deleted.';
            }else{
                $message = 'Basket could not be deleted.';
            }
        }

        if($request->isXmlHttpRequest()){
            return ['error'=>$error,'message'=>$message];
        }

        return redirect()->route('member.stock.index')->with($error ? 'warning' : 'success',$message);
    }
}
