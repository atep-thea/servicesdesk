<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserRegistered;
use App\User;
use Facebook;
use App\Role;
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    // public function showRegistrationForm()
    // {
    //     return view('adminlte::auth.register');
    // }

    public function test(){
        var_dump('test code');exit();
    }

    //   public function showRegistrationForm()
    // {
    //     return view('adminlte::auth.register');
    // }

    // public function showPublicRegistrationForm()
    // {
    //     // var_dump('test');exit();
    //     $fblogin_url = Facebook::getLoginUrl(['email', 'public_profile']);

    //     return view('public.register', compact('fblogin_url'));
    // }

    public function index()
    {
        $fblogin_url = Facebook::getLoginUrl(['email', 'public_profile']);

        return view('public.register', compact('fblogin_url'));
    }

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
            // 'terms' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function createPublicUser(array $data)
    {
        $role = $data['role'];
        //dd($role);

        $donator_role = Role::where('name', $role)->first();
        //dd($donator_role);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $user->attachRole($donator_role);

        return $user;
    }

    public function store(Request $request)
    {
        var_dump('ini register');exit();
        
        $role = $request->role;

        if ($role=='donator')
        {
            $link='/profile';
        }
        else
        {
            $link='/campaign';
        }

        $this->validator($request->all())->validate();
        

        event(new Registered($user = $this->createPublicUser($request->all())));

        $this->guard()->login($user);

        if (!$this->registered($request, $user)) {
            // Mail::to($user)->queue(new UserRegistered($user));

            if ($request->ajax()) return response()->json([
                'status' => 'success'
            ], 200);

            return redirect($link);
        }

        return $this->registered($request, $user)
            ?: redirect($link);
    }

    public function publicRegisterNotRegister(Request $request)
    {
        $role = $request->role;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        if ($role=='donator')
        {
            $link='/profile';
        }
        else
        {
            $link='/campaign';
        }

        //$this->validator($request->all())->validate();
        if ($name=="")
        {
            if ($request->ajax()) return response()->json([
            'error' => 'nama tidak boleh kosong'
            ]);exit;
        }

        if ($email=="")
        {
            if ($request->ajax()) return response()->json([
            'error' => 'email tidak boleh kosong'
            ]);exit;
        }

        if ($phone=="")
        {
            if ($request->ajax()) return response()->json([
            'error' => 'Nomor HP tidak boleh kosong'
            ]);exit;
        }

        if ($password=="")
        {
            if ($request->ajax()) return response()->json([
            'error' => 'Password tidak boleh kosong'
            ]);exit;
        }

        if ($password_confirmation=="")
        {
            if ($request->ajax()) return response()->json([
            'error' => 'Konfirmasi Password tidak boleh kosong'
            ]);exit;
        }

        if ($password <> $password_confirmation)
        {
            if ($request->ajax()) return response()->json([
            'error' => 'Password dan Konfirmasi Password Tidak Sama'
            ]);exit;
        }

        $user = User::where('email', $email)->first();

        //dd($user);

        if ($user)
        {
            if ($request->ajax()) return response()->json([
            'error' => 'Email Sudah Terdaftar'
            ]);exit;
        }

        event(new Registered($user = $this->createPublicUser($request->all())));

        $this->guard()->login($user);

        if (!$this->registered($request, $user)) {
            // Mail::to($user)->queue(new UserRegistered($user));

            if ($request->ajax()) return response()->json([
                'status' => 'success'
            ], 200);

            return redirect($link);
        }

        return $this->registered($request, $user)
            ?: redirect($link);
    }
}
