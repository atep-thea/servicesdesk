<?php



namespace App\Http\Controllers;



use App\PerangkatKeras;

use App\ReffJnsPerangkat;

use App\Organisasi;

use App\ReffStatus;

use Illuminate\Http\Request;

use Auth;

use Datatables;

use File;

use Validator;

use Storage;





class PerangkatKerasController extends Controller

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

     //    $hardware = PerangkatKeras::find($id);

     //    $org = Organisasi::all();

    	// $jnsPerangkat = ReffJnsPerangkat::all();

    	// $status = ReffStatus::all();

     //    if (!$hardware) return view('errors.404');



     //    if(!empty($id)){

     //    	return view('admin.hardware.index', compact('hardware'));

     //    }else{

        	return view('admin.hardware.index');

        // }

        

    }



    public function perangkatKerasData()

    {

        $query = PerangkatKeras::leftjoin('reff_jns_perangkat','reff_jns_perangkat.id_jns_perangkat', '=','perangkat_keras.jns_perangkat')

        			->leftjoin('organisasi','organisasi.id_organisasi', '=','perangkat_keras.id_organisasi')

        			->leftjoin('reff_status','reff_status.id_status', '=','perangkat_keras.status')

        			->get();

        //var_dump($query);exit();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {



                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('perangkat-keras.edit', $item->id_perangkat)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('perangkat-keras.destroy', $item->id_perangkat)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                                return $temp;

                            })

                            ->editColumn('nama_perangkat', function($item) {

                                return "<a href=".route('perangkat-keras.show', $item->id_perangkat)." >".$item->nama_perangkat."</a>";

                            })

                            ->make(true);

    }





    public function create()

    {

    	$org = Organisasi::all();

    	$jnsPerangkat = ReffJnsPerangkat::all();

    	$status = ReffStatus::all();

        return view('admin.hardware.create',compact('org','jnsPerangkat','status'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

    	//var_dump($request->all());exit();

        PerangkatKeras::create([

            'nama_perangkat' => $request->input('nama_perangkat'),

            'merek' => $request->input('merek'),

            'model' => $request->input('model'),

            'id_organisasi' => $request->input('id_organisasi'),

            'jns_perangkat' => $request->input('id_jns_perangkat'),

            'phone' => $request->input('phone'),

            'tgl_pembelian' => $request->input('tgl_pembelian'),

            'aset_number' => $request->input('aset_number'),

            'serial_number' => $request->input('serial_number'),

            'deskripsi' => $request->input('deskripsi'),

            'id_status' => $request->input('id_status'),

        ]);



        return redirect()->route('perangkat-keras.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {	



        $hardware = PerangkatKeras::find($id);

        $org = Organisasi::all();

    	$jnsPerangkat = ReffJnsPerangkat::all();

    	$status = ReffStatus::all();

        if (!$hardware) return view('errors.404');



        return view('admin.hardware.detail', compact('hardware','org','jnsPerangkat','status'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $hardware = PerangkatKeras::find($id);

        $org = Organisasi::all();

    	$jnsPerangkat = ReffJnsPerangkat::all();

    	$status = ReffStatus::all();

        if (!$hardware) return view('errors.404');



        return view('admin.hardware.edit', compact('hardware','org','jnsPerangkat','status'));

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

        $storage = PerangkatKeras::find($id);

        // Upload feature photo



        // end of upload feature photo

		$storage->nama_perangkat = $request->input('nama_perangkat');

		$storage->merek = $request->input('merek');

		$storage->model = $request->input('model');

		$storage->id_organisasi = $request->input('id_organisasi');

		$storage->jns_perangkat = $request->input('id_jns_perangkat');

		$storage->phone = $request->input('phone');

		$storage->tgl_pembelian = $request->input('tgl_pembelian');

		$storage->aset_number = $request->input('aset_number');

		$storage->serial_number = $request->input('serial_number');

		$storage->deskripsi = $request->input('deskripsi');

		$storage->status = $request->input('id_status');

        $storage->save();



        return redirect()->route('perangkat-keras.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil diubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $hardware = PerangkatKeras::find($id);



        if (!$hardware) return view('errors.404');



        $hardware_name = $hardware->nama_perangkat;



        $hardware->delete();



        return redirect()->route('perangkat-keras.index')->with('success', 'Perangkat "'.$hardware_name.'" berhasil dihapus!');



    }

}

