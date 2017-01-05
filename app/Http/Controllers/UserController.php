<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Auth;
use DB;
use Mail;
use Exception;
use Config;
use Carbon\Carbon;
use App\Http\Requests;
use yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInfo;
use App\Models\User;
use App\Models\CompanyReview;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\ClientFormRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserProfileFormRequest;
use App\File;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','user')):
            return view('admin.user.index');
        else:
            return redirect()->route('403');
        endif;
    }

    public function getUserDatatable(Request $request) // ajax request
    {
        $userList = User::with('userInfo','userType')->get();
        return Datatables::of($userList)->make(true);
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','user')):
            $allUserTypes = UserType::lists('label','id');

            $this->request->Session()->flash('info','The fields marked asterisk ( * ) are required.');

            return view('admin.user.create')
                ->with('usertypes',$allUserTypes);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(UserFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','user')):
            $input = $request->all();

            DB::beginTransaction();
            try{
                $userinfo = new UserInfo;
                $userinfo->first_name = $input['userInfo']['first_name'];
                $userinfo->last_name = $input['userInfo']['last_name'];
                $userinfo->address = $input['userInfo']['address'];
                $userinfo->work = $input['userInfo']['work'];
                $userinfo->dob = $input['userInfo']['dob'];
                $userinfo->phone = $input['userInfo']['phone'];
                $userinfo->save();

                $user = new User;
                $user->username = $input['username'];
                $user->password = Hash::make($input['password']);
                $user->status = $input['status'];
                $user->type_id = $input['type'];
                $user->email = $input['email'];
                $user->expiry_date = $input['expiry_date'];
                $user->info_id = $userinfo->id;

                //upload profile_picture
                if($request->hasFile('profile_picture')){
                    $user->profile_picture = File::upload($request->file('profile_picture'),User::$imageLocation);
                }
				else{
					$user->profile_picture = 'placeholder-user.png';
				}
				
                $user->save();
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.user.create')->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()
                ->route('admin.user.show',$user->id)
                ->with('success','User has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','user')):
            $user = User::where('id','=',$id)->with('userInfo','userType')->first();
            return view('admin.user.show')
                ->with('user', $user);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','user')):
            $user = User::where('id','=',$id)->with('userInfo','userType')->first();
            $allUserTypes = UserType::lists('label','id');

            $this->request->Session()->flash('info','The fields marked asterisk ( * ) are required.');
            
            return view('admin.user.edit')
                ->with('usertypes',$allUserTypes)
                ->with('user',$user);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(UserFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','user')):
            $user = User::find($id);
            if($user == NULL){
                redirect()->back()->with('Danger','Invalid Request');
            }

            $input = $request->all();

            DB::beginTransaction();
            try{
                $user->username = $input['username'];
                if($input['password']!=''){
                    $user->password = Hash::make($input['password']);
                }
                $user->status = $input['status'];
                $user->type_id = $input['type'];
                $user->email = $input['email'];
                $user->expiry_date = $input['expiry_date'];

                //upload profile_picture
                if($request->hasFile('profile_picture')){
                    $user->removeImage();
                    $user->profile_picture = File::upload($request->file('profile_picture'),User::$imageLocation);
                }

                $user->save();

                $userinfo = UserInfo::find($user->info_id);
                $userinfo->first_name = $input['userInfo']['first_name'];
                $userinfo->last_name = $input['userInfo']['last_name'];
                $userinfo->address = $input['userInfo']['address'];
                $userinfo->work = $input['userInfo']['work'];
                $userinfo->dob = $input['userInfo']['dob'];
                $userinfo->phone = $input['userInfo']['phone'];
                $userinfo->save();
            }
            catch (Exception $e){
                DB::rollback();
                return redirect()->route('admin.user.edit',$id)->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.user.show',$id)
                ->with('success','User details have been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','user')):
            $user =User::find($id);

            if(!is_null($user)):
                $user->removeImage();
                $user->delete();
            else:
                return redirect()
                    ->route('admin.user.index')
                    ->with('danger','Invalid Request.');
            endif;

            return redirect()->route('admin.user.index')
            ->with('success','Selected user have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function registerClient(ClientFormRequest $request)
    {
        $input = $request->all();
        $confirmation_code = str_random(30);

        DB::beginTransaction();

        $userinfo = new UserInfo;
        $userinfo->first_name = '';
        $userinfo->last_name = '';
        $userinfo->save();

        $user = new User;
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $user->status = 1;
        $user->type_id = UserType::where('label','like','%client%')->first()->id;
        $user->email = $input['email'];
        $user->expiry_date = Carbon::now()->addMonths(Config::get('investonepal.NEW_USER_EXPIRY_MONTHS'))->format('Y-m-d');
        $user->confirmation_code = $confirmation_code;
        $user->info_id = $userinfo->id;
		$user->profile_picture = 'placeholder-user.png';
        $user->save();
        
        $data = array(
        'username' => $user->username,
        'confirmation_code' => $confirmation_code,
        );
        Mail::queue('emails.verify', $data, function($message) use ($user) {
            $message->subject('InvestoNepal: Email Verification');
            $message->from('no-reply@investo.com');
            $message->to($user->email);
        });

        DB::commit();
        
        return redirect()->route('login')->with('success','Account successfully created. Please check your inbox for confirmation.');
    }

    public function verify($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return redirect()->route('login')->with('warning','Invalid confirmation request');
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return redirect()->route('login')->with('warning','Invalid confirmation request');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return redirect()->route('login')->with('success','You have successfully verified your account.');

    }

    public function resetPasswordRequest(Request $request)
    {
        $email = $request->get('email_reset',null);

        if(!(is_null($email))){
            $user = User::whereEmail($email)->first();
            if(!(is_null($user))){
                DB::beginTransaction();
                $confirmation_code = str_random(30);
                $user->confirmation_code = $confirmation_code;
                $user->save();

                $data = array(
                    'username' => $user->username,
                    'confirmation_code' => $confirmation_code,
                );
                Mail::queue('emails.reset', $data, function($message) use ($user) {
                    $message->subject('InvestoNepal: Email password reset');
                    $message->from('no-reply@investo.com');
                    $message->to($user->email);
                });
                DB::commit();

                return redirect()->route('login')->with('success','Password reset request sent. Please check your email for furthur instructions.');
            }
        }
        return redirect()->back()->with('warning','Password reset request was not sent. Please make sure the email address is valid.');
    }

    public function resetPassword($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        return view('front.login.resetForm',compact('user','confirmation_code'));

    }

    public function newPassword(PasswordResetRequest $request)
    {
        $email = $request->get('email',null);
        $password = $request->get('password',null);
        $confirmation_code = $request->get('confirmation_code',null);

        $user = User::whereEmail($email)->whereConfirmationCode($confirmation_code)->first();

        if($user)
        {
            $user->password = Hash::make($password);
            $user->confirmation_code = null;
            $user->save();
            return redirect()->route('login')->with('success','Password reset successful');
        }

        return redirect()->back()->with('warning','Error resetting password');
    }

    public function resendConfirmationCode(Request $request)
    {
        $user = User::find($request->get('id'));

        if(! $user) return redirect()->back()->with('warning','Error sending confirmation. Pleas retry.');
        
        $confirmation_code = str_random(30);
        $user->confirmation_code = $confirmation_code;
        $user->save();

        $data = array(
        'username' => $user->username,
        'confirmation_code' => $confirmation_code,
        );

        Mail::queue('emails.verify', $data, function($message) use ($user) {
            $message->subject('InvestoNepal: Email verification');
            $message->from('no-reply@investo.com');
            $message->to($user->email);
        });

        return redirect()->back()->with('success','Please check your email for confimation.');
    }

    public function profileShow()
    {
        if(Auth::check()):
            $user = User::with('userInfo')->whereId(Auth::id())->first();

            $reviews = CompanyReview::with('company')->where('user_id',Auth::id())->get();

            return view('front.profile.show',compact('user','reviews'));
        else:
            return redirect()->route('/');
        endif;
    }

    public function profileEdit()
    {
        if(Auth::check()):
            $user = User::with('userInfo')->whereId(Auth::id())->first();

            return view('front.profile.edit',compact('user'));
        else:
            return redirect()->route('index');
        endif;   
    }

    public function profileUpdate(UserProfileFormRequest $request)
    {
        DB::beginTransaction();

        try{
            $userData = $request->only('username','email');

            if($request->has('password')){
                $userData['password'] = \Hash::make($request->get('password'));
            }

            //upload profile_picture if it exits
            if($request->hasFile('profile_picture')){
                $user->removeImage();
                $userData['profile_picture'] = File::upload($request->file('profile_picture'),User::$imageLocation);
            }

            Auth::user()->update($userData);

            $infoData = [
                'first_name' => $request->userInfo['first_name'],
                'last_name' => $request->userInfo['last_name'],
                'address' => $request->has('userInfo.address') ? $request->userInfo['address'] : null,
                'dob' => $request->has('userInfo.dob') ? $request->userInfo['dob'] : null,
                'phone' => $request->has('userInfo.phone') ? $request->userInfo['phone'] : null,
            ];

            Auth::user()->userInfo()->update($infoData);
        
        } catch (Exception $e){
            DB::rollback();
            return redirect()->route('user.profile')->with('danger', $e->getMessage());
        }

        DB::commit();

        return redirect()->route('user.profile')
            ->with('success','Your profile details have been updated successfully.');
    }

    public function newsletter(Request $request)
    {
        if(Auth::check()):
            if($request->isMethod('put')):
                $user = User::find(Auth::id());
                $user->subscribed = $request->get('subscribed');
                $user->save();

                $sub = $user->subscribed==1?"subscribed":"unsubscribed";
                return redirect()->route('user.profile')
                ->with('success','Newsletter has been '.$sub.'.');

            elseif($request->isMethod('get')):
                $user = User::with('userInfo')->whereId(Auth::id())->first();

                return view('front.profile.newsletter',compact('user'));
            endif;
        else:
            return redirect()->route('login');
        endif;
    }
}