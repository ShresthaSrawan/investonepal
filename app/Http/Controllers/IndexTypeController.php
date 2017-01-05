<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Requests\IndexTypeFormRequest;
use App\Http\Controllers\Controller;
use App\Models\IndexType;
use Illuminate\Support\Facades\Redirect;

class IndexTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**Start: Index Type CRUD */
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','crawl')):
            $indexType = IndexType::all();

            return view('admin.indexType.all')
                ->with('indexTypes', $indexType);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(IndexTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','crawl')):
            $input = $request->all();
        
            $indexType = new IndexType();
            $indexType->name = $input['label'];
            $indexType->save();

            return Redirect::back()
                ->with('success', 'A new index type has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(IndexTypeFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','crawl')):
            $input = $request->all();
            $type = IndexType::find($id);
            $type->name = $input['name'];
            $type->save();

            return Redirect::back()
                ->with('success','Index type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','crawl')):
            $indexType = IndexType::find($id);

            if(is_null($indexType)){
                return redirect()->back()->with('danger','Invalid Request');
            }
            $indexType->delete();

            return Redirect::back()
                ->with('success','Selected index type has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
