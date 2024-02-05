<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Jabatan;
use App\Organisasi;
use App\Team;
use App\Role;
use Excel;
use Validator;
use Datatables;

class RegisterUserController extends Controller
{
	public function index() {
        $roles = Role::all();
        $jabatan = Jabatan::all();
        $org = Organisasi::orderBy('nama_opd','ASC')->get();
        $team = Team::all();

        return view('admin.user.register', compact('roles','jabatan','org','team'));
    }

    public function store(Request $request)
    {
        $email  = $request->input('email');
        $o = User::all();
        // foreach($o as $p){
            
        //     if($p->email != $email){
                $datapass = bcrypt($request->input('password'));
                $user = User::create([
                    'id' => rand(10,99).'0'.rand(1,10).date('Ymd'),
                    'nama_depan' => $request->input('nama_depan'),
                    'nama_belakang' => $request->input('nama_belakang'),
                    'role_user' => 'User',
                    'id_jabatan' => $request->input('id_jabatan'),
                    'id_organisasi' => $request->input('id_organisasi'),
                    'notifikasi' => 'ya',
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'jenis_kelamin' => $request->input('jns_kelamin'),
                    'decrypt_pass' => $request->input('password'),
                    'password' => $datapass,
                    'status' => 'Aktif'
                ]);

                return redirect()->route('register_user.index')->with('success', 'Selamat.. Pendaftaran Pada Aplikasi Servicedesk Berhasil!');   
                 
            // }else{
            //    var_dump('email sama');exit();
            //     return redirect()->route('register_user.index')->with('warning', 'Selamat.. Pendaftaran Pada Aplikasi Servicedesk Berhasil!');  
            // }
        // }

       
    }

}