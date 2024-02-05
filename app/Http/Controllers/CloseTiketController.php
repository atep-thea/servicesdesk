<?php



namespace App\Http\Controllers;



use App\Organisasi;

use App\User;

use App\Pelayanan;

use App\ReffSjnsPelayanan;

use App\Event;

use Illuminate\Http\Request;

use Excel;

use Auth;

use Datatables;

use Image;

use File;

use Validator;

use Storage;





class CloseTiketController extends Controller

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
        return view('userportal.close.index');

    }



    public function closeData()

    {

        $userId = Auth::user()->id;

        $idTeam = Auth::user()->id_team;

        $roleUser = Auth::user()->role_user;

        if($roleUser == 'Helpdesk'){  //Heldesk

            $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 

                    'pelayanan.id_opd')

                ->leftjoin('users','users.id', '=','pelayanan.id_agen')

                

                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 

                'pelayanan.jns_pelayanan')


                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID')

                ->where('pelayanan.status','=','close')

                ->where('pelayanan.id_team','=',$idTeam)

                ->get();

        }else if($roleUser == 'User'){  //USER

            $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 

                    'pelayanan.id_opd')

                ->leftjoin('users','users.id', '=','pelayanan.id_agen')

                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 

                'pelayanan.jns_pelayanan')

                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID')

                ->where('pelayanan.status','=','close')

                ->where('pelayanan.id_pelapor','=',$userId)

                ->get();

        }else{

            $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 

                    'pelayanan.id_opd')

                ->leftjoin('users','users.id', '=','pelayanan.id_agen')

                

                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 

                'pelayanan.jns_pelayanan')

                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID')

                ->where('pelayanan.status','=','close')

                ->get();

        }

        



        return Datatables::of($query)

                            ->editColumn('kode_tiket', function($item) {

                                $temp = "<a href='#' style='background:none;border:none; color:#3b8dca;' 

                                        data-idtiket='".$item->id_."'

                                        data-kdtiket2='".$item->kd_tiket."'

                                        data-judul2='".$item->judul."' 

                                        data-sts2='".$item->status_tiket."'

                                        data-desk2='".$item->desk."'

                                        data-opd2='".$item->nama_opd."'

                                        data-tgl_dft2='".$item->tgl_pelaporan."'

                                        data-tgl_upd2='".$item->tgl_update."'

                                        data-opd2='".$item->nama_opd."'

                                        data-tp2='".$item->tp."'

                                        data-plynn2='".$item->plynn."'

                                        data-sjns2='".$item->sjns."'

                                        data-urgen2='".$item->urgen."'

                                        data-nm_dpn2='".$item->nama_agen."'

                                        data-nm_blkg2='".$item->nama_belakang."'

                                        data-solusi2='".$item->solusi."'

                                        class='' data-toggle='modal' data-target='#closeDetail'>".$item->kode_tiket."</a>";

                                return $temp;

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

        // $organisasi = Pelayanan::find($id);



        // if (!$organisasi) return view('errors.404');



        // $validator = Validator::make($request->all(), [

        //     'nama_opd' => 'required',

        //     'status' => 'required',

        // ]);



        // if ($validator->fails()) {

        //     return redirect()->back()

        //             ->withErrors($validator)

        //             ->withInput();

        // }

        

        // // Upload feature photo



        // // end of upload feature photo

        // $organisasi->nama_opd = $request->input('nama_opd');

        // $organisasi->induk_organisasi = $request->input('induk_organisasi');

        // $organisasi->nama_opd = $request->input('nama_opd');

        // $organisasi->nama_pengelola = $request->input('nama_pengelola');

        // $organisasi->no_hp_pengelola = $request->input('no_hp_pengelola');

        // $organisasi->email = $request->input('email');

        // $organisasi->status = $request->input('status');

        // $organisasi->save();



        // return redirect()->route('request_done.index')->with('success', 'request_done "'.$request->input('nama_opd').'" berhasil dirubah!');

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