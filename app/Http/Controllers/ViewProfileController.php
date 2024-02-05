<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Campaign;
use App\Donation;
use App\Report;
use App\User;
use App\Jabatan;
use App\Organisasi;
use App\Team;
use App\Role;
use App\Mail\GeneralMail;
use Auth;
use Datatables;
use Mail;
use Validator;
use Image;
use File;
use Illuminate\Support\Facades\Log;

class ViewProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_auth = Auth::user();

        $user_profile = User::with(array('jabatan','org','team','golongan'))
                    ->find(Auth::user()->id);

        Log::info($user_profile);
        Log::info($user_profile->org);
        
        return view('admin.view_profile.admin',$user_profile);    
        
    }

    public function view_user()
    {
        // var_dump('masuk');exit();
        $user_auth = Auth::user();

        $id = $user_auth['id'];

        $data['user'] = User::leftjoin('jabatan as j','users.id_jabatan','=','j.id_jabatan')
                       ->leftjoin('team as t','t.id_team','=','users.id_team')
                       ->leftjoin('organisasi as org','org.id_organisasi','=','users.id_organisasi')
                       ->leftjoin('roles','roles.id','=','users.role_user')
                      ->select('users.nama_depan as namaDepan','users.foto','users.nama_belakang as namaBelakang','users.phone','users.email as emailUser','j.jabatan as jbt','org.nama_opd','t.name_team','roles.name as display_name','users.status','users.jenis_kelamin','users.id as IdUser')
                       ->where('users.id','=',$id)
                       ->first();

        $roles = Auth::user()->role_user;
        
        return view('admin.view_profile.user',$data);

    }

    public function updateUser($id)
    {
      
      return redirect()->url('view_profile_user')->with('success', 'User berhasil diubah!');
    }

    public function edit($id)
    {
        //var_dump('masuk');exit();
        $user = User::find($id);
        $roles = Role::all();
        $jabatan = Jabatan::all();
        $org = Organisasi::all();
        $Team = Team::all();
        
        return view('admin.user.edit', compact('user','Team','roles','jabatan','org'));
    }

    public function update(Request $request, $id)
    {
        $datapass = bcrypt($request->input('password'));

        if(empty($request->input('password'))){
            $user = User::find($id);
            if (!$user) return view('errors.404');
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
               
                $attachment = $file;
                $extension = $attachment->getClientOriginalExtension();
                $attachment_real_path = $attachment->getRealPath();
                $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
                $filename = date('Ymdhis') . '_' . $real_filename;
                if (!File::exists(getcwd() . '/public/photos/profile/' . $user->id . '/')) {
                    $result = File::makeDirectory(getcwd() . '/public/photos/profile/' . $user->id . '/', 0777, true);
                    if ($result) {
                        $destination_path = getcwd() . '/public/photos/profile/' . $user->id . '/';
                    }
                } else {
                    $destination_path = getcwd() . '/public/photos/profile/' . $user->id . '/';
                }
                $attachment->move($destination_path, $filename);
                $user->foto = $filename;
            }
            
            
            $user->nama_depan = $request->input('nama_depan');
            $user->nama_belakang = $request->input('nama_belakang');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            // $user->id_organisasi = $request->input('org');
            // $user->id_jabatan = $request->input('jbt');
            $user->name = $request->input('name');
            $user->save();
        }else{
            $user = User::find($id);
            if (!$user) return view('errors.404');
            $user->nama_depan = $request->input('nama_depan');
            $user->nama_belakang = $request->input('nama_belakang');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            // $user->id_organisasi = $request->input('org');
            // $user->id_jabatan = $request->input('jbt');
            $user->name = $request->input('name');
            $user->password = $datapass;
            $user->save();
        }

        $data['user'] = User::leftjoin('jabatan as j','users.id_jabatan','=','j.id_jabatan')
                       ->leftjoin('team as t','t.id_team','=','users.id_team')
                       ->leftjoin('organisasi as org','org.id_organisasi','=','users.id_organisasi')
                       ->leftjoin('roles','roles.id','=','users.role_user')
                      ->select('users.nama_depan as namaDepan','users.foto','users.nama_belakang as namaBelakang','users.phone','users.email as emailUser','j.jabatan as jbt','org.nama_opd','t.name_team','roles.name as display_name','users.status','users.id as IdUser')
                       ->where('users.id','=',$id)
                       ->first();

        return redirect()->route('view_profile')->with('success', 'User berhasil diubah!');
    }


    public function show($id)
    {
        $user = User::leftjoin('jabatan as j','users.id_jabatan','=','j.id_jabatan')
                       ->leftjoin('team as t','t.id_team','=','users.id_team')
                       ->leftjoin('organisasi as org','org.id_organisasi','=','users.id_organisasi')
                       ->leftjoin('roles','roles.id','=','users.role_user')
                      ->select('users.nama_depan as namaDepan','users.foto','users.nama_belakang as namaBelakang','users.phone','users.email as emailUser','users.id_organisasi as idOrg','j.jabatan as jbt','org.nama_opd','t.name_team','roles.name as display_name','users.id_jabatan as idJbt','users.jenis_kelamin','users.name as userName','users.status','users.id as IdUser')
                       ->where('users.id','=',$id)
                       ->first();
        //dd($user);exit();
        $roles = Role::all();
        $jabatan = Jabatan::all();
        $org = Organisasi::all();
        $Team = Team::all();

        return view('admin.view_profile.edit', compact('user','Team','roles','jabatan','org'));
    
    }
    
}