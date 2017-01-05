<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    //Login Page
    public function getLogin()
    {		
        if(Auth::check())
            if(Auth::user()->isAdmin())
                return view('admin.dashboard');
            else
                return redirect('/');
        else
            return view('front.login.index');
    }

    //Valiate Login Credentials
    public function postLogin()
    {
        $input = $this->request->all();
        $email = $input['login_email'];
        $password = $input['login_password'];
        $url=null;
        if(array_key_exists('query',parse_url($this->request->header('referer')))):
            $url=parse_url($this->request->header('referer'))['query'];
        endif;
        if (Auth::attempt(['email' => $email, 'password' => $password])) // if registered
        {
            if(Auth::user()->status == 1) //only active users
            {
                if(Auth::user()->isAdmin()){
                    if(is_null($url)):
                        return redirect()->route('admin.dashboard'); //if admin
                    else:
                        return redirect()->to($url);
                    endif;
                }
                else{
                    if(Auth::user()->confirmed==1){
                        if(is_null($url)):
                            return redirect()->route('member.home'); // if client
                        else:
                            return redirect()->to($url);
                        endif;
                    } else {
                        $id = Auth::id();
                        Auth::logout();
                        return redirect()->back()->with('warning','Account not confirmed. Please check your email address for confirmation. <form style="display:inline" method="POST" action="'.route('resend-confirmation').'"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="id" value="'.$id.'"><button type="submit" class="resend">Resend</button></form>');
                    }
                }
            } else {
                Auth::logout();
                return redirect()->back()->with('warning','Account suspended. Please contact the administrator.');
            }
        }
        else{
            return redirect('login')->with('warning','Email/Password mismatch');
        }
    }

    //Get usertype for logged in user
    public function userDetails()
    {
        return UserType::find(Auth::user()->type_id);
    }

    //Logout function
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
