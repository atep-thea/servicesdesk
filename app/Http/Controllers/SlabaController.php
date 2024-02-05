<?php

namespace App\Http\Controllers;
use App\Organisasi;
use App\User;
use App\Pelayanan;
use App\ReffSjnsPelayanan;
use App\Event;
use Illuminate\Http\Request;
use DB;
use Excel;
use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;

class SlabaController extends Controller

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
        return view('userportal.slaba.index');
    }


    public function slabaData()
    {
        $userId = Auth::user()->id;
        $idTeam = Auth::user()->id_team;
        $roleUser = Auth::user()->role_user;
        $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                    'pelayanan.id_opd')
                ->leftjoin('users','users.id', '=','pelayanan.id_agen')
              
                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 
                'pelayanan.jns_pelayanan')
               
                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id',
                         'reff_jns_pelayanan.pelayanan as plynn',
                         'organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor',
                         'pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen',
                         'users.nama_belakang','pelayanan.id_opd','pelayanan.deskripsi as desk',
                         'pelayanan.status as status_tiket','pelayanan.id_agen as agenID','pelayanan.file_sla','pelayanan.file_ba')
                ->where('pelayanan.status','=','selesai')
                ->where('pelayanan.id_pelapor','=',$userId)
                ->where('pelayanan.file_ba','!=', null)
                ->orderBy('pelayanan.tgl_pelaporan', 'DESC')
                ->get();

        return Datatables::of($query)
             ->editColumn('kode_tiket', function($item) {
                return "<a href='".route('request_progress.show', $item->id_)."'>".$item->kode_tiket."</a>";
            })

            // ->editColumn('file_sla', function($item) {

            //     if($item->file_sla != null){
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Send</span></h5>';
            //     }elseif($item->sla_bls != null){
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Replied</span></h5>';
            //     }else{
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Not Found</span></h5>';
            //     }

            // })
            // ->editColumn('file_ba', function($item) {
            //     if($item->file_ba != null and $item->ba_bls == null){
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Send</span></h5>';
            //     }elseif($item->file_ba != null and $item->ba_bls != null){
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Replied</span></h5>';
            //     }else{
            //         $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
            //         return 'Not Found</span></h5>';
            //     }

            // })
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
                //return $span.$item->status_tiket.'</span></h5>';
            })
            ->make(true);

    }



    public function reOpen(Request $request)
    { 
        $id = $request->input('idtiket');
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');
        Pelayanan::find($id)
            ->update([
                'tgl_update' => $tgl_update,
                'status' => 'Close'
            ]);


        return back()->with('success', 'Status Tiket Berhasil dirubah menjadi Close..!!');

    }



    public function create()

    {

       

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

       

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $data['slaba'] = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 
                                'pelayanan.id_opd')
                            ->leftjoin('users','users.id', '=','pelayanan.id_agen')
                            // ->leftjoin('reff_tipe_permintaan','reff_tipe_permintaan.id_tipe', '=','pelayanan.tipe_permintaan')
                            ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 
                            'pelayanan.jns_pelayanan')
                            // ->leftjoin('reff_sjns_pelayanan','reff_sjns_pelayanan.id_sjns_pelayanan', '=', 
                            // 'pelayanan.sub_jns_pelayanan')
                            ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 
                            'pelayanan.urgensi')
                            ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id',
                            'reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','organisasi.nama_opd','pelayanan.kd_tiket',
                            'pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi',
                            'users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk',
                            'pelayanan.status as status_tiket','pelayanan.id_agen as agenID','pelayanan.file_sla','pelayanan.file_ba',
                            'pelayanan.sla_bls','pelayanan.ba_bls','pelayanan.komen_slaba','pelayanan.jwb_komen_slaba','pelayanan.lampiran_balasan')
                            ->where('pelayanan.id_','=',$id)
                            ->first();
        //dd($data['slaba']);exit();

        if (!$data['slaba']) return view('errors.404');

        return view('userportal.slaba.show', $data);
       

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {


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

        $slaba = Pelayanan::find($id);
         // Attach File
        if ($request->hasFile('sla_bls')) {
            $attachment = $request->file('sla_bls');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $filename = str_random(5).date('Ymdhis').'.'.$extension;

            if (!File::exists(getcwd().'/public/SLA/Balasan')) {
                $result = File::makeDirectory(getcwd().'/public/SLA/Balasan', 0777, true);
                if ($result){
                    $destination_path = getcwd().'/public/SLA/Balasan';
                }
            } else {
                $destination_path = getcwd().'/public/SLA/Balasan';
            }
            $attachment->move($destination_path,$filename);
            $slaba->sla_bls = $filename;
        }

        // ba bls
        if ($request->hasFile('ba_bls')) {
            $attachment2 = $request->file('ba_bls');
            $extension2 = $attachment2->getClientOriginalExtension();
            $attachment_real_path1 = $attachment2->getRealPath();
            $filename2 = str_random(5).date('Ymdhis').'.'.$extension2;

            if (!File::exists(getcwd().'/public/BA/Balasan')) {
                $result2 = File::makeDirectory(getcwd().'/public/BA/Balasan', 0777, true);
                if ($result2){
                    $destination_path2 = getcwd().'/public/BA/Balasan';
                }
            } else {
                $destination_path2 = getcwd().'/public/BA/Balasan';
            }
            $attachment2->move($destination_path2,$filename2);
            $slaba->ba_bls = $filename2;
        }
        $nextStage = $slaba->stage + 1;
        $slaba->stage = $nextStage;
        $slaba->survey_rate = $request->input('rating');
        $slaba->jwb_komen_slaba = $request->input('jwb_komen_slaba');
        $slaba->save();
        return redirect()->route('slaba.index')->with('success', 'SLA & Berita Acara Telah Diupdate');


    }

    public function downloadReplyBA(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('BA/Balasan').'/'.$data->ba_bls;
        return response()->download($file_path);
    }

     public function downloadReplySLA(Request $request,$id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('SLA/Balasan').'/'.$data->sla_bls;
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

       



    }

}