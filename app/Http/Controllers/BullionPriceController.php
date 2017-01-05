<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\BullionPriceFormRequest;
use Exception;
use DB;
use Auth;
use App\Models\Bullion;
use App\Models\BullionType;
use App\Models\BullionPrice;

class BullionPriceController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $bullionPrices = Bullion::with('bullionPrice.type')->orderBy('date','desc')->get();
            return view('admin.bullionPrice.index')
                ->with('bullionPrices', $bullionPrices);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $values = Bullion::with('bullionPrice.type')->orderBy('date','desc')
                ->limit(6)->get();

            $previousBullion = [];
            foreach($values as $date => $bullion):
                 $row = [];
                foreach($bullion->bullionPrice as $value):
                    $row[$value->type->name] = $value->price;
                endforeach;
                $previousBullion[Carbon::parse($bullion->date)->format('d M')] = $row;
            endforeach;

            $previousBullion = array_reverse($previousBullion);
            $bullionType = BullionType::orderBy('id')->lists('name','id')->toArray();

            return view('admin.bullionPrice.create',compact('previousBullion','bullionType'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(BullionPriceFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $date = $request->get('date');
            $price = $request->get('price');

            if(BullionType::whereIn('id',array_keys($price))->count() != BullionType::count()):
                return redirect()->route('admin.bullionPrice.create')
                                ->withInput()
                                ->with('danger', 'Invalid request.');
            endif;

            DB::beginTransaction();
                try{
                    $bullion = Bullion::create(['date'=>$date]);

                    foreach ($price as $id => $price):
                        $data = ['bullion_id'=>$bullion->id,'type_id'=>$id, 'price'=>$price];
                        BullionPrice::create($data);
                    endforeach;
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.bullionPrice.create')->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.bullionPrice.create')
                ->with('success', 'New bullion price created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $bullion = Bullion::with('bullionPrice.type')->find($id);

            if(is_null($bullion)):
                return redirect()->route('admin.bullionPrice.index')
                                ->with('danger','Invalid request.');
            endif;

            $current = [];
            foreach ($bullion->bullionPrice as $v) {
                $current[$v->type->name] = $v->price;
            }

            $values = Bullion::with('bullionPrice.type')->orderBy('date','desc')
                    ->where('id','<>',$id)
                    ->limit(6)->get();

            $previousBullion = [];
            foreach($values as $date => $bullion):
                 $row = [];
                foreach($bullion->bullionPrice as $value):
                    $row[$value->type->name] = $value->price;
                endforeach;
                $previousBullion[Carbon::parse($bullion->date)->format('d M')] = $row;
            endforeach;

            $previousBullion = array_reverse($previousBullion);
            $bullionType = BullionType::lists('name','id')->toArray();

            return view('admin.bullionPrice.edit',compact('previousBullion','bullionType','current','id'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, BullionPriceFormRequest $request)
    {   
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $bullion = Bullion::with('bullionPrice')->find($id);
            $price = $request->get('price');

            if(is_null($bullion)):
                return redirect()->route('admin.bullionPrice.index')
                                ->with('danger','Invalid request.');
            endif;

            DB::beginTransaction();
                try{
                    foreach ($bullion->bullionPrice as  $bullionPrice):
                        if(array_key_exists($bullionPrice->type_id, $price)):
                            $bullionPrice->price = $price[$bullionPrice->type_id];
                            $bullionPrice->save();
                        endif;
                    endforeach;
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.bullionPrice.edit',$id)->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.bullionPrice.index')
                ->with('success','Bullion price has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $bullion = Bullion::find($id);

            if(is_null($bullion)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $bullion->delete();

            return redirect()->route('admin.bullionPrice.index')
            ->with('success','Selected bullion price has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
