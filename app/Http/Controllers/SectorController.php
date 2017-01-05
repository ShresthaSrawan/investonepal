<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sector;
use App\Http\Requests\SectorFormRequest;

class SectorController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $sectors = Sector::all();

            return view('admin.sector.all')->with('sectors',$sectors);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(SectorFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $this->request->all();
            $sector = new Sector();
            $sector->label = $input['label'];
            $sector->save();

            return redirect()->route('admin.sector.index')
                ->with('success','A new sector has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(SectorFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $this->request->all();
            $sector = Sector::find($id);
            $sector->label = $input['label'];
            $sector->save();
            
            return redirect()->route('admin.sector.index')
                ->with('success','Sector has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $sector = Sector::find($id);

            if(is_null($sector)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            if($sector->countCompany() == 0):
                $sector->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related companies before deleting this sector.');
            endif;

            return redirect()->route('admin.sector.index')
                ->with('success','Selected sector has been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
