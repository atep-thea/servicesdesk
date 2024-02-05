<?php



namespace App\Http\Controllers;



use App\Organisasi;

use App\Pelayanan;

use App\ReffJnsPelayanan;

use App\ReffSjnsPelayanan;

use App\ReffTipePermintaan;

use App\ReffUrgensi;

use App\Subsubkategori;

use App\Team;

use App\Event;

use App\User;

use Illuminate\Http\Request;

use DB;

use Excel;

use Auth;

use Datatables;

use Image;

use File;

use Validator;

use Storage;

use Mail;





class InsidenUserController extends Controller

{


    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function __construct()

    {

        $this->middleware('auth');

    }

    

    public function index()

    {

        // $blogs = Blog::all();

        $org = Organisasi::all();

        $Agen = DB::table('users')->where('role_user','=',3)->get();

        $JnsPlynn = ReffJnsPelayanan::all();

        $SjnsPlynn = ReffSjnsPelayanan::all();

        $TipePermin = ReffTipePermintaan::all();

        $Urgensi = ReffUrgensi::all();

        $ssjns = Subsubkategori::all();

        $Team = Team::all();



        return view('userportal.insiden.index',compact('org','JnsPlynn','SjnsPlynn','TipePermin','Urgensi','Agen','Team','ssjns'));

    }



    public function insidenData()
    {
        $userId = Auth::user()->id;
        $org = Auth::user()->org;
        $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->leftjoin('users','users.id', '=','pelayanan.id_agen')
                    ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=','pelayanan.urgensi')
                    ->select('pelayanan.id_ as ids','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.lampiran','pelayanan.deskripsi','pelayanan.judul','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.jns_pelayanan','pelayanan.jns_insiden','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_urgensi.def_urgensi as urgensi','pelayanan.lampiran_balasan')
                    ->where('pelayanan.jns_pelayanan','=',6)
                    ->where('pelayanan.id_pelapor',$userId)
                    ->orderBy('ids','DESC')
                    ->get();

        return Datatables::of($query)
                           
                            ->editColumn('kd_tiket', function($item) {
                                 if($item->jns_insiden == 1){
                                    $insiden = 'Assesment';
                                }elseif($item->jns_insiden == 2){
                                    $insiden = 'Insiden Report';
                                }elseif($item->jns_insiden == 3){
                                    $insiden = 'Laporan Vurnability';
                                }
                               
                                $temp = "<a href='#' style='background:none;border:none; color:#3b8dca;' 
                                    data-idtiket='".$item->id_."'
                                    data-kdtiket='".$item->kd_tiket."'
                                    data-judul='".$item->judul."' 
                                    data-sts='".$item->status_tiket."'
                                    data-desk='".$item->deskripsi."'
                                    data-opd='".$item->nama_opd."'
                                    data-tgl_dft='".$item->tgl_pelaporan."'
                                    data-tgl_upd='".$item->tgl_update."'
                                    data-opd='".$item->nama_opd."'
                                    data-tp='".$item->tp."'
                                    data-plynn='".$item->plynn."'
                                    data-sjns='".$item->sjns."'
                                    data-urgen='".$item->urgensi."'
                                    data-nm_dpn='".$item->nama_agen."'
                                    data-insiden='".$insiden."'
                                    data-solusi='".$item->solusi."'
                                    data-balasan='".$item->desk_balasan."'
                                    
                                    
                                    class='' data-toggle='modal' data-target='#detailInsiden' >".$item->kd_tiket."</a>";
                                return $temp;
                            })
                            ->editColumn('deskripsi', function($item){
                                    $rest = substr($item->deskripsi, 0, 30).' ...';
                                    return $rest;
                            })
                            ->editColumn('lampiran', function($item){
                                // {{ route("categorie-afficher",["id"=>$id]) }}

                                return '<a href="/downloadLampiran/'.$item->ids.'">'.$item->lampiran.'</a>';
                            })
                            ->editColumn('lampiran_balasan', function($item){
                                // {{ route("categorie-afficher",["id"=>$id]) }}

                                return '<a href="/downloadInsiden/'.$item->ids.'">'.$item->lampiran_balasan.'</a>';
                            })
                            ->editColumn('jns_insiden', function($item) {
                                if($item->jns_insiden == 1){
                                    return 'Assesment';
                                }elseif($item->jns_insiden == 2){
                                    return 'Insiden Report';
                                }elseif($item->jns_insiden == 3){
                                    return 'Laporan Vurnability';
                                }
                            })
                            ->editColumn('status_tiket', function($item) {
                                if($item->status_tiket == 'Sent'){
                                    $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Baru'){
                                    $span = '<h5><span class="label label-primary" style="padding:3px 13px;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Close'){
                                    $span = '<h5><span class="label label-default" style="padding:3px 13px;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Diproses'){
                                    $span = '<h5><span class="label" style="background-color:#00B5AD;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Pending'){
                                    $span = '<h5><span class="label" style="background-color:#A5673F;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Disposisi'){
                                    $span = '<h5><span class="label" style="background-color:#E03997;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }elseif($item->status_tiket == 'Re-Open'){
                                    $span = '<h5><span class="label" style="background-color:#DE627F;">';
                                    return $span.$item->status_tiket.'</span></h5>';
                                }
                                //return $span.$item->status_tiket.'</span></h5>';
                            })
                            ->make(true);

    }

     public function downloadfile(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('surat_balasan').'/'.$data->lampiran_balasan;
        return response()->download($file_path);
    }

    public function getAgen($id){



        $agen_id = DB::table('users')->where("id_team",$id)->pluck("nama_depan","id");



        return json_encode($agen_id);

    }

    public function ubah_insiden(Request $request){
        //dd($request->all());exit();
        $kdTiket = $request->input('kode_tiket');
        $bls = $request->input('balasan');

        if ($request->hasFile('surat_blsn')) {
            $attachment = $request->file('surat_blsn');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $filename = str_random(5).date('Ymdhis').'.'.$extension;

            if (!File::exists(getcwd().'/public/surat_balasan/')) {
                $result = File::makeDirectory(getcwd().'/public/surat_balasan/', 0777, true);
                if ($result){
                    $destination_path = getcwd().'/public/surat_balasan/';
                }
            } else {
                $destination_path = getcwd().'/public/surat_balasan/';
            }
            $attachment->move($destination_path,$filename);
            DB::table('pelayanan')
                ->where('kd_tiket', $kdTiket)
                ->update([
                    'desk_balasan' => $bls,
                    'lampiran_balasan' => $filename

                ]);
        }else{
            DB::table('pelayanan')
                ->where('kd_tiket', $kdTiket)
                ->update([
                    'desk_balasan' => $bls
                ]);
        }

         return redirect()->route('insiden_user.index')->with('success', 'Insiden Telah '.$kdTiket.' sudah dibalas!');

    }

    
}