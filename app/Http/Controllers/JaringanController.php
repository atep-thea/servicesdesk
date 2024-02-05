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





class JaringanController extends Controller

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

        return view('admin.jaringan.index');

    }



    public function jaringanData()

    {

        $query = Server::where('id_infrastruktur','=','INF-05')->get();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {



                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('jaringan.edit', $item->id_server)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('jaringan.destroy', $item->id_server)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                                return $temp;

                            })

                            ->editColumn('nama_perangkat', function($item) {

                                return "<a href='".route('jaringan.show', $item->id_server)."'>".$item->nama_perangkat."</a>";

                            })

                            ->make(true);

    }





    public function create()

    {

        return view('admin.jaringan.create');

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

            'id_infrastruktur' => 'INF-05',

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



        return redirect()->route('jaringan.index')->with('success', 'Perngkat Jaringan "'.$request->input('nama_perangkat').'" berhasil ditambahkan!');

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

        return view('admin.jaringan.detail', $data);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $jaringan = Server::find($id);



        if (!$jaringan) return view('errors.404');



        return view('admin.jaringan.edit', compact('jaringan'));

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

        $jaringan = Server::find($id);



        if (!$jaringan) return view('errors.404');



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

        $jaringan->nama_perangkat = $request->input('nama_perangkat');

        $jaringan->merek = $request->input('merek');

        $jaringan->model = $request->input('model');

        $jaringan->ip_manajemen = $request->input('ip_manajemen');

        $jaringan->no_rak = $request->input('no_rak');

        $jaringan->nomer_aset = $request->input('nomer_aset');

        $jaringan->nomer_serial = $request->input('nomer_serial');

        $jaringan->lisensi = $request->input('lisensi');

        $jaringan->status = $request->input('status');

        $jaringan->save();



        return redirect()->route('jaringan.index')->with('success', 'jaringan "'.$request->input('nama_perangkat').'" berhasil dirubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $jaringan = Server::find($id);



        if (!$jaringan) return view('errors.404');



        $jaringan_name = $jaringan->nama_perangkat;



        $jaringan->delete();



        return redirect()->route('jaringan.index')->with('success', 'Data jaringan "'.$jaringan_name.'" telah dihapus!');



    }

}