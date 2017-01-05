<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\EnergyPriceFormRequest;
use Exception;
use DB;
use Carbon\Carbon;
use App\Models\Energy;
use App\Models\EnergyType;
use App\Models\EnergyPrice;

class EnergyPriceController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $energyPrice = Energy::with('energyPrice.type')->orderBy('date','desc')->get();
            return view('admin.energyPrice.index')
                ->with('energyPrices', $energyPrice);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $values = Energy::with('energyPrice.type')->orderBy('date','desc')
                ->limit(6)->get();

            $previousEnergy = [];
            foreach($values as $date => $energy):
                 $row = [];
                foreach($energy->energyPrice as $value):
                    $row[$value->type->name] = $value->price;
                endforeach;
                $previousEnergy[Carbon::parse($energy->date)->format('d M')] = $row;
            endforeach;

            $previousEnergy = array_reverse($previousEnergy);
            $energyType = EnergyType::lists('name','id')->toArray();

            return view('admin.energyPrice.create',compact('previousEnergy','energyType'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(EnergyPriceFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $date = $request->get('date');
            $prices = $request->get('price');

            if(EnergyType::whereIn('id',array_keys($prices))->count() != EnergyType::count()):
                return redirect()->route('admin.energyPrice.create')
                                ->withInput()
                                ->with('danger','Invalid request.');
            endif;

            DB::beginTransaction();
                try{
                    $energy = Energy::create(['date'=>$date]);

                    foreach ($prices as $id => $price):
                        $data = ['energy_id'=>$energy->id,'type_id'=>$id, 'price'=>$price];
                        EnergyPrice::create($data);
                    endforeach;
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.energyPrice.create')->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.energyPrice.create')
                ->with('success', 'New energy price created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $energy = Energy::with('energyPrice.type')->find($id);

            if(is_null($energy)):
                return redirect()->route('admin.energyPrice.index')
                                ->with('danger','Invalid request.');
            endif;

            $current = [];
            foreach ($energy->energyPrice as $v) {
                $current[$v->type->name] = $v->price;
            }

            $values = Energy::with('energyPrice.type')->orderBy('date','desc')
                    ->where('id','<>',$id)
                    ->limit(6)->get();

            $previousEnergy = [];
            foreach($values as $date => $energy):
                 $row = [];
                foreach($energy->energyPrice as $value):
                    $row[$value->type->name] = $value->price;
                endforeach;
                $previousEnergy[Carbon::parse($energy->date)->format('d M')] = $row;
            endforeach;

            $previousEnergy = array_reverse($previousEnergy);
            $energyType = EnergyType::lists('name','id')->toArray();

            return view('admin.energyPrice.edit',compact('previousEnergy','energyType','current','id'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(EnergyPriceFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $energy = Energy::with('energyPrice')->find($id);
            $price = $request->get('price');

            if(is_null($energy)):
                return redirect()->route('admin.energyPrice.index')
                                ->with('danger','Invalid request.');
            endif;

            DB::beginTransaction();
                try{
                    foreach ($energy->energyPrice as  $energyPrice):
                        if(array_key_exists($energyPrice->type_id, $price)):
                            $energyPrice->price = $price[$energyPrice->type_id];
                            $energyPrice->save();
                        endif;
                    endforeach;
                }
                catch (Exception $e){
                    DB::rollback();
                    return redirect()->route('admin.energyPrice.edit',$id)->with('danger', $e->getMessage());
                }
            DB::commit();

            return redirect()->route('admin.energyPrice.index')
                ->with('success','Energy price has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $energy = Energy::find($id);

            if(is_null($energy)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $energy->delete();

            return redirect()->back()
            ->with('success','Selected energy price have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
