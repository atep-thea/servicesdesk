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


class PenyimpananController extends Controller
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
        return view('admin.penyimpanan.index');
    }

    public function penyimpananData()
    {
        $query = Server::where('id_infrastruktur','=','INF-06')->get();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('penyimpanan.edit', $item->id_server)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' data-delete-url=".route('penyimpanan.destroy', $item->id_server)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->editColumn('nama_perangkat', function($item) {
                                return "<a href='".route('penyimpanan.show', $item->id_server)."'>".$item->nama_perangkat."</a>";
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.penyimpanan.create');
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
            'id_infrastruktur' => 'INF-06',
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

        return redirect()->route('penyimpanan.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil ditambahkan!');
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
        return view('admin.penyimpanan.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penyimpanan = Server::find($id);

        if (!$penyimpanan) return view('errors.404');

        return view('admin.penyimpanan.edit', compact('penyimpanan'));
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
        $penyimpanan = Server::find($id);

        if (!$penyimpanan) return view('errors.404');

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
        $penyimpanan->nama_perangkat = $request->input('nama_perangkat');
        $penyimpanan->merek = $request->input('merek');
        $penyimpanan->model = $request->input('model');
        $penyimpanan->ip_manajemen = $request->input('ip_manajemen');
        $penyimpanan->no_rak = $request->input('no_rak');
        $penyimpanan->nomer_aset = $request->input('nomer_aset');
        $penyimpanan->nomer_serial = $request->input('nomer_serial');
        $penyimpanan->lisensi = $request->input('lisensi');
        $penyimpanan->status = $request->input('status');
        $penyimpanan->save();

        return redirect()->route('penyimpanan.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penyimpanan = Server::find($id);

        if (!$penyimpanan) return view('errors.404');

        $penyimpanan_name = $penyimpanan->nama_perangkat;

        $penyimpanan->delete();

        return redirect()->route('penyimpanan.index')->with('success', 'Data penyimpanan "'.$penyimpanan_name.'" telah dihapus!');

    }
}