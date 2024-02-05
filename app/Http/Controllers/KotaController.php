<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kota;
use Input;
use DB;

class KotaController extends Controller
{
    public function cariKota(Request $request) {
    	$query = $request->get('query');
      $data = DB::table('regencies')->select('name as id','name as text')->where('name','like','%'.$query.'%')->get();
      // $data = Kota::selectRaw("name as id, name as text")->get();
      // $data = DB::table('regencies')->selectRaw("name as id, name as text")->get();
      return $data;
    }
}
