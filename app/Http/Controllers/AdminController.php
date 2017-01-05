<?php

namespace App\Http\Controllers;

use Auth;
use Artisan;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\News;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }

	public function command($command)
	{
		$whitelist = Config::get('commands.whitelist');
		if(in_array($command,$whitelist)){
			Artisan::call($command, array());
			return redirect()->route('admin.dashboard')->with('commands',$whitelist)->with('info',"$command \ncommand executed successfully");
		}
		return redirect()->route('admin.dashboard')->with('commands',$whitelist)->with('warning',"Invalid command.");
		
	}

	public function newsletter()
	{
		$data = News::generateNewsletter(Auth::user());
		$index = $data['index'];
		$newsList = $data['newsList'];
		$articles = $data['articles'];
		$interviews = $data['interviews'];
		$announcements = $data['announcements'];
		$user = $data['user'];
		$date = $data['date'];
		$todaysSummary = $data['todaysSummary'];
		$confirmSend = 1;

		return view('emails.watchlist',compact('index','newsList','articles','interviews','announcements','user','date','todaysSummary','confirmSend'));
	}
}
