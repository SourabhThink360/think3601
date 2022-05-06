<?php
namespace App\Http\Controllers;
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);

use Illuminate\Http\Request;
use Cookie;
use App\User;
use Auth;
use DB;
use Hash;
use Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Validation;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponseController;

class ProfileController extends ResponseController
{
    //
    public function login(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            if (!empty(auth()
                ->user()
                ->id))
            {
                return redirect('dashboard');
            }
            return view('users.profiles.login');
        }

        if ($request->isMethod('POST'))
        {

            $validation = $this->is_validationRuleWeb(Validation::userLogin() , $request);
            if (!empty($validation))
            {
                return $validation;
            }

            $userLoginDetails['email'] = $request->email;
            $userLoginDetails['password'] = $request->password;
            if (Auth::attempt($userLoginDetails))
            {
                $setCookie = $this->setCookieUserData();
                Session::flash('message', 'Login successfully.');
                return redirect()
                    ->intended('dashboard');
            }

            else
            {
                Session::flash('danger', 'Email address and password does not match.');
                return back()
                    ->withInput();
            }
        }

    }

    public function register(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            if (!empty(auth()
                ->user()
                ->id))
            {
                return redirect('dashboard');
            }
            return view('users.profiles.register');
        }
        if ($request->isMethod('POST'))
        {

            $validation = $this->is_validationRuleWeb(Validation::userRegister() , $request);
            if (!empty($validation))
            {
                return $validation;
            }
            $inputArray = array(
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password) ,
            );

            // register user
            $user = User::create($inputArray);

            // if registration success then return with success message
            if (!is_null($user))
            {
                Session::flash('message', 'Register successfully. Please Enter Details For Login');
                return Redirect('login');
            }

            // else return with error message
            else
            {
                Session::flash('danger', 'OOPs Something Went Wrong.');
                return back()->withInput();
            }

        }

    }

    public function logout(Request $request)
    {
        $request->session()
            ->flush();
        Auth::logout();
        Cookie::forget('userData');
        return Redirect('login');
    }

    public function dashboard()
    {
        $userDataCookie = Cookie::has('userData');
        $name = auth()->user()->name;
        if ($userDataCookie)
        {
            $name = auth()->user()->name;
            $email = auth()->user()->email;
            $userInfo = array(
                'name' => $name,
                'email' => $email
            );
            Session::flash('message', 'Welcome to Admin Panel.');
            return view('users.profiles.dashboard', compact('userInfo'));

        }
        else
        {
            return Redirect('logout');
        }

    }

    public function setCookieUserData()
    {
        $authUserData = auth()->user();
        return Cookie::queue(Cookie::make('userData', $authUserData, 60));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try
        {

            $userInfoData = Socialite::driver('google')->user();

            $finduserInfo = User::where('email', $userInfoData->email)
                ->where('login_type', 'normal')
                ->first();


            if ($finduserInfo)
            {
                $id = $finduserInfo->id;
                User::find($id)->update(['flag' => 1]);
                Session::flash('message', 'Email Already Exist.');
                return redirect()
                    ->intended('login');
            }
            else
            {
                $randowPasswordGenerator = Str::random(8);
                $UserSocialData = User::where('email', $userInfoData->email)
                    ->where('login_type', 'social')
                    ->first();
                 if ($UserSocialData)
                {
                    $id = $UserSocialData->id;
                    User::find($id)->update(['password' => Hash::make($randowPasswordGenerator) ]);
                }
                else
                {
                    $newUser = User::create(['name' => $userInfoData->name, 'email' => $userInfoData->email, 'google_id' => $userInfoData->id, 'login_type' => 'social', 'password' => Hash::make($randowPasswordGenerator) ]);
                }

                $userLoginDetails['email'] = $userInfoData->email;
                $userLoginDetails['password'] = $randowPasswordGenerator;

                if (Auth::attempt($userLoginDetails))
                {
                    $setCookie = $this->setCookieUserData();
                    Session::flash('message', 'Login successfully.');
                    return redirect()
                        ->intended('dashboard');
                }
            }

        }
        catch(Exception $e)
        {
            Session::flash('error', 'Server Error Or Something Went Wrong');
            return redirect()->route('login');
        }
    }

}

