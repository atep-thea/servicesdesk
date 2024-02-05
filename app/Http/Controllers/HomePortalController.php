<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Auth;

use App\User;

use App\Jabatan;

use App\Organisasi;

use App\Team;

use App\Role;

use Validator;

use Datatables;



class HomePortalController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth');

    }

    

    public function index() {
        
        // $home = User::all();
        // $role = Auth::user()->role_user;
        // if (!$home || $role == 'Admin') return view('vendor.adminlte.errors.404');

        return view('userportal.home');
    }

    public function closeTiketView(){
        return view('userportal.onprogress.close_tiket');
    }

}