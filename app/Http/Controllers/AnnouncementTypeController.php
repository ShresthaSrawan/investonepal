<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementTypeFormRequest;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementType;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AnnouncementTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Display a listing of the Anouncement Type.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $announcementTypes = AnnouncementType::get();
            return view('admin.announcementType.all')->with('announcementTypes',$announcementTypes);
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnnouncementTypeFormRequest $request
     * @return Response
     */
    public function store(AnnouncementTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $announcementType = new AnnouncementType();
            $announcementType->label = $request->get('label');
            $announcementType->save();

            return redirect()->route('admin.announcement-type.index')
                ->with('success','New Announcement Type has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $announcementType = AnnouncementType::with('subTypes')->find($id);
            if(is_null($announcementType)) return redirect()->route('admin.announcement-type.index')->with('info','Invalid announcement type URL.');

            return view('admin.announcementType.subtype.index')->with('anonType',$announcementType);
        else:
            return redirect()->route('403');
        endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param AnnouncementTypeFormRequest $request
     * @return Response
     */
    public function update($id, AnnouncementTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $announcementType = AnnouncementType::find($id);
            if(is_null($announcementType)){
                return redirect()->route('admin.announcement-type.index')->with('warning','Invalid announcement type update request.');
            }

            $announcementType->label = $request->get('label');
            $announcementType->save();

            return redirect()->route('admin.announcement-type.index')
                ->with('success','Announcement type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $anouncementType = AnnouncementType::find($id);
            if(is_null($anouncementType)):
                return redirect()->route('admin.announcement-type.index')
                    ->with('warning','Invalid announcement type deletion request.');
            endif;

            $countSubtype = $anouncementType->countSubtype();

            if($countSubtype != 0):
                return redirect()->route('admin.announcement-type.index')
                    ->with('info',"This announcement type has {$countSubtype} subtypes. Please delete those subtype to perform this action.");
            endif;

            $countAnnouncement = $anouncementType->countAnnouncement();
            if($countAnnouncement != 0):
                return redirect()->route('admin.announcement-type.index')
                    ->with('info',"This announcement type is associated with {$countAnnouncement} announcements. Please update those announcement's type to perform this action");
            endif;

            $anouncementType->delete();

            return redirect()->route('admin.announcement-type.index')
                ->with('success','Announcement type has been successfully deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
