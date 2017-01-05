<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use App\Models\Company;
use App\Models\TodaysPrice;
use App\Models\News;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::whereUserId(Auth::id())->with('company')->get();

        $latestTradedPrice = [];
        foreach ($watchlists as $watchlist) {
            $latestTradedPrice[$watchlist->company_id] =TodaysPrice::where('company_id',$watchlist->company_id)
                ->where('date',TodaysPrice::getLastTradedDate($watchlist->company_id))
                ->first();
        }


        return view('front.watchlist.index',compact('watchlists','latestTradedPrice'));
    }

    public function addOrRemove(Request $request)
    {
        $company = Company::find($request->get('company_id'));
        $redirect = $request->get('redirect',null);

        if(!$company || !Auth::check()):
            return 0;
        endif;

        $user = Auth::user();

        $watchlistExists = Watchlist::whereUserId($user->id)->whereCompanyId($company->id)->first();
        if($watchlistExists){
            $watchlistExists->delete();
            $message = "{$company->quote} removed from watchlist";
            $status = 0;
        } else {
            $watchlist = new Watchlist;
            $watchlist->company_id = $company->id;
            $watchlist->user_id = $user->id;
            $watchlist->save();
            $message = "{$company->quote} added to watchlist";
            $status = 1;
        }

        if(!(is_null($redirect))) return redirect()->back()->with('success',$message);
        return ['message'=>$message,'status'=>$status];
    }

}
