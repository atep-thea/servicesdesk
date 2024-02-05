<?php



namespace App\Http\Controllers;



use App\Checklist;

use App\ReffJnsPerangkat;

use App\Organisasi;
use App\ReffJnsPelayanan;
use App\ReffStatus;

use Illuminate\Http\Request;

use Auth;

use Datatables;

use File;

use Validator;

use Storage;

use Illuminate\Support\Facades\Log;



class ChecklistController extends Controller

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

        	return view('admin.checklist_layanan.index');

        // }

        

    }



    public function checklistData()

    {

        $query = Checklist::get();

        //var_dump($query);exit();

        return Datatables::of($query)

                            ->addColumn('action', function($item) {



                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>

                                <a href=".route('checklist.edit', $item->id)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";



                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

                                <a href='#delete' data-delete-url=".route('checklist.destroy', $item->id)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

                                return $temp;

                            })

                            ->editColumn('nama_perangkat', function($item) {

                                return "<a href=".route('checklist.show', $item->id)." >".$item->checklist_name."</a>";

                            })

                            ->make(true);

    }





    public function create()

    {

    	$layanan = ReffJnsPelayanan::all();

    

        return view('admin.checklist_layanan.create',compact('layanan'));

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
        Log::info($request->input('checklist_name'));
        Log::info($request->input('id_jns_pelayanan'));

        Checklist::create([

            'checklist_name' => $request->input('checklist_name'),

            'id_jns_pelayanan' => $request->input('id_jns_pelayanan'),

        ]);



        return redirect()->route('checklist.index')->with('success', 'Perangkat "'.$request->input('software').'" berhasil ditambahkan!');

    }



    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {	



        $checklist = Checklist::find($id);

        $layanan = Organisasi::all();

        if (!$checklist) return view('errors.404');



        return view('admin.checklist_layanan.detail', compact('checklist','layanan'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $software = Checklist::find($id);

        $layanan = ReffJnsPelayanan::all();

         if (!$software) return view('errors.404');



        return view('admin.software.edit', compact('software','layanan'));

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

        $storage = Checklist::find($id);

		$storage->checklist_name = $request->input('checklist_name');

		$storage->id_jns_pelayanan = $request->input('id_jns_pelayanan');

        $storage->save();



        return redirect()->route('checklist.index')->with('success', 'Checklist "'.$request->input('checklist_name').'" berhasil dirubah!');

    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $checklist = Checklist::find($id);



        if (!$checklist) return view('errors.404');



        $checklist_name = $checklist->checklist_name;



        $checklist->delete();



        return redirect()->route('checklist.index')->with('success', 'Checklist "'.$checklist_name.'" telah dihapus!');



    }

}

