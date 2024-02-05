<?php



namespace App\Http\Controllers;



use App\Server;

use App\Event;

use Illuminate\Http\Request;



use Auth;

use Datatables;

use Image;

use File;

use Validator;

use Storage;

use Mail;

use Excel;



class ServerController extends Controller

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

        return view('admin.server.index');

    }



    public function serverData()

    {

        $query = Server::where('id_infrastruktur','=','INF-01')->get();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {

                                

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('server.edit', $item->id_server)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('server.destroy', $item->id_server)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";



                                return $temp;

                            })

                            ->editColumn('nama_perangkat', function($item) {

                                return "<a href='".route('server.show', $item->id_server)."'>".$item->nama_perangkat."</a>";

                            })

                            ->make(true);

    }



    public function exportExcel(Request $request)

    {

        $data['title'] = 'Data Server';

        $data['server'] = Server::where('id_infrastruktur','=','INF-01')->get();

        Excel::create('Data Server '.date('Y').'',function($excel) use ($data){

            $excel->sheet('Sheet 1',function($sheet) use ($data){



                $sheet->loadView('admin.server.excel_view', $data);

            });

        })->export('xls');

    }



    public function create()

    {

        return view('admin.server.create');

    }



    public function importExcel(){



        // validasi

        $request->validate([

            'import_file' => 'required'

        ]);

        

        $path = $request->file('import_file')->getRealPath();

        $data = Excel::load($path)->get();



        if($data->count()){

            foreach ($data as $key => $value) {

                $arr[] = [

                    'nama_opd' => $value->nama_opd,

                    'induk_organisasi' => $value->induk_organisasi, 

                    'nama_pengelola' => $value->nama_pengelola,

                    'email' => $value->email,

                    'no_hp_pengelola' => $value->no_hp_pengelola,

                    'status' => $value->status];

            }

 

            if(!empty($arr)){

                Organisasi::insert($arr);

            }

        }

 

        return back()->with('success', 'Import data Excel Sukses..!!');

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

            'nama_perangkat' => 'required',

            'merek' => 'required',

            'status' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                    ->withErrors($validator)

                    ->withInput();

        }



        // $tglevent = $request->input('tgl_event');

        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));

        //var_dump($tgl_event);exit();

        Server::create([

            'id_infrastruktur' => 'INF-01',

            'nama_perangkat' => $request->input('nama_perangkat'),

            'merek' => $request->input('merek'),

            'model' => $request->input('model'),

            'ip_manajemen' => $request->input('ip_manajemen'),

            'no_rak' => $request->input('no_rak'),

            'nomer_aset' => $request->input('nomer_aset'),

            'nomer_serial' => $request->input('nomer_serial'),

            'lisensi' => $request->input('lisensi'),

            'status' => $request->input('status'),

        ]);

        return redirect()->route('server.index')->with('success', 'Server "'.$request->input('nama_perangkat').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $data['server'] = server::find($id);

        if (!$data['server']) return view('errors.404');

        return view('admin.server.detail', $data);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $server = Server::find($id);



        if (!$server) return view('errors.404');



        return view('admin.server.edit', compact('server'));

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

        $server = Server::find($id);



        if (!$server) return view('errors.404');



        $validator = Validator::make($request->all(), [

            'nama_perangkat' => 'required',

            'merek' => 'required',

            'status' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                    ->withErrors($validator)

                    ->withInput();

        }

        

        // Upload feature photo



        // end of upload feature photo

        $server->nama_perangkat = $request->input('nama_perangkat');

        $server->merek = $request->input('merek');

        $server->model = $request->input('model');

        $server->ip_manajemen = $request->input('ip_manajemen');

        $server->no_rak = $request->input('no_rak');

        $server->nomer_aset = $request->input('nomer_aset');

        $server->nomer_serial = $request->input('nomer_serial');

        $server->lisensi = $request->input('lisensi');

        $server->status = $request->input('status');

        $server->save();



        return redirect()->route('server.index')->with('success', 'Server "'.$request->input('nama_perangkat').'" berhasil diubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $server = Server::find($id);



        if (!$server) return view('errors.404');



        $server_name = $server->nama_perangkat;



        $server->delete();



        return redirect()->route('server.index')->with('success', 'Data server "'.$server_name.'" berhasil dihapus!');



    }

}