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


class PermintaanBaruController extends Controller
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
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') return view('vendor.adminlte.errors.404');
        return view('admin.newpermintaan.index');
    }

    public function newrequestData()
    {
        
            //var_dump($roleUser);exit();
            $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->leftjoin('users','users.id', '=','pelayanan.id_agen')
                    ->select('pelayanan.id_','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.id_pelapor', 'pelayanan.tgl_pelaporan','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen')
                    ->orderBy('pelayanan.tgl_pelaporan','desc')
                    ->limit(8)
                    ->get();

            return Datatables::of($query)

            ->addColumn('action', function($item) {
                $roleUser = Auth::user()->role_user;
                if($roleUser == 'Admin'){
                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                    <a href=".route('new-request.edit', $item->id_)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                    $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                    <a href='#delete' data-delete-url=".route('new-request.destroy', $item->id_)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                }else{
                    $temp = "";
                }
                return $temp;
            })
            ->editColumn('kd_tiket', function($item) {
                return "<a href='".route('new-request.show', $item->id_)."'>".$item->kd_tiket."</a>";
            })
            ->editColumn('status_tiket', function($item) {
                if($item->status_tiket == 'Selesai'){
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
            })
            ->make(true);
        
    }


    public function create()
    {
        $org = Organisasi::all();
        $Agen = DB::table('users')
                    ->where('role_user','=','Helpdesk')
                    ->where('role_user','!=','Admin')
                    ->get();
        $JnsPlynn = ReffJnsPelayanan::all();
        $SjnsPlynn = ReffSjnsPelayanan::all();
        $TipePermin = ReffTipePermintaan::all();
        $Urgensi = ReffUrgensi::all();
        $Team = Team::all();

        return view('admin.newpermintaan.create',compact('org','JnsPlynn','SjnsPlynn','TipePermin','Urgensi','Agen','Team'));
    }

    public function getSubjns($id){
        $sub_jns_pelayanan = DB::table('reff_sjns_pelayanan')->where("id_pelayanan",$id)->pluck("jenis_pelayanan","id_sjns_pelayanan");

        return json_encode($sub_jns_pelayanan);
    }

    public function getSsjns($id){
        $ssjns = DB::table('reff_ssjns_pelayanan')->where("id_sjns",$id)->pluck("ssjns","id_ssjns");

        return json_encode($ssjns);
    }

    public function getAgen($id){

        $agen_id = DB::table('users')
                    ->where("id_team",$id)
                    ->where('role_user','!=','Admin')
                    ->pluck("nama_depan","id");

        return json_encode($agen_id);
    }

    public function prosesTiket($id){

        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        $diproses = Pelayanan::find($id);
        $diproses->tgl_update = $tgl_update;
        $diproses->status = 'Diproses';

        $emailUser = User::where('id','=',$diproses->id_pelapor)->first();
        // dd($diproses->id_pelapor);exit();
        $org = Organisasi::where('id_organisasi','=',$emailUser->id_organisasi)->first();
        //dd($org->nama_opd);exit();
        $subject = 'Pemberitahuan Progress Servicedesk';
        $email = array($emailUser->email);
        $judul = $diproses->judul;
        $keterangan = $diproses->deskripsi;
        $tiketKode = $diproses->kd_tiket;
        // $mailhelpdesk =  array('dwiyanti.nisa@gmail.com','dian.ciamis5@gmail.com','syaiful.muflih95@gmail.com','taufikrahadina10@gmail.com','dandimiqbal@gmail.com','erigarna@gmail.com','agen.grab95@gmail.com','muhamadnurgasikemal@gmail.com');

        $data = array('email' => $email, 
                       'subject' => 'Pemberitahuan Progress Servicedesk', 
                       'judul' => $judul,
                       'keterangan' => $keterangan,
                       'tiketKode' => $tiketKode,
                       'status' => 'Diproses',
                       'org' => $org->nama_opd,
                       'code' => 'user',
                       'catatan' => $diproses->solusi );
        
        Mail::send('email.notifStatus', $data, function ($message) use ($data) {
            $message->subject($data['subject']);
            $message->to($data['email']);
            $message->replyTo('servicedesk@jabarprov.go.id');
        });

        $diproses->save();

        return redirect('new-request/'.$id)->with('success', 'Status Tiket Sedang Diproses!');
    }


     public function getSla($id)
    {
        $data['pelayanan'] = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                    ->select('pelayanan.id_','pelayanan.tgl_kirim_sla','pelayanan.file_sla','pelayanan.kd_tiket','pelayanan.judul','organisasi.nama_opd as opd')
                    ->find($id);

        if (!$data['pelayanan']) return view('errors.404');
        return view('admin.newpermintaan.sla', $data);
    }


    public function updateSla(Request $request)
    {
        $id = $request->id_;
        $sla = Pelayanan::find($id);
        $sla->tgl_kirim_sla = $request->tgl_kirim_sla;

        if ($request->hasFile('file_sla')) {
            $attachment2 = $request->file('file_sla');
            $extension2 = $attachment2->getClientOriginalExtension();
            $attachment_real_path2 = $attachment2->getRealPath();
            $filename2 = str_random(5).date('Ymdhis').'.'.$extension2;

            if (!File::exists(getcwd().'/public/SLA/')) {
                $result2 = File::makeDirectory(getcwd().'/public/SLA/', 0777, true);
                if ($result2){
                    $destination_path2 = getcwd().'/public/SLA/';
                }
            } else {
                $destination_path2 = getcwd().'/public/SLA/';
            }

            $attachment2->move($destination_path2,$filename2);
            $sla->file_sla = $filename2;
        }

        $sla->save();

        return redirect()->route('new-request.index')->with('success', 'Surat SLA telah disimpan !');
    }

     public function downloadSla(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('SLA').'\\'.$data->file_sla;
        return response()->download($file_path);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {

        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_pelaporan = date('Y-m-d H:i:s');

        $inputJns = $request->input('jns_pelayanan');
        if($inputJns == 1){
            $cek = Pelayanan::where('jns_pelayanan','=','1')->get();
            $cek->isEmpty();
            if($cek->isEmpty()){
                $kdTiket = 'L-00010';
            }else{
                $lastInsert = Pelayanan::where('jns_pelayanan','=','1')->latest('id_')->first();
                
                $split = $lastInsert['kd_tiket'];
                $lastId = substr($split,5)+1;
                $firstId = 'L-000';
                $kdTiket = $firstId.$lastId;
                //dd($firstId.$lastId);exit();
            }
        }elseif($inputJns == 2){
            $cek = Pelayanan::where('jns_pelayanan','=','2')->get();
            $cek->isEmpty();
            if($cek->isEmpty()){
                $kdTiket = 'P-00010';
            }else{
                $lastInsert = Pelayanan::where('jns_pelayanan','=','2')->latest('id_')->first();
                
                $split = $lastInsert['kd_tiket'];
                $lastId = substr($split,5)+1;
                $firstId = 'P-000';
                $kdTiket = $firstId.$lastId;
                //dd($firstId.$lastId);exit();
            }

            // SEND TO RULLY EMAIL 
            $judul3 = $request->input('judul');
            $subject3 = 'Pemberitahuan Servicedesk';
            $subject3 = 'Tiket Baru Telah Dibuat';
            $keterangan3 = $request->input('deskripsi');
            $orgName3 = $org->nama_opd;
            $direksiMail3 =  array('eos.diskominfojabar@gmail.com');

            $data3 = array('email' => $direksiMail3, 
                       'subject' => $subject3, 
                       'judul' => $judul3,
                       'keterangan' => $keterangan3,
                       'kdTiket' => $kdTiket);

            Mail::send('email.notifDireksi', $data3, function ($message) use ($data3) {
                $message->subject($data3['subject']);
                $message->to($data3['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });
        }
        elseif($inputJns == 3){
            $cek = Pelayanan::where('jns_pelayanan','=','3')->get();
            $cek->isEmpty();
            if($cek->isEmpty()){
                $kdTiket = 'I-00010';
            }else{
                $lastInsert = Pelayanan::where('jns_pelayanan','=','3')->latest('id_')->first();
                
                $split = $lastInsert['kd_tiket'];
                $lastId = substr($split,5)+1;
                $firstId = 'I-000';
                $kdTiket = $firstId.$lastId;
            }
        }elseif($inputJns == 4) {
            $cek = Pelayanan::where('jns_pelayanan','=','4')->get();
            $cek->isEmpty();
            if($cek->isEmpty()){
                $kdTiket = 'A-00010';
            }else{
                $lastInsert = Pelayanan::where('jns_pelayanan','=','4')->latest('id_')->first();
                
                $split = $lastInsert['kd_tiket'];
                $lastId = substr($split,5)+1;
                $firstId = 'A-000';
                $kdTiket = $firstId.$lastId;
            }
        }elseif($inputJns == 5) {
            $cek = Pelayanan::where('jns_pelayanan','=','5')->get();
            $cek->isEmpty();
            if($cek->isEmpty()){
                $kdTiket = 'K-00010';
            }else{
                $lastInsert = Pelayanan::where('jns_pelayanan','=','5')->latest('id_')->first();
                
                $split = $lastInsert['kd_tiket'];
                $lastId = substr($split,5)+1;
                $firstId = 'K-000';
                $kdTiket = $firstId.$lastId;
            }
        }

        // GET PELAPOR DARI ORGANISASI
        $idOpd = $request->input('id_opd'); //if id opd Null Alert harus ada usernya
        $selectOrg = Organisasi::where('id_organisasi','=',$idOpd)->first();
        $emailPelapor = User::where('id_organisasi','=',$idOpd)->limit(1)->first();
        $idPelapor = $emailPelapor->id;
        // dd($emailPelapor->id);exit();

        // End Attachment 
        $plynn = new Pelayanan;
        $plynn->kd_tiket = $kdTiket;
        $plynn->id_opd = $request->input('id_opd');
        $plynn->judul = $request->input('judul');
        $plynn->deskripsi = $request->input('deskripsi');
        // $plynn->tipe_permintaan = $request->input('tipe_permintaan');
        $plynn->jns_pelayanan = $request->input('jns_pelayanan');
        // $plynn->sub_jns_pelayanan = $request->input('sub_jns_pelayanan');
        $plynn->ssub_jns_pelayanan = $request->input('ssjns');
        $plynn->tgl_pelaporan =$tgl_pelaporan;
        $plynn->tgl_update = $tgl_pelaporan;
        // $plynn->urgensi =$request->input('urgensi');
        // $plynn->id_team =$request->input('id_team');
        $plynn->id_agen =$request->input('agen_id');
        $plynn->status = 'Baru';
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

        $judul = $request->input('judul');
        $keterangan = $request->input('deskripsi');
        //$tiketKode = $kdTiket;
        $cc =  array('dwiyanti.nisa@gmail.com','dinadwo@gmail.com','dian.ciamis5@gmail.com','syaiful.muflih95@gmail.com',
        'taufikrahadina10@gmail.com','dandimiqbal@gmail.com','erigarna@gmail.com','agen.grab95@gmail.com',
        'muhamadnurgasikemal@gmail.com');
            
        $data = array('email' => 'servicedesk@jabarprov.go.id', 
                       'subject' => 'Pemberitahuan Tiket Baru Servicedesk', 
                       'judul' => $judul,
                       'keterangan' => $keterangan,
                       'kdTiket' => $kdTiket );
        
        Mail::send('email.notifDireksi', $data, function ($message) use ($data, $cc) {
            $message->subject($data['subject']);
            $message->to($data['email']);
            $message->cc($cc);
            $message->replyTo('servicedesk@jabarprov.go.id');
        });

        return redirect()->route('new-request.index')->with('success', 'Pembuatan Tiket Berhasil"'.$request->input('nama_perangkat').'" berhasil ditambahkan!');
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
                    ->leftjoin('users','users.id', '=', 
                    'pelayanan.id_agen')
                    ->leftjoin('team','team.id_team', '=', 
                    'pelayanan.id_team')
                    ->select('pelayanan.id_','pelayanan.id_opd','organisasi.nama_opd',
                    'pelayanan.kd_tiket','pelayanan.judul','pelayanan.id_pelapor','pelayanan.deskripsi',
                    'pelayanan.tgl_pelaporan','pelayanan.tgl_update','pelayanan.solusi','users.nama_depan as nama_agen',
                    'users.nama_belakang','pelayanan.status as status_tiket','pelayanan.id_agen','pelayanan.lampiran','team.id_team')
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
        return view('admin.newpermintaan.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //var_dump('edit pelayanan');exit();
        $pelayanan = Pelayanan::leftjoin('users','users.id', '=', 
                    'pelayanan.id_agen')
                    ->select('pelayanan.*','users.nama_depan as nmdepan','users.nama_belakang as nmbelakang')
                    ->where('id_','=',$id)
                    ->first();
        $org = Organisasi::all();
        $Agen = DB::table('users')
                    ->where('role_user','=','Helpdesk')
                    ->where('role_user','!=','Admin')
                    ->get();
        $JnsPlynn = ReffJnsPelayanan::all();
        $SjnsPlynn = ReffSjnsPelayanan::all();
        $TipePermin = ReffTipePermintaan::all();
        $Urgensi = ReffUrgensi::all();
        $Ssjns = Subsubkategori::all();
        $Team = Team::all();
        if (!$pelayanan) return view('errors.404');

        return view('admin.newpermintaan.edit', compact('pelayanan','Team','org','Agen','JnsPlynn','SjnsPlynn','TipePermin','Urgensi','Ssjns'));
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
        $statusTiket = $request->statustiket;
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        // === SAVE DATA === //
        $pelayanan = Pelayanan::find($id);
        if (!$pelayanan) return view('errors.404');
        $pelayanan->id_opd = $request->input('id_opd');
        $pelayanan->judul = $request->input('judul');
        $pelayanan->deskripsi = $request->input('deskripsi');
        $pelayanan->tipe_permintaan = $request->input('tipe_permintaan');
        $pelayanan->jns_pelayanan = $request->input('jns_pelayanan');
        $pelayanan->sub_jns_pelayanan = $request->input('sub_jns_pelayanan');
        $pelayanan->tgl_update = $tgl_update;
        $pelayanan->urgensi =$request->input('urgensi');
        $pelayanan->solusi =$request->input('solusi');
        $pelayanan->id_agen =$request->input('agen_id');
        $pelayanan->id_team =$request->input('id_team');

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
            $pelayanan->lampiran = $filename;
        }

        if($statusTiket == 'Selesai') {
            $pelayanan->status = $statusTiket;

            // SEND EMAIL
            $emailUser = User::where('id','=',$pelayanan->id_pelapor)->first();
            $org = Organisasi::where('id_organisasi','=',$emailUser->id_organisasi)->first();
            $subject = 'Pemberitahuan Progress Servicedesk';
            $email = $emailUser->email; 
            $judul = $pelayanan->judul;
            $keterangan = $pelayanan->deskripsi;
            $tiketKode = $pelayanan->kd_tiket;
            $mailhelpdesk =  array('dwiyanti.nisa@gmail.com','dian.ciamis5@gmail.com','syaiful.muflih95@gmail.com','taufikrahadina10@gmail.com','dandimiqbal@gmail.com','erigarna@gmail.com','agen.grab95@gmail.com','muhamadnurgasikemal@gmail.com');

            $data = array('email' => $emailUser->email, 
                           'subject' => 'Pemberitahuan Progress Servicedesk', 
                           'judul' => $judul,
                           'keterangan' => $keterangan,
                           'tiketKode' => $tiketKode,
                           'status' => 'Selesai',
                           'org' => $org->nama_opd,
                           'code' => 'user',
                           'catatan' => $pelayanan->solusi );
            
            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $data2 = array('email' => $mailhelpdesk, 
                           'subject' => 'Pemberitahuan Progress Servicedesk', 
                           'judul' => $judul,
                           'keterangan' => $keterangan,
                           'tiketKode' => $tiketKode,
                           'status' => 'Selesai',
                           'code'   => 'helpdesk',
                           'org' => $org->nama_opd,
                           'catatan' => $pelayanan->solusi );
            
            Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
                $message->subject($data2['subject']);
                $message->to($data2['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });
           $pelayanan->save();

            return redirect()->route('new-request.index')->with('success', 'Status pelayanan berubah menjadi "Selesai"');
        }else if($statusTiket == 'Pending'){
            $pelayanan->status = $statusTiket;

            // SEND EMAIL
            $emailUser = User::where('id','=',$pelayanan->id_pelapor)->first();
            $org = Organisasi::where('id_organisasi','=',$emailUser->id_organisasi)->first();
            $subject = 'Pemberitahuan Progress Servicedesk';
            $email = $emailUser->email; 
            $judul = $pelayanan->judul;
            $keterangan = $pelayanan->deskripsi;
            $tiketKode = $pelayanan->kd_tiket;
            $mailhelpdesk =  array('dwiyanti.nisa@gmail.com','dian.ciamis5@gmail.com','syaiful.muflih95@gmail.com','taufikrahadina10@gmail.com','dandimiqbal@gmail.com','erigarna@gmail.com','agen.grab95@gmail.com','muhamadnurgasikemal@gmail.com');

            $data = array('email' => $emailUser->email, 
                           'subject' => 'Pemberitahuan Progress Servicedesk', 
                           'judul' => $judul,
                           'keterangan' => $keterangan,
                           'tiketKode' => $tiketKode,
                           'status' => 'Pending',
                           'org' => $org->nama_opd,
                           'code' => 'user',
                           'catatan' => $pelayanan->solusi );
            
            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $data2 = array('email' => $mailhelpdesk, 
                           'subject' => 'Pemberitahuan Progress Servicedesk', 
                           'judul' => $judul,
                           'keterangan' => $keterangan,
                           'tiketKode' => $tiketKode,
                           'status' => 'Pending',
                           'code'   => 'helpdesk',
                           'org' => $org->nama_opd,
                           'catatan' => $pelayanan->solusi );
            
            Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
                $message->subject($data2['subject']);
                $message->to($data2['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });
            $pelayanan->save();

            return redirect()->route('new-request.index')->with('success', 'Status pelayanan berubah menjadi "Pending"');
        }else if($statusTiket == 'Close'){
            $pelayanan->status = $statusTiket;
            $pelayanan->save();


            // SEND EMAIL
            // $emailUser = User::where('id','=',$pelayanan->id_pelapor)->first();
            // $org = Organisasi::where('id_organisasi','=',$emailUser->id_organisasi)->first();
            // $subject = 'Pemberitahuan Progress Servicedesk';
            // $email = $emailUser->email; 
            // $judul = $pelayanan->judul;
            // $keterangan = $pelayanan->deskripsi;
            // $tiketKode = $pelayanan->kd_tiket;
            // $mailhelpdesk =  array('dwiyanti.nisa@gmail.com','dian.ciamis5@gmail.com','syaiful.muflih95@gmail.com','taufikrahadina10@gmail.com','dandimiqbal@gmail.com','erigarna@gmail.com','agen.grab95@gmail.com','muhamadnurgasikemal@gmail.com');

            // $data = array('email' => $emailUser->email, 
            //                'subject' => 'Pemberitahuan Progress Servicedesk', 
            //                'judul' => $judul,
            //                'keterangan' => $keterangan,
            //                'tiketKode' => $tiketKode,
            //                'status' => 'Close',
            //                'org' => $org->nama_opd,
            //                'code' => 'user',
            //                'catatan' => $pelayanan->catatan_khusus );
            
            // Mail::send('email.notifStatus', $data, function ($message) use ($data) {
            //     $message->subject($data['subject']);
            //     $message->to($data['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });

            // $data2 = array('email' => $mailhelpdesk, 
            //                'subject' => 'Pemberitahuan Progress Servicedesk', 
            //                'judul' => $judul,
            //                'keterangan' => $keterangan,
            //                'tiketKode' => $tiketKode,
            //                'status' => 'Close',
            //                'code'   => 'helpdesk',
            //                'org' => $org->nama_opd,
            //                'catatan' => $pelayanan->catatan_khusus );
            
            // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            //     $message->subject($data2['subject']);
            //     $message->to($data2['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });
            
            return redirect()->route('new-request.index')->with('success', 'Tiket Berhasil diclose');
        }else if($statusTiket == 'Re-open'){
            $pelayanan->status = $statusTiket;
            $pelayanan->save();

            return redirect()->route('new-request.index')->with('success', 'Status pelayanan berubah menjadi "Re-open"');
        }
         
    }

    
    public function destroy($id)
    {
        $pelayanan = Pelayanan::find($id);

        if (!$pelayanan) return view('errors.404');

        $pelayanan_name = $pelayanan->nama_perangkat;

        $pelayanan->delete();

        return redirect()->route('new-request.index')->with('success', 'Data pelayanan telah dihapus!');

    }
}