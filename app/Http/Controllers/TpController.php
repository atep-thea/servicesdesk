<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TpModel;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class TpController extends Controller
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
        return view('admin.tp.index');
    }

    public function tpData()
    {

        $query = TpModel::all();
        //var_dump($query);exit();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('tp.edit', $item->id_tipe)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('tp.destroy', $item->id_tipe)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->editColumn('nama_perangkat', function($item) {
                                return "<a href='".route('tp.show', $item->id_tipe)."'>".$item->id_tipe."</a>";
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.tp.create');
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
                  'tp_permintaan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        TpModel::create([
            'id_tipe' => $request->input('id_tipe'),
            'tp_permintaan' => $request->input('tp_permintaan'),
        ]);

        return redirect()->route('tp.index')->with('success', 'Rak "'.$request->input('id_tipe').'" berhasil ditambahkan!');
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
        $tp = TpModel::find($id);
        
        if (!$tp) return view('errors.404');

        return view('admin.tp.edit', compact('tp'));
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
        $tp = TpModel::find($id);

        if (!$tp) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'tp_permintaan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $tp->tp_permintaan = $request->input('tp_permintaan');
        $tp->save();

        return redirect()->route('tp.index')->with('success', 'Server "'.$request->input('tp_permintaan').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tp = TpModel::find($id);

        if (!$tp) return view('errors.404');

        $tp_permintaan = $tp->tp;

        $tp->delete();

        return redirect()->route('tp.index')->with('success', 'Data Reff Infra "'.$tp_permintaan.'" telah dihapus!');

    }
}