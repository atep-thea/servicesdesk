<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\User;
use Facebook;
use Session;
use Mail;
use App\Mail\ForgetPassword;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    // public function showLoginForm()
    // {
    //     return view('adminlte::auth.login');
    // }
    public function index()
    {
        $fblogin_url = Facebook::getLoginUrl(['email', 'public_profile', 'publish_actions']);

        return view('public.login', compact('fblogin_url'));
    }

    public function showPublicLoginForm()
    {
        $fblogin_url = Facebook::getLoginUrl(['email', 'public_profile', 'publish_actions']);

        return view('public.login', compact('fblogin_url'));
    }

    public function forget_password()
    {
        return view('public.forget_password');
    }

    public function verifikasi_email($token)
    {
        return view('public.change_password', compact('token'));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        

        if ($user)
        {
            if ($user->hasRole('donator') )  return redirect()->back()->withErrors([
            'Anda tidak punya akses ke menu Admin'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                //dd($request->session()->regenerate());

                $this->clearLoginAttempts($request);

                return redirect()->intended('home');
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return redirect()->back()->withErrors(['Username atau Password salah']);
        }
        else
        {
            return redirect()->back()->withErrors(['Username atau Password salah']);
        }
        
        
    }

    public function publicLogin(Request $request)
    {
        //$this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

         if ($user)
        {
            if ($user->hasRole('relawan') )  return redirect()->back()->with('failed', 'Username atau Password salah');
            if ($user->hasRole('admin') )  return redirect()->back()->with('failed', 'Username atau Password salah');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $this->clearLoginAttempts($request);

                if ($request->ajax()) return response()->json([
                    'status' => 'success'
                ], 200);

                return redirect()->route('profile.show');
            }
            return redirect()->back()->with('failed', 'Username atau Password salah');
        }
        else
        {
            //dd("abc");
            return redirect()->back()->with('failed', 'Username atau Password salah');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        if ($request->ajax()) return response()->json([
            'error' => 'invalid-credentials'
        ]);

        return $this->sendFailedLoginResponse($request);
    }

    public function apiPublicLogin(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'error' => 'invalid-credentials'
        ], 200);
    }

    public function forget_password_post(Request $request)
    {

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if ($user)        

            if ($user->hasRole('donator'))
            {
                $token = md5(rand(10,1000000));
                //dd($token);
                Mail::to($user)->send(new ForgetPassword($user, $token));
                if ($request->ajax()) return response()->json([
                'status' => 'success'
                ], 200);
            }
            else
            {
              if ($request->ajax()) return response()->json([
                'error' => 'Email Tidak Terdaftar'
                ]);exit;   
            }
        else
        {

              if ($request->ajax()) return response()->json([
                'error' => 'Email Tidak Terdaftar'
                ]);exit;
        }

        
    }

    public function storePassword(Request $request)
    {

        $password = $request->password;
        $confirm_password = $request->confirm_password;
        $token = $request->token;

        $user = User::where('forget_token', $token)->first();

        if (!$user)
        {
            if ($request->ajax()) return response()->json([
                'status' => 'failed'
                ], 200);exit;
        }

        if ($password=="")
        {
            if ($request->ajax()) return response()->json([
                'error' => 'Password tidak boleh kosong'
                ]);exit;
        }

        if ($confirm_password=="")
        {
            if ($request->ajax()) return response()->json([
                'error' => 'Konfirmasi Password tidak boleh kosong'
                ]);exit;
        }

        if (strlen($password)<5)
        {
            if ($request->ajax()) return response()->json([
                'error' => 'Password minimal 5 Karakter'
                ]);exit;
        }

        if ($password<>$confirm_password)
        {
            if ($request->ajax()) return response()->json([
                'error' => 'Password tidak boleh kosong'
                ]);exit;
        }

        if ($user)
        {
            DB::table('users')->where('forget_token', $token)->update(['password' => bcrypt($password)]);
             if ($request->ajax()) return response()->json([
                'status' => 'success'
                ], 200);
        }

        
    }
}
