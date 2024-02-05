<?php

namespace App\Http\Controllers;

use App\Jabatan;
use Illuminate\Http\Request;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class JabatanController extends Controller
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
        return view('admin.jabatan.index');
    }

    public function jabatanData()
    {
        $query = jabatan::all();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('jabatan.edit', $item->id_jabatan)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('jabatan.destroy', $item->id_jabatan)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->editColumn('nama_perangkat', function($item) {
                                return "<a href='".route('jabatan.show', $item->id_jabatan)."'>".$item->id_jabatan."</a>";
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.jabatan.create');
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
                  'jabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        jabatan::create([
            'id_jabatan' => $request->input('id_jabatan'),
            'jabatan' => $request->input('jabatan'),
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Rak "'.$request->input('id_jabatan').'" berhasil ditambahkan!');
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
        $jabatan = jabatan::find($id);
        
        if (!$jabatan) return view('errors.404');

        return view('admin.jabatan.edit', compact('jabatan'));
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
        $jabatan = jabatan::find($id);

        if (!$jabatan) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
              $jabatan->jabatan = $request->input('jabatan');
        $jabatan->save();

        return redirect()->route('jabatan.index')->with('success', 'Server "'.$request->input('jabatan').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jabatan = jabatan::find($id);

        if (!$jabatan) return view('errors.404');

        $jabatan_name = $jabatan->jabatan;

        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Data Reff Infra "'.$jabatan_name.'" telah dihapus!');

    }
}