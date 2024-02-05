<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UrgensiModel;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class UrgensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Hturgensi\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // $blogs = Blog::all();
        return view('admin.urgensi.index');
    }

    public function urgensiData()
    {

        $query = UrgensiModel::all();
        //var_dump($query);exit();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('urgensi.edit', $item->id_urgensi)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('urgensi.destroy', $item->id_urgensi)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->editColumn('nama_perangkat', function($item) {
                                return "<a href='".route('urgensi.show', $item->id_urgensi)."'>".$item->id_urgensi."</a>";
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.urgensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Hturgensi\Request  $request
     * @return \Illuminate\Hturgensi\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                  'def_urgensi' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        UrgensiModel::create([
            'id_urgensi' => $request->input('id_urgensi'),
            'def_urgensi' => $request->input('def_urgensi'),
        ]);

        return redirect()->route('urgensi.index')->with('success', 'Rak "'.$request->input('id_urgensi').'" berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Hturgensi\Response
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
     * @return \Illuminate\Hturgensi\Response
     */
    public function edit($id)
    {
        $urgensi = UrgensiModel::find($id);
        
        if (!$urgensi) return view('errors.404');

        return view('admin.urgensi.edit', compact('urgensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Hturgensi\Request  $request
     * @param  int id
     * @return \Illuminate\Hturgensi\Response
     */
    public function update(Request $request, $id)
    {
        $urgensi = UrgensiModel::find($id);

        if (!$urgensi) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'def_urgensi' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $urgensi->def_urgensi = $request->input('def_urgensi');
        $urgensi->save();

        return redirect()->route('urgensi.index')->with('success', 'Server "'.$request->input('def_urgensi').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Hturgensi\Response
     */
    public function destroy($id)
    {
        $urgensi = UrgensiModel::find($id);

        if (!$urgensi) return view('errors.404');

        $def_urgensi = $urgensi->def_urgensi;

        $urgensi->delete();

        return redirect()->route('urgensi.index')->with('success', 'Data Reff Infra "'.$def_urgensi.'" telah dihapus!');

    }
}