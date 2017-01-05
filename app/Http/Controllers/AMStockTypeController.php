<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\StockType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AMStockTypeController extends Controller
{

    public function index()
    {
        $stockTypes = $this->transformCollection(StockType::select(['id','name'])->get());
        return view('admin.AssetManagement.StockType.index',compact('stockTypes'));
    }

    public function store(Requests\StockTypeFormRequest $request)
    {

        $data = $request->only('name');
        try{
            $st = StockType::create($data);
            return response()->json([
                'data' => $this->transform($st),
                'message' => 'Stock Type created successfully.'
                ],201);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error'
            ],500);
        }
    }

    public function update(Requests\StockTypeFormRequest $request, $id)
    {
        try {
            $st = StockType::findOrFail($id);
        }catch(\Exception $e) {
            return response()->json([
                'message' => 'Stock Type could not be found'
            ],404);
        }

        try{
            $st->update($request->only('name'));
            return response()->json([
                'data' => $this->transform($st),
                'message' => 'Stock Type has been updated successfully.'
            ],200);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'Could not update stock type.'
            ],503);
        }
    }

    public function destroy($id)
    {
        try {
            $st = StockType::findOrFail($id);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Stock Type could not be found.'
            ],404);
        }

        try{
            $st->delete();
            return response()->json([
                'message' => 'Stock Type has been deleted successfully.'
            ],200);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'Could not delete stock type.'
            ],503);
        }
    }

    private function transformCollection($types)
    {
        $types = is_array($types) ? $types : $types->toArray();

        return collect(array_map([$this,'transform'],$types));
    }

    private function transform($type)
    {
        $type = is_array($type) ? $type : $type->toArray();

        return [
            'id' => $type['id'],
            'name' => $type['name'],
            'action' => route('admin.stock-type.update',$type['id'])
        ];
    }
}
