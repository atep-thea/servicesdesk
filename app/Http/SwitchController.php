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


class SwitchController extends Controller
{

        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $blogs = Blog::all();
        return view('admin.switch.index');
    }

    public function switchData()
    {
        $query = Server::where('id_infrastruktur','=','INF-07')->get();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('switch.edit', $item->id_server)." class='btn btn-xs btn-primary'><i class='icon far fa-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' data-delete-url=".route('switch.destroy', $item->id_server)." role='button' class='btn btn-xs btn-danger delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.switch.create');
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
            'unit_kerja' => 'required',
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
            'id_infrastruktur' => 'INF-07',
            'nama_perangkat' => $request->input('nama_perangkat'),
            'merek' => $request->input('merek'),
            'model' => $request->input('model'),
            'unit_kerja' => $request->input('unit_kerja'),
            'ip_manajemen' => $request->input('ip_manajemen'),
            'no_rak' => $request->input('no_rak'),
            'nomer_aset' => $request->input('nomer_aset'),
            'nomer_serial' => $request->input('nomer_serial'),
            'lisensi' => $request->input('lisensi'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('switch.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $blog = Blog::find($id);

        // if (!$blog) return view('errors.404');

        // return view('switch.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $switch = Server::find($id);

        if (!$switch) return view('errors.404');

        return view('admin.switch.edit', compact('switch'));
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
        $switch = Server::find($id);

        if (!$switch) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'nama_perangkat' => 'required',
            'merek' => 'required',
            'unit_kerja' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $switch->nama_perangkat = $request->input('nama_perangkat');
        $switch->merek = $request->input('merek');
        $switch->model = $request->input('model');
        $switch->unit_kerja = $request->input('unit_kerja');
        $switch->ip_manajemen = $request->input('ip_manajemen');
        $switch->no_rak = $request->input('no_rak');
        $switch->nomer_aset = $request->input('nomer_aset');
        $switch->nomer_serial = $request->input('nomer_serial');
        $switch->lisensi = $request->input('lisensi');
        $switch->status = $request->input('status');
        $switch->save();

        return redirect()->route('switch.index')->with('success', 'Perangkat "'.$request->input('nama_perangkat').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $switch = Server::find($id);

        if (!$switch) return view('errors.404');

        $switch_name = $switch->nama_perangkat;

        $switch->delete();

        return redirect()->route('switch.index')->with('success', 'switch "'.$switch_name.'" telah dihapus!');

    }
}