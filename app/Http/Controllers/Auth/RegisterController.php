<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\RoleUser;
use Mail;
use App\Mail\UserRegistered;
use App\Model\WilayahTebar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DB;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

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
        // $messages = [
        //     'unique' => 'Nomor Telepon sudah teregistrasi, gunakan nomor telepon lain.',
        //     'unique' => 'Email sudah teregistrasi, gunakan email lain.',
        // ];
        return Validator::make($data, [
            'nama'      => 'required|string|max:255',
            'phone'     => 'max:15|unique:users',
            'email'     => 'max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    // public function register(Request $request)
    // {
    //     $this->validator($request->all())->validate();

    //     event(new Registered($user = $this->create($request->all())));

    //     $this->guard()->login($user);

    //     return $this->registered($request, $user)
    //                     ?: redirect($this->redirectPath());
    // }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['nama'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function createPublicUser(array $data)
    {
        $role = $data['role'];

        $donator_role = Role::where('name', $role)->first();

        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $user->attachRole($donator_role);

        return $user;
        // $user = new User;
        // $user->name = $data['nama'];
        // $user->phone = $data['phone'];
        // $user->email = $data['email'];     
        // $user->password = bcrypt($data['password']);

        // $user->attachRole($donator_role);

        // $user->save();

        // $userId = $user->id;
        // $role = $data['role'];
        // $donator_role = Role::where('name', $role)->first();
        // $roleId = $donator_role['id'];


        // $role_user = new RoleUser;
        // $role_user->user_id = $userId;
        // $role_user->role_id = $roleId;
        // $role_user->save();

        

        // $user = User::create([
        //     'name' => $data['nama'],
        //     'email' => $data['email'],
        //     'phone' => $data['phone'],
        //     'password' => bcrypt($data['password']),
        // ]);
    }

    // Fungsi user tidak auto login, setlah register langsung logout, jng lupa tambah juga librari diatas, dua baris
    public function register(Request $request)
    {
        //var_dump('masuk register');exit();
        $role = $request->role;

        //var_dump($role);exit();

        if ($role=='donator')
        {
            $link='/profile';
        }
        else if($role=='relawan')
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
}
