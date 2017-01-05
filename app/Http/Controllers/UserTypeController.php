<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserType;
use App\Http\Requests\UserTypeFormRequest;

class UserTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','user')):
            $allUserTypes = UserType::all();
			
			$this->request->Session()->flash('info','"1" grants a usertype permission while "0" revokes. "1111" gives a usertype permission for create, read, update, delete accordingly.');
			
            return view('admin.userType.all')->with('userTypes',$allUserTypes);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(UserTypeFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','user')):
            $input = $request->all();
            $name = $input['type'];
            $news = implode('',$input['news']);
            $portfolio = implode('',$input['portfolio']);
            $dataservice = implode('',$input['dataservice']);
            $user = implode('',$input['user']);
            $crawl = implode('',$input['crawl']);

            $userType = new UserType;
            $userType->label = $name;
            $userType->news_rights = $news;
            $userType->portfolio_rights = $portfolio;
            $userType->data_rights = $dataservice;
            $userType->user_rights = $user;
            $userType->crawl_rights = $crawl;
            $userType->save();

            return redirect()->route('admin.userType.index')
            ->with('success','A new user type has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
	
	public function update(UserTypeFormRequest $request,$id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','user')):
            $input = $request->all();
            $name = $input['type'];
            $news = implode('',$input['news']);
            $portfolio = implode('',$input['portfolio']);
            $dataservice = implode('',$input['dataservice']);
            $user = implode('',$input['user']);
            $crawl = implode('',$input['crawl']);

            $userType = UserType::find($id);
            $userType->label = $name;
            $userType->news_rights = $news;
            $userType->portfolio_rights = $portfolio;
            $userType->data_rights = $dataservice;
            $userType->user_rights = $user;
            $userType->crawl_rights = $crawl;
            $userType->save();

            return redirect()->route('admin.userType.index')
            ->with('success','User type has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','user')):
            $userType = UserType::find($id);

            if(is_null($userType)){
                return redirect()->back()->with('message','Invalid Request');
            }
            if($userType->countUser() == 0):
                $userType->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related users.');
            endif;

            return redirect()->route('admin.userType.index')
                ->with('success','Selected user type have been deleted successful.');
        else:
            return redirect()->route('403');
        endif;
    }
}
