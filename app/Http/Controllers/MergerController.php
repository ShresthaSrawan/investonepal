<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Models\Merger;
use App\Models\Company;
use App\Http\Requests\StoreMerger;
use App\Http\Requests\UpdateMerger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MergerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mergers = Merger::all();

        return view('admin.merger.index', compact('mergers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $companies = Company::lists('name', 'id')->toArray();

            return view('admin.merger.create', compact('companies'));
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMerger $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):

            $merger = Merger::create($request->data());

            return redirect()->route('admin.merger.index')
            ->with('success', 'Merger has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):

            $merger = Merger::findOrFail($id);

            $companies = Company::lists('name', 'id')->toArray();

            return view('admin.merger.edit', compact('companies', 'merger'));
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMerger $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):

            $merger = Merger::findOrFail($id);

            $merger->update($request->data());

            return redirect()->route('admin.merger.edit', $id)
            ->with('success', 'Selected merger have been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $merger = Merger::findOrFail($id);

            $merger->delete();

            return redirect()->route('admin.merger.index')
            ->with('success', 'Selected merger have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
