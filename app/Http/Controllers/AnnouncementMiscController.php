<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Announcement;
use App\Models\AnnouncementType;
use App\Models\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementMisc;
use App\Http\Requests\AnnouncementMiscFormRequest;

class AnnouncementMiscController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $miscs = AnnouncementMisc::with('type','subtype')->get();
            return view('admin.announcement.misc.index')->with('miscs',$miscs);
        else:
            return view('errors.403');
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $types = AnnouncementType::lists('label','id')->toArray();
            return view('admin.announcement.misc.create')->with('types',$types);
        else:
            return view('errors.403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     * @param AnnouncementMiscFormRequest $request
     * @return Response
     */
    public function store(AnnouncementMiscFormRequest $request )
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $data = [
                'type_id'=>$request->get('type_id'),
                'subtype_id'=>$request->get('subtype_id'),
                'title'=>$request->get('title'),
                'description'=>$request->get('description'),
            ];
            AnnouncementMisc::create($data);

            return redirect()->route('admin.announcement.misc.index')->with('success','Dynamic title and description has been created');
        else:
            return view('errors.403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $misc = AnnouncementMisc::with('type','subtype')->find($id);
            if(is_null($misc)):
                redirect()->route('admin.announcement.misc.index')->with('danger','Invalid Request.');
            endif;

            return view('admin.announcement.misc.show')
                ->with('misc',$misc);
        else:
            return view('errors.403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $misc = AnnouncementMisc::find($id);
            if(is_null($misc)):
                redirect()->route('admin.announcement.misc.index')->with('danger','Invalid Request.');
            endif;

            $types = AnnouncementType::lists('label','id')->toArray();
            return view('admin.announcement.misc.edit')
                ->with('types',$types)
                ->with('misc',$misc);
        else:
            return view('errors.403');
        endif;
    }

    public function update($id,AnnouncementMiscFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $misc = AnnouncementMisc::find($id);
            if(is_null($misc)):
                redirect()->route('admin.announcement.misc.index')->with('danger','Invalid Request.');
            endif;

            $misc->type_id = $request->get('type_id');
            $misc->subtype_id = $request->get('subtype_id');
            $misc->title = $request->get('title');
            $misc->description = $request->get('description');
            $misc->save();

            return redirect()->route('admin.announcement.misc.index')->with('success','Dynamic title and description has been updated');
        else:
            return view('errors.403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $misc = AnnouncementMisc::find($id);
            if(is_null($misc)):
                redirect()->route('admin.announcement.misc.index')->with('danger','Invalid Request.');
            endif;

            $misc->delete();
            return redirect()->route('admin.announcement.misc.index')->with('success','Dynamic title and description has been deleted.');
        else:
            return view('errors.403');
        endif;
    }
}
