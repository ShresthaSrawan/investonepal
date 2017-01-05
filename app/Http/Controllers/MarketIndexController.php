<?php

namespace App\Http\Controllers;

use App\NSM\IndexCrawler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Requests\MarketIndexFormRequest;

use Exception;
use DB;
use Auth;
use App\Models\Index;
use App\Models\IndexType;
use App\Models\IndexValue;

class MarketIndexController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','crawl')):
            $indexValue = Index::with('indexValue.type')->orderBy('date','desc')->limit(7)->get();
            return view('admin.marketIndex.index')
                ->with('indexValue', $indexValue);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','crawl')):
            $values = Index::with('indexValue.type')->orderBy('date','desc')
                ->limit(6)->get();
            $previousIndex = [];
            foreach($values as $date => $index):
                 $row = [];
                foreach($index->indexValue as $value):
                    $row[$value->type->name] = $value->value;
                endforeach;
                $previousIndex[Carbon::parse($index->date)->format('d M')] = $row;
            endforeach;

            $previousIndex = array_reverse($previousIndex);
            $indexType = IndexType::lists('name','id')->toArray();

            return view('admin.marketIndex.create',compact('previousIndex','indexType'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function crawl()
    {
        try{
            $result['data'] = (new IndexCrawler())->fetch();
            $result['error'] = false;
        }catch (\Exception $e){
            $result['error'] = true;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    public function store(MarketIndexFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $date = $request->get('date');
            $value = $request->get('value');

            if(IndexType::whereIn('id',array_keys($value))->count() != IndexType::count()):
                return redirect()->route('admin.marketIndex.create')
                                ->withInput()
                                ->with('danger', 'Invalid request.');
            endif;

            DB::beginTransaction();
            try{
                $index = Index::create(['date'=>$date]);

                foreach ($value as $id => $val) {
                    $data = ['index_id'=>$index->id,'type_id'=>$id, 'value'=>$val];
                    IndexValue::create($data);
                }
            }
            catch (\Exception $e) {
                DB::rollback();
                throw $e;
                return false;
            }
            DB::commit();

            return redirect()->route('admin.marketIndex.create')
                ->with('success', 'Market index created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $index = Index::with('indexValue.type')->find($id);
            if(is_null($index)):
                return redirect()->route('admin.marketIndex.index')
                                ->with('danger','Invalid request.');
            endif;

            $current = [];
            foreach ($index->indexValue as $v) {
                $current[$v->type->name] = $v->value;
            }        

            $values = Index::with('indexValue.type')->orderBy('date','desc')
                    ->where('id','<>',$id)
                    ->limit(6)->get();

            $previousIndex = [];
            foreach($values as $date => $index):
                 $row = [];
                foreach($index->indexValue as $value):
                    $row[$value->type->name] = $value->value;
                endforeach;
                $previousIndex[Carbon::parse($index->date)->format('d M')] = $row;
            endforeach;

            $previousIndex = array_reverse($previousIndex);
            $indexType = IndexType::lists('name','id')->toArray();

            return view('admin.marketIndex.edit',compact('previousIndex','indexType','current','id'));
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(MarketIndexFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $index = Index::with('indexValue')->find($id);
            $value = $request->get('value');

            if(is_null($index)):
                return redirect()->route('admin.indexValue.index')
                                ->with('danger','Invalid request.');
            endif;

            DB::beginTransaction();
            try{
                foreach ($index->indexValue as  $indexValue):
                    if(array_key_exists($indexValue->type_id, $value)):
                        $indexValue->value = $value[$indexValue->type_id];
                        $indexValue->save();
                    endif;
                endforeach;
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.energyPrice.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.marketIndex.index')
                ->with('success','Market Index has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $index = Index::where('id',$id);

            if(is_null($index)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            $index->delete();

            return redirect()->back()
                ->with('success','Selected market index has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
