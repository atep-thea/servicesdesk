<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Jabatan;
use App\Organisasi;
use App\Team;
use App\Role;
use App\ReffGolongan;
use App\RoleUser;

use Excel;
use Validator;
use Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {

        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role != 'Admin') return view('vendor.adminlte.errors.404');    

        return view('admin.user.index');
    }

    public function userData()
    {
        $query = User::leftjoin('jabatan','jabatan.id_jabatan', '=','users.id_jabatan')
                    ->leftjoin('organisasi','organisasi.id_organisasi', '=','users.id_organisasi')
                    // ->leftjoin('roles','roles.id_roles', '=','users.role_user')
                    ->select('users.id','users.organisasi as org','users.status as status_user','users.nama_belakang','users.nama_depan','users.email','users.phone','jabatan.jabatan','organisasi.nama_opd as opd','users.jbt','users.id_jabatan','users.id_organisasi')
                    ->where('users.id','!=',1)
                    ->orderBy('users.id', 'desc')
                    ->get();
        //dd($query);exit();
        return Datatables::of($query)

                ->addColumn('action', function($item) {
                    $temp = "<span data-toggle='tooltip' title='Edit User'>
                    <a href=".route('user.edit',$item->id)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";
                    $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                    <a href='#delete' data-delete-url=".route('user.destroy', $item->id)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                    return $temp;
                })
                ->editColumn('id', function($item) {
                    return "<a href='".route('user.show', $item->id)."'>".$item->id."</a>";
                })
                ->editColumn('opd', function($item) {
                    if($item->id_organisasi == NULL){
                        return "<a href='#'>".$item->org."</a>";
                    }else{
                         return $item->opd;
                    }
                })
                ->editColumn('jabatan', function($item) {
                    if($item->id_jabatan == NULL){
                        return $item->jbt;
                    }else{
                         return $item->jabatan;
                    }
                })
                // ->editColumn('opd', function($item) {
                //     return "<a href='".route('organisasi.show', $item->id_organisasi)."'>".$item->opd."</a>";
                // })
                ->make(true);
    }

    public function create() {
        $roles = Role::all();
        $jabatan = Jabatan::all();
        $org = Organisasi::all();
        $team = Team::all();
        $golongan = ReffGolongan::all();
        $roleUser = RoleUser::all();
    	return view('admin.user.create', compact('roles','jabatan','org','team','golongan','roleUser'));
    }

    public function show($id){
        $data['user'] = User::leftjoin('team','team.id_team', '=', 
                    'users.id_team')
                    ->leftjoin('jabatan','jabatan.id_jabatan', '=','users.id_jabatan')
                    ->leftjoin('organisasi','organisasi.id_organisasi', '=','users.id_organisasi')
                    ->select('users.id','users.organisasi as org','users.status','users.notifikasi','users.nama_belakang','users.nama_depan','users.email','users.name','team.name_team','users.phone','jabatan.jabatan','organisasi.nama_opd as opd','users.role_user','users.jenis_kelamin','users.id_organisasi')->find($id);
        //dd($data['user']);exit();
        if (!$data['user']) return view('errors.404');
        return view('admin.user.detail', $data);
    }

    public function edit($id)
    {
        // var_dump($id);exit();
        $user = User::find($id);
        //var_dump($user);exit();
        $roles = Role::all();
        $jabatan = Jabatan::all();
        $org = Organisasi::all();
        $Team = Team::all();
        $golongan = ReffGolongan::all();

        return view('admin.user.edit', compact('user','Team','roles','jabatan','org','golongan'));
    }

    public function createRole() {
    	return view('admin.user.createRole');
    }

    public function store(Request $request)
    {
        
        //dd($request->all());exit();
        if(empty($request->input('password'))){
            $datapass = NULL;
        }else if(!empty($request->input('password'))){
           $datapass = bcrypt($request->input('password'));
        }

        //$userId = rand(10,99).''.date('Ymd').rand(1,10);
        //var_dump($userId);exit();
        $user = User::create([
            'id' => rand(10,99).'0'.rand(1,10).date('Ymd'),
            'nama_depan' => $request->input('nama_depan'),
            'nama_belakang' => $request->input('nama_belakang'),
            'role_user' => $request->input('role_user'),
            'id_jabatan' => $request->input('id_jabatan'),
            'id_organisasi' => $request->input('id_organisasi'),
            'id_team' => $request->input('id_team'),
            'notifikasi' => "Ya",
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'decrypt_pass' => $request->input('password'),
            'password' => $datapass,
            'status' => $request->input('status'),
            // 'golongan_id'=>$request->input('golongan_id'),
        ]);

        //$checks = $request->input('checks');
        $roles = $request->input('roles');
        //print_r($roles);exit;

        $role = Role::find($roles);
        $user->attachRole($role);

        return redirect()->route('user.index')->with('success', 'User berhasil disimpan!');
    }
 
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) return view('errors.404');
        if ($request->input('password') != null || $request->input('password') != ''){
            $datapass = bcrypt($request->input('password'));
        }else{
            $datapass = NULL;
        }
        $user->nama_depan = $request->input('nama_depan');
        $user->nama_belakang = $request->input('nama_belakang');
        $user->role_user = $request->input('role_user');
        $user->id_jabatan = $request->input('id_jabatan');
        $user->id_organisasi = $request->input('id_organisasi');
        $user->id_team = $request->input('id_team');
        $user->golongan_id = $request->input('golongan_id');
        $user->notifikasi = 'Ya';
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->decrypt_pass = $request->input('password');
        $user->password = $datapass;
        $user->status = $request->input('status');
        $user->save();

        $user->roles()->detach();
        $roles = $request->input('roles');
        $role = Role::find($roles);
        $user->attachRole($role);

        return redirect()->route('user.index')->with('success', 'User berhasil diubah!');
    }

    public function destroy($id)
    {

        $user = User::find($id);
        if (!$user) return view('errors.404');

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

     public function exportExcel(Request $request)
    {
        $data['title'] = 'Data Users';
        $data['org'] = User::leftjoin('jabatan','jabatan.id_jabatan', '=','users.id_jabatan')
                    ->leftjoin('organisasi','organisasi.id_organisasi', '=','users.id_organisasi')
                    ->leftjoin('roles','roles.id', '=','users.role_user')
                    ->leftjoin('team','team.id_team', '=','users.id_team')
                    ->select('users.id','users.status as status_user','users.nama_belakang','users.nama_depan','users.email','users.phone','jabatan.jabatan','organisasi.nama_opd as opd','roles.display_name','users.name as username','users.decrypt_pass as passwd')
                    ->where('users.id','!=',1)
                    ->where('users.status','=','Aktif')
                    ->orderBy('users.id', 'desc')
                    ->get();
        Excel::create('Data Users '.date('Y').'',function($excel) use ($data){
            $excel->sheet('Sheet 1',function($sheet) use ($data){

                $sheet->loadView('admin.user.excelView', $data);
            });
        })->export('xls');
    }

    public function importExcel(Request $request)
    {
        //var_dump('kadieu');exit();
       
         $request->validate([
            'import_file' => 'required'
        ]);
 
        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();

        if($data->count()){
            foreach ($data as $key => $value) {
                $arr[] = [
                    'id' => rand(10,99).'0'.rand(1,10).date('Ymd'),
                    'nama_depan' => $value->nama_depan,
                    'nama_belakang' => $value->nama_belakang, 
                    'name' => $value->username,
                    'jbt' => $value->jabatan,
                    'organisasi' => $value->organisasi,
                    'role_user' => $value->role_user,
                    'phone' => $value->phone,
                    'email' => $value->email,
                ];
            }
 
            if(!empty($arr)){
                User::insert($arr);
            }
        }
 
        return back()->with('success', 'Import data Excel Sukses..!!');
    }

    public function showProfile()
    {
        $user = Auth::user();

        $user['total_donation'] = $user->donations->sum(function($item) {
            if ($item->status == 'success') return $item->amount;
            return 0;
        });

        return view('public.profil', compact('user'));
    }

    public function editAccount($id){
        $user = User::find($id);

        return view('admin.user.editAkun', compact('user'));
    }

    public function updateAkun(Request $request){
        if ($request->input('password') != null || $request->input('password') != ''){
            $datapass = bcrypt($request->input('password'));
        }else{
            $datapass = NULL;
        }

        $id = $request->id_user;
        $userAKun = User::find($id);
        $userAKun->notifikasi = $request->input('notifikasi');
        $userAKun->name = $request->input('name');
        $userAKun->email = $request->input('email');
        $userAKun->phone = $request->input('phone');
        $userAKun->decrypt_pass = $request->input('password');
        $userAKun->password = $datapass;
        $userAKun->status = $request->input('status');
        $userAKun->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diubah!');
    }

    public function editProfile()
    {
        $user = Auth::user();

        $user['total_donation'] = $user->donations->sum(function($item) {
            if ($item->status == 'success') return $item->amount;
            return 0;
        });
       //dd($user);

        return view('public.editprofile', compact('user'));
    }
}
