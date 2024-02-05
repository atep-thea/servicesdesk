<?php

namespace App\Http\Controllers;

use App\Pelayanan;
use App\Organisasi;
use App\User;
use App\ReffJnsPelayanan;
use App\ReffSjnsPelayanan;
use App\ReffTipePermintaan;
use App\ReffUrgensi;
use App\Subsubkategori;
use App\Team;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;
use Mail;

class ReportInsidenController extends Controller
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

        return view('admin.insiden.index');
    }

    public function insidenData()
    {
        $userId = Auth::user()->id;
        $role = Auth::user()->role_user;
        if($role == 'Admin'){
        	  $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->leftjoin('users','users.id', '=','pelayanan.id_agen')
                    ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=','pelayanan.urgensi')
                    ->select('pelayanan.id_ as ids','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.jns_pelayanan','pelayanan.jns_insiden','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_urgensi.def_urgensi as urgensi','pelayanan.lampiran_balasan','pelayanan.desk_balasan')
                    ->where('pelayanan.jns_pelayanan','=',6)
                    ->orderBy('ids','DESC')
                    ->get();
        }else{
        	  $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->leftjoin('users','users.id', '=','pelayanan.id_agen')
                    ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=','pelayanan.urgensi')
                    ->select('pelayanan.id_ as ids','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.jns_pelayanan','pelayanan.jns_insiden','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_urgensi.def_urgensi as urgensi','pelayanan.lampiran_balasan','pelayanan.desk_balasan')
                    ->where('pelayanan.jns_pelayanan','=',6)
                    ->where('pelayanan.id_pelapor',$userId)
                    ->orderBy('ids','DESC')
                    ->get();
        }
      

        //dd($query);exit();
        return Datatables::of($query)
                    ->addColumn('action', function($item) {
                        $roleUser = Auth::user()->role_user;
                        if($roleUser == 'Admin'){
                            $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                            <a href=".route('report_insiden.edit', $item->ids)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                            $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                            <a href='#delete' data-delete-url=".route('report_insiden.destroy', $item->ids)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                        }else{
                            $temp = "";
                        }
                        return $temp;
                    })
                    ->editColumn('kd_tiket', function($item) {
                        return "<a href='".route('report_insiden.show', $item->ids)."'>".$item->kd_tiket."</a>";
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
                        }elseif($item->status_tiket == 'Replied'){
                            $span = '<h5><span class="label label-primary" style="background-color:#21BA45;padding:3px 13px;">';
                            return $span.$item->status_tiket.'</span></h5>';
                        }
                        //return $span.$item->status_tiket.'</span></h5>';
                    })
                    ->make(true);
    }


    public function create()
    {
        $org = Organisasi::all();
        $Urgensi = ReffUrgensi::all();
        return view('admin.insiden.create',compact('org','Urgensi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($request->jns_insiden);exit();
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_pelaporan = date('Y-m-d H:i:s');

        $cek = Pelayanan::where('jns_pelayanan','=','6')->get();
        $cek->isEmpty();
        if($cek->isEmpty()){
            $kdTiket = 'LI-00010';
        }else{
            $lastInsert = Pelayanan::where('jns_pelayanan','=','6')->latest('id_')->first();
            $split = $lastInsert['kd_tiket'];
            $lastId = substr($split,5)+1;
            $firstId = 'LI-000';
            $kdTiket = $firstId.$lastId;
        }

        // GET ORGANISASI
        $idOpd = $request->input('id_opd'); //if id opd Null Alert harus ada usernya
        $selectOrg = Organisasi::where('id_organisasi','=',$idOpd)->first();
        $nmOpd =$selectOrg['nama_opd'];

        // GET EMAIL
        $getUser = User::where('id_organisasi','=',$idOpd)->limit(1)->first();

        if(empty($getUser)){
             return redirect()->route('report_insiden.index')->with('warning', 'Email User Belum Terdaftar, Silahkan buat email user yang dituju Terlebih dulu !!');   
        }else{

            $idPelapor = $getUser->id;
            $emailOpd = $getUser->email;

            // End Attachment 
            $plynn = new Pelayanan;
            $plynn->kd_tiket = $kdTiket;
            $plynn->id_opd = $request->input('id_opd');
            $plynn->judul = $request->input('judul');
            $plynn->deskripsi = $request->input('deskripsi');
            $plynn->jns_insiden = $request->input('jns_insiden');
            $plynn->jns_pelayanan = 6;
            $plynn->tgl_pelaporan =$tgl_pelaporan;
            $plynn->tgl_update = $tgl_pelaporan;
            $plynn->tipe_permintaan =3;
            $plynn->urgensi =$request->input('urgensi');
            $plynn->status = 'Sent';
            $plynn->id_pelapor = $idPelapor;

            // Attach File
            if ($request->hasFile('lampiran')) {
                $attachment = $request->file('lampiran');
                $extension = $attachment->getClientOriginalExtension();
                $attachment_real_path = $attachment->getRealPath();
                $filename = str_random(5).date('Ymdhis').'.'.$extension;

                if (!File::exists(getcwd().'/public/images/lampiran/')) {
                    $result = File::makeDirectory(getcwd().'/public/images/lampiran/', 0777, true);
                    if ($result){
                        $destination_path = getcwd().'/public/images/lampiran/';
                    }
                } else {
                    $destination_path = getcwd().'/public/images/lampiran/';
                }

                // $img = so::make($attachment_real_path);
                // $img->save($destination_path.$filename);
                $attachment->move($destination_path,$filename);
                $plynn->lampiran = $filename;
            }

            $plynn->save();
           

            // SEND EMAIL WITH FILE
            $tiketKode = $kdTiket;
            $judul = $request->input('judul');
            $keterangan = $request->input('deskripsi');
            $jnsIns = $request->input('jns_insiden');
            //dd($emailOpd);exit();

            if($jnsIns == 1){
                $jnsInsiden = 'Assesment';
            }elseif($jnsIns == 2){
                $jnsInsiden = 'Insiden Report';
            }elseif($jnsIns == 3){
                $jnsInsiden = 'Laporan Vurnability';
            }
            // $data = array('email' => $emailOpd, 
            //                'subject' => 'Pemberitahuan Tiket Baru Servicedesk', 
            //                'judul' => $judul,
            //                'opd' => $nmOpd,
            //                'jns_insiden' => $jnsInsiden,
            //                'keterangan' => $keterangan,
            //                'kdTiket' => $tiketKode );
            
            // Mail::send('email.notifInsiden', $data, function ($message) use ($data) {
            //     $message->subject($data['subject']);
            //     $message->to($data['email']);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });

           
            return redirect()->route('report_insiden.index')->with('success', 'Laporan Insiden Telah dikirim !!');
        }


        
       
    }


    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pelayanan'] = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 
                    'pelayanan.jns_pelayanan')
                    ->leftjoin('reff_sjns_pelayanan','reff_sjns_pelayanan.id_sjns_pelayanan', '=', 
                    'pelayanan.sub_jns_pelayanan')
                    ->leftjoin('reff_tipe_permintaan','reff_tipe_permintaan.id_tipe', '=', 
                    'pelayanan.tipe_permintaan')
                    ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 
                    'pelayanan.urgensi')
                    ->leftjoin('users','users.id', '=', 
                    'pelayanan.id_agen')
                    ->leftjoin('team','team.id_team', '=', 
                    'pelayanan.id_team')
                    ->select('reff_jns_pelayanan.*','reff_sjns_pelayanan.*','reff_tipe_permintaan.*','reff_urgensi.*','pelayanan.id_','pelayanan.id_opd','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.id_pelapor','pelayanan.deskripsi','pelayanan.tgl_pelaporan','pelayanan.tgl_update','pelayanan.solusi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen','pelayanan.lampiran','pelayanan.jns_insiden','pelayanan.desk_balasan','team.id_team','pelayanan.lampiran_balasan')
                    ->find($id);
        $data['pelapor'] = User::select('users.id','users.nama_depan as user_nmdepan','users.nama_belakang as user_nmbelakang')
                                 ->where('id','=',$data['pelayanan']['id_pelapor'])
                                 ->first($id);
        //var_dump($data['pelayanan']['id_pelapor']);exit();
        $data['org'] = Organisasi::all();
        $data['Agen'] = DB::table('users')->where('role_user','=','Helpdesk')->get();
        $data['JnsPlynn'] = ReffJnsPelayanan::all();
        $data['SjnsPlynn'] = ReffSjnsPelayanan::all();
        $data['TipePermin'] = ReffTipePermintaan::all();
        $data['Urgensi'] = ReffUrgensi::all();
        if (!$data['pelayanan']) return view('errors.404');
        return view('admin.insiden.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelayanan = Pelayanan::leftjoin('users','users.id', '=', 
                    'pelayanan.id_agen')
                    ->select('pelayanan.*','users.nama_depan as nmdepan','users.nama_belakang as nmbelakang')
                    ->where('id_','=',$id)
                    ->first();

        $org = Organisasi::all();
        $Urgensi = ReffUrgensi::all();
        if (!$pelayanan) return view('errors.404');
        return view('admin.insiden.edit', compact('pelayanan','org','Urgensi'));
    }

    public function downloadfile(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('images/lampiran').'/'.$data->lampiran;
        return response()->download($file_path);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        // End Attachment 
        $plynn = Pelayanan::find($id);
        $plynn->id_opd = $request->input('id_opd');
        $plynn->judul = $request->input('judul');
        $plynn->deskripsi = $request->input('deskripsi');
        $plynn->jns_insiden = $request->input('jns_insiden');
        $plynn->tgl_update = $tgl_update;
        $plynn->urgensi =$request->input('urgensi');

        // Attach File
         if ($request->hasFile('lampiran')) {
            $attachment = $request->file('lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $filename = str_random(5).date('Ymdhis').'.'.$extension;

            if (!File::exists(getcwd().'/public/images/lampiran/')) {
                $result = File::makeDirectory(getcwd().'/public/images/lampiran/', 0777, true);
                if ($result){
                    $destination_path = getcwd().'/public/images/lampiran/';
                }
            } else {
                $destination_path = getcwd().'/public/images/lampiran/';
            }
            $attachment->move($destination_path,$filename);
            $plynn->lampiran = $filename;
        }
        
        $plynn->save();

        return redirect()->route('report_insiden.index')->with('success', 'Laporan Insiden Telah Diperbarui !!');
    }

    public function downloadSla(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('SLA').'\\'.$data->file_sla;
        return response()->download($file_path);
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelayanan = Pelayanan::find($id);

        if (!$pelayanan) return view('errors.404');

        $pelayanan->delete();

        return redirect()->route('report_insiden.index')->with('success', 'Data Insiden telah dihapus!');

    }
}