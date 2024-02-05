<?php

namespace App\Http\Controllers;

use App\JnsperangkatModel;
use Illuminate\Http\Request;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class JnsperangkatController extends Controller
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
        return view('admin.jns_perangkat.index');
    }

    public function jns_perangkatData()
    {
        $query = JnsperangkatModel::all();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('jns_perangkat.edit', $item->id_jns_perangkat)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('jns_perangkat.destroy', $item->id_jns_perangkat)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.jns_perangkat.create');
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
            'id_jns_perangkat' => 'required',
            'nama_jns_perangkat' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        JnsperangkatModel::create([
            'id_jns_perangkat' => $request->input('id_jns_perangkat'),
            'nama_jns_perangkat' => $request->input('nama_jns_perangkat'),
        ]);

        return redirect()->route('jns_perangkat.index')->with('success', 'Rak "'.$request->input('id_jns_perangkat').'" berhasil ditambahkan!');
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
        return view('admin.rak.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jns_perangkat = JnsperangkatModel::find($id);
        
        if (!$jns_perangkat) return view('errors.404');

        return view('admin.jns_perangkat.edit', compact('jns_perangkat'));
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
        $jns_perangkat = JnsperangkatModel::find($id);

        if (!$jns_perangkat) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'id_jns_perangkat' => 'required',
            'nama_jns_perangkat' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $jns_perangkat->id_jns_perangkat = $request->input('id_jns_perangkat');
        $jns_perangkat->nama_jns_perangkat = $request->input('nama_jns_perangkat');
        $jns_perangkat->save();

        return redirect()->route('jns_perangkat.index')->with('success', 'Server "'.$request->input('nama_jns_perangkat').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jns_perangkat = JnsperangkatModel::find($id);

        if (!$jns_perangkat) return view('errors.404');

        $jns_perangkat_name = $jns_perangkat->nama_jns_perangkat;

        $jns_perangkat->delete();

        return redirect()->route('jns_perangkat.index')->with('success', 'Data Reff Infra "'.$jns_perangkat_name.'" telah dihapus!');

    }
}