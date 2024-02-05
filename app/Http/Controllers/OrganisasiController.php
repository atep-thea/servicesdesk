<?php



namespace App\Http\Controllers;



use App\Organisasi;

use App\User;

use App\Event;

use Illuminate\Http\Request;

use Excel;

use Auth;

use Datatables;

use Image;

use File;

use Validator;

use Storage;





class OrganisasiController extends Controller

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
        return view('admin.organisasi.index');

    }



    public function orgData()

    {

        $query = Organisasi::all();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('organisasi.edit', $item->id_organisasi)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('organisasi.destroy', $item->id_organisasi)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                                return $temp;

                            })

                            ->editColumn('nama_opd', function($item) {

                                return "<a href='".route('organisasi.show', $item->id_organisasi)."'>".$item->nama_opd."</a>";

                            })

                            ->make(true);

    }





    public function create()

    {

        $parent_org = Organisasi::all();

        return view('admin.organisasi.create',compact('parent_org'));

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

                Organisasi::insert($arr);

            }

        }

 

        return back()->with('success', 'Import data Excel Sukses..!!');

    }



     public function exportExcel(Request $request)

    {

        $data['title'] = 'Data Organisasi';

        $data['org'] = Organisasi::all();

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



        // $tglevent = $request->input('tgl_event');

        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));

        //var_dump($tgl_event);exit();

        Organisasi::create([

            'induk_organisasi' => $request->input('induk_organisasi'),

            'nama_opd' => $request->input('nama_opd'),

            'nama_pengelola' => $request->input('nama_pengelola'),

            'no_hp_pengelola' => $request->input('no_hp_pengelola'),

            'email' => $request->input('email'),

            'status' => $request->input('status')

        ]);



        return redirect()->route('organisasi.index')->with('success', 'Perngkat organisasi "'.$request->input('nama_opd').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $data['organisasi'] = Organisasi::find($id);

        if (!$data['organisasi']) return view('errors.404');

        return view('admin.organisasi.detail', $data);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $data['organisasi'] = Organisasi::find($id);

        $data['parent_org'] = Organisasi::where('induk_organisasi','=','')

                    ->orWhere('induk_organisasi','=',null)->get();

        //dd($data['organisasi']);exit();

        if (!$data['organisasi']) return view('errors.404');



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

        $organisasi = Organisasi::find($id);



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



        return redirect()->route('organisasi.index')->with('success', 'organisasi "'.$request->input('nama_opd').'" berhasil dirubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $organisasi = Organisasi::find($id);



        if (!$organisasi) return view('errors.404');



        $organisasi_name = $organisasi->nama_opd;



        $organisasi->delete();



        return redirect()->route('organisasi.index')->with('success', 'Data organisasi "'.$organisasi_name.'" telah dihapus!');



    }

}