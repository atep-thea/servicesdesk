<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/registersuccess';

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
        $messages = [
            'unique' => 'Nomor Telepon sudah registrasi, silahkan gunakan nomor telepon yg lain.',
        ];
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'telp' => 'required|string|max:255|unique:users',
            'email' => 'max:255',
            'alamat' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            //'password' => 'required|string|min:6|confirmed',
        ], $messages);
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

            'name' => $data['name'],
            'telp' => $data['telp'],
            'email' => $data['email'],     
            'alamat' => $data['alamat'],
            'id_kantor' => $data['id_kantor'],
            'is_admin' => '0',
            // 'id_mitra' => $id_mitra,
            'kota' => $data['kota'],
            'desa' => $data['desa'],
            'kecamatan' => $data['kecamatan'],
            'provinsi' => $data['provinsi'],
            'verified' => 'no',
            'password' => bcrypt('123456'),
        ]);

       
    }

    // Fungsi user tidak auto login, setlah register langsung logout, jng lupa tambah juga librari diatas, dua baris
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


}
