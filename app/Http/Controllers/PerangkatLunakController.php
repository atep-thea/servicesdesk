<?php



namespace App\Http\Controllers;



use App\PerangkatLunak;

use App\ReffJnsPerangkat;

use App\Organisasi;

use App\ReffStatus;

use Illuminate\Http\Request;

use Auth;

use Datatables;

use File;

use Validator;

use Storage;





class PerangkatLunakController extends Controller

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

     //    $software = PerangkatLunak::find($id);

     //    $org = Organisasi::all();

    	// $jnsPerangkat = ReffJnsPerangkat::all();

    	// $status = ReffStatus::all();

     //    if (!$software) return view('errors.404');



     //    if(!empty($id)){

     //    	return view('admin.software.index', compact('software'));

     //    }else{

        	return view('admin.software.index');

        // }

        

    }



    public function PerangkatLunakData()

    {

        $query = PerangkatLunak::leftjoin('organisasi','organisasi.id_organisasi', '=','perangkat_lunak.id_organisasi')

        			->get();

        //var_dump($query);exit();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {



                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('perangkat-lunak.edit', $item->id_perangkat)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('perangkat-lunak.destroy', $item->id_perangkat)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                                return $temp;

                            })

                            ->editColumn('nama_perangkat', function($item) {

                                return "<a href=".route('perangkat-lunak.show', $item->id_perangkat)." >".$item->nama_perangkat."</a>";

                            })

                            ->make(true);

    }


    public function create()

    {

    	$org = Organisasi::all();

    

        return view('admin.software.create',compact('org'));

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

        PerangkatLunak::create([

            'id_organisasi' => $request->input('id_organisasi'),

            'software' => $request->input('software'),

            'lisensi' => $request->input('lisensi'),

            'kadaluarsa' => $request->input('kadaluarsa'),

            'tgl_pembelian' => $request->input('tgl_pembelian'),

            'keterangan' => $request->input('keterangan'),

            'status' => $request->input('status'),

        ]);



        return redirect()->route('perangkat-lunak.index')->with('success', 'Perangkat "'.$request->input('software').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {	



        $software = PerangkatLunak::find($id);

        $org = Organisasi::all();

        if (!$software) return view('errors.404');



        return view('admin.software.detail', compact('software','org'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $software = PerangkatLunak::find($id);

        $org = Organisasi::all();

         if (!$software) return view('errors.404');



        return view('admin.software.edit', compact('software','org'));

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

        $storage = PerangkatLunak::find($id);

        // Upload feature photo



        // end of upload feature photo

		$storage->id_organisasi = $request->input('id_organisasi');

		$storage->software = $request->input('software');

		$storage->lisensi = $request->input('lisensi');

        $storage->kadaluarsa = $request->input('kadaluarsa');

		$storage->tgl_pembelian = $request->input('tgl_pembelian');

		$storage->keterangan = $request->input('keterangan');

		$storage->status = $request->input('status');

        $storage->save();



        return redirect()->route('perangkat-lunak.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil dirubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $software = PerangkatLunak::find($id);



        if (!$software) return view('errors.404');



        $software_name = $software->nama_perangkat;



        $software->delete();



        return redirect()->route('perangkat-lunak.index')->with('success', 'Perangkat "'.$software_name.'" telah dihapus!');



    }

}

