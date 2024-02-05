<?php



namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\ReffGolongan;

use Auth;

use Datatables;

use Image;

use File;

use Validator;

use Storage;





class GolonganController extends Controller

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
        return view('admin.golongan.index');
    }



    public function golonganData()

    {

        $query = ReffGolongan::all();

        return Datatables::of($query)

            ->addColumn('action', function ($item) {



                $temp = "<span data-toggle='tooltip' title='Edit Golongan'>

                                <a href=" . route('golongan.edit', $item->id) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                $temp .= "<span data-toggle='tooltip' title='Hapus Golongan'>

                                <a href='#delete' 

                                data-delete-url=" . route('golongan.destroy', $item->id) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                return $temp;
            })

            ->editColumn('golongan', function ($item) {

                return $item->name;
            })

            ->make(true);
    }





    public function create()

    {

        return view('admin.golongan.create');
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

            'golongan' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }



        // $tglevent = $request->input('tgl_event');

        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));

        //var_dump($tgl_event);exit();

        ReffGolongan::create([

            'name' => $request->input('golongan'),

        ]);



        return redirect()->route('golongan.index')->with('success', 'Golongan "' . $request->input('golongan') . '" berhasil ditambahkan!');
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

        return view('admin.golongan.detail', $data);
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $golongan = ReffGolongan::find($id);



        if (!$golongan) return view('errors.404');



        return view('admin.golongan.edit', compact('golongan'));
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

        $golongan = ReffGolongan::find($id);



        if (!$golongan) return view('errors.404');



        $validator = Validator::make($request->all(), [

            'golongan' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }



        // Upload feature photo



        // end of upload feature photo

        $golongan->name = $request->input('golongan');

        $golongan->save();



        return redirect()->route('golongan.index')->with('success', 'Golongan "' . $request->input('golongan') . '" berhasil dirubah!');
    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $golongan = ReffGolongan::find($id);



        if (!$golongan) return view('errors.404');



        $golongan_name = $golongan->name;



        $golongan->delete();



        return redirect()->route('golongan.index')->with('success', 'Data Reff Golongan "' . $golongan_name . '" telah dihapus!');
    }
}
