<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\AnnouncementSubType;
use App\Models\AnnouncementType;
use Illuminate\Http\Request;

use App\Http\Requests;

class AnnouncementSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $announcementType = AnnouncementType::with('subTypes')->find($id);
            if(is_null($announcementType)) return redirect()->route('announcement-type.index')->with('info','Invalid announcement type URL.');

            return view('admin.announcementType.subtype.index')->with('anonType',$announcementType);
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($id,Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $label = $request->get('label');
            $subtype = new AnnouncementSubType();
            $subtype->label = $label;
            $subtype->announcement_type_id = $id;
            $subtype->save();

            return redirect()->back()->with('success','New Announcement subtype has been added');
        else:
            return redirect()->route('403');
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($tid,$sid,Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $subtype = AnnouncementSubType::find($sid);
            if(is_null($subtype)){
                return redirect()->back()->with('message','Invalid Request');
            }
            $subtype->label = $request->get('label');
            $subtype->save();

            return redirect()->back()->with('success','Announcement subtype has been updated.');
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
    public function destroy($tid,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $subtype = AnnouncementSubType::where('announcement_type_id',$tid)->where('id',$id)->first();
            if(is_null($subtype)) return redirect()->back()->with('warning','Invalid announcement subtype deletion request.');

            $countAnnouncement = $subtype->getAnnouncementCount();

            if($countAnnouncement > 0):
                return redirect()->route('admin.announcement-type.show',$tid)
                    ->with('info',"This announcement subtype is associated with {$countAnnouncement} announcements. Please update those announcement's type to perform this action");
            endif;

            $subtype->delete();

            return redirect()->route('admin.announcement-type.show',$tid)
                ->with('success',"Announcement subtype has been deleted successfully.");
        else:
            return redirect()->route('403');
        endif;
    }
}
