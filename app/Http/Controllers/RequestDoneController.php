<?php



namespace App\Http\Controllers;



use App\Organisasi;

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





class RequestDoneController extends Controller

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

        $role = Auth::user()->role_user;
        if ($role == 'Admin') return view('vendor.adminlte.errors.404');

        return view('userportal.done.index');

    }



    public function reqdoneData()

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

                ->leftjoin('reff_sjns_pelayanan','reff_sjns_pelayanan.id_sjns_pelayanan', '=', 

                'pelayanan.sub_jns_pelayanan')

                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','reff_sjns_pelayanan.jenis_pelayanan as sjns','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_sjns_pelayanan.jenis_pelayanan as sjns_def')

                ->where('pelayanan.status','=','Selesai')

                ->where('pelayanan.id_team','=',$idTeam)

                ->get();



        }else if($roleUser == 'User'){  //USER

            $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 

                    'pelayanan.id_opd')

                ->leftjoin('users','users.id', '=','pelayanan.id_agen')

      

                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 

                'pelayanan.jns_pelayanan')

                ->leftjoin('reff_sjns_pelayanan','reff_sjns_pelayanan.id_sjns_pelayanan', '=', 

                'pelayanan.sub_jns_pelayanan')

                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','reff_sjns_pelayanan.jenis_pelayanan as sjns','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_sjns_pelayanan.jenis_pelayanan as sjns_def')

                ->where('pelayanan.status','=','Selesai')

                ->where('pelayanan.id_pelapor','=',$userId)

                ->get();

        }else{

             $query = Pelayanan::leftjoin('organisasi','organisasi.id_organisasi', '=', 

                    'pelayanan.id_opd')

                ->leftjoin('users','users.id', '=','pelayanan.id_agen')

                ->leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=', 

                'pelayanan.jns_pelayanan')

                ->leftjoin('reff_sjns_pelayanan','reff_sjns_pelayanan.id_sjns_pelayanan', '=', 

                'pelayanan.sub_jns_pelayanan')

                ->leftjoin('reff_urgensi','reff_urgensi.id_urgensi', '=', 

                'pelayanan.urgensi')

                ->select('pelayanan.id_','pelayanan.kd_tiket as kode_tiket','users.id','reff_urgensi.def_urgensi as urgen','reff_jns_pelayanan.pelayanan as plynn','reff_sjns_pelayanan.jenis_pelayanan as sjns','organisasi.nama_opd','pelayanan.kd_tiket','pelayanan.judul','pelayanan.solusi','pelayanan.id_pelapor','pelayanan.tgl_pelaporan','pelayanan.tgl_update','organisasi.induk_organisasi','users.nama_depan as nama_agen','users.nama_belakang','pelayanan.id_opd','reff_urgensi.def_urgensi as priority','pelayanan.deskripsi as desk','pelayanan.status as status_tiket','pelayanan.id_agen as agenID','reff_sjns_pelayanan.jenis_pelayanan as sjns_def')

                ->where('pelayanan.status','=','Selesai')

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

                                        class='' data-toggle='modal' data-target='#reqDetail'>".$item->kode_tiket."</a>";

                                return $temp;

                            })

                            // ->editColumn('sjns_def', function($item) {

                            //     $qOrg = ReffSjnsPelayanan::where('id_sjns_pelayanan','=',$item->sub_jns_pelayanan)->first();

                            //     //var_dump($qOrg['nama_opd']);exit();

                            //     $temp = "<a href='#' 

                            //             data-nm_org='".$qOrg['nama_opd']."'

                            //             data-induk_org='".$qOrg['induk_organisasi']."'

                            //             data-nm_peng='".$qOrg['nama_pengelola']."'

                            //             data-hp_peng='".$qOrg['no_hp_pengelola']."'

                            //             data-email_org='".$qOrg['email']."'

                            //             class='' data-toggle='modal' data-target='#orgDetail'>".$item->sjns_def."</a>";

                            //     return $temp;

                            // })

                            ->make(true);

    }





    public function create()

    {

        $parent_org = Pelayanan::all();

        return view('admin.organisasi.create',compact('parent_org'));

    }



    public function close_tiket(Request $request){



        $id = $request->input('idtiket');

        $timezone = "Asia/Jakarta";

        date_default_timezone_set($timezone);

        $tgl_update = date('Y-m-d H:i:s');

        Pelayanan::find($id)

            ->update([

                'tgl_update' => $tgl_update,

                'status' => 'close'

            ]);



        return back()->with('success', 'Status Tiket Berhasil dirubah menjadi Close..!!');

    }



    public function importExcel(Request $request)

    {

       

        $request->validate([

            'import_file' => 'required'

        ]);

 

        $path = $request->file('import_file')->getRealPath();

        $data = Excel::load($path)->get();



        if($data->count()){

            foreach ($data as $key => $value) {

                $arr[] = ['nama_opd' => $value->nama_opd,'induk_organisasi' => $value->induk_organisasi, 'nama_pengelola' => $value->nama_pengelola,'email' => $value->email,'no_hp_pengelola' => $value->no_hp_pengelola,'status' => $value->status];

            }

 

            if(!empty($arr)){

                Pelayanan::insert($arr);

            }

        }

 

        return back()->with('success', 'Import data Excel Sukses..!!');

    }



     public function exportExcel(Request $request)

    {

        $data['title'] = 'Data Organisasi';

        $data['org'] = Pelayanan::all();

        Excel::create('Data Organisasi '.date('Y').'',function($excel) use ($data){

            $excel->sheet('Sheet 1',function($sheet) use ($data){



                $sheet->loadView('admin.organisasi.excel_view', $data);

            });

        })->export('xls');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'nama_opd' => 'required',

            'status' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                    ->withErrors($validator)

                    ->withInput();

        }



        Pelayanan::create([

            'induk_organisasi' => $request->input('induk_organisasi'),

            'nama_opd' => $request->input('nama_opd'),

            'nama_pengelola' => $request->input('nama_pengelola'),

            'no_hp_pengelola' => $request->input('no_hp_pengelola'),

            'email' => $request->input('email'),

            'status' => $request->input('status')

        ]);



        return redirect()->route('request_done.index')->with('success', 'Perngkat organisasi "'.$request->input('nama_opd').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        // var_dump($id);exit();

        $dataOrg = Organisasi::find($id);

        //var_dump(json_encode($dataOrg));exit();

        $org =  json_encode($dataOrg);

        return view('userportal.done.detail_org');

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $data['request_done'] = Pelayanan::find($id);

        $data['parent_org'] = Pelayanan::where('induk_organisasi','=','')

                    ->orWhere('induk_organisasi','=',null)->get();

        //dd($data['request_done']);exit();

        if (!$data['request_done']) return view('errors.404');



        return view('admin.organisasi.edit', $data);

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

        $organisasi = Pelayanan::find($id);



        if (!$organisasi) return view('errors.404');



        $validator = Validator::make($request->all(), [

            'nama_opd' => 'required',

            'status' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                    ->withErrors($validator)

                    ->withInput();

        }

        

        // Upload feature photo



        // end of upload feature photo

        $organisasi->nama_opd = $request->input('nama_opd');

        $organisasi->induk_organisasi = $request->input('induk_organisasi');

        $organisasi->nama_opd = $request->input('nama_opd');

        $organisasi->nama_pengelola = $request->input('nama_pengelola');

        $organisasi->no_hp_pengelola = $request->input('no_hp_pengelola');

        $organisasi->email = $request->input('email');

        $organisasi->status = $request->input('status');

        $organisasi->save();



        return redirect()->route('request_done.index')->with('success', 'request_done "'.$request->input('nama_opd').'" berhasil dirubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $organisasi = Pelayanan::find($id);



        if (!$organisasi) return view('errors.404');



        $organisasi_name = $organisasi->nama_opd;



        $organisasi->delete();



        return redirect()->route('request_done.index')->with('success', 'Data organisasi "'.$organisasi_name.'" telah dihapus!');



    }

}