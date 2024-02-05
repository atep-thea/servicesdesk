<?php

namespace App\Http\Controllers;

use App\SjnspelayananModel;
use App\JnspelayananModel;
use Illuminate\Http\Request;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class SjnspelayananController extends Controller
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
        return view('admin.sjns_pelayanan.index');
    }

    public function sjns_pelayananData()
    {
        $query = SjnspelayananModel::leftjoin('reff_jns_pelayanan','reff_jns_pelayanan.id_pelayanan', '=','reff_sjns_pelayanan.id_pelayanan')
                                    ->select('reff_sjns_pelayanan.id_sjns_pelayanan','reff_jns_pelayanan.pelayanan','reff_sjns_pelayanan.jenis_pelayanan')
                                    ->get();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('sjns_pelayanan.edit', $item->id_sjns_pelayanan)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('sjns_pelayanan.destroy', $item->id_sjns_pelayanan)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->editColumn('nama_perangkat', function($item) {
                                return "<a href='".route('sjns_pelayanan.show', $item->id_sjns_pelayanan)."'>".$item->id_sjns_pelayanan."</a>";
                            })
                            ->make(true);
    }


    public function create()
    {
         $parent_org = JnsPelayananModel::all();
        return view('admin.sjns_pelayanan.create',compact('parent_org'));
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
            
            'jenis_pelayanan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        SjnspelayananModel::create([
            'id_pelayanan' => $request->input('id_pelayanan'),
            'jenis_pelayanan' => $request->input('jenis_pelayanan'),
        ]);

        return redirect()->route('sjns_pelayanan.index')->with('success', 'Rak "'.$request->input('id_sjns_pelayanan').'" berhasil ditambahkan!');
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
        $data['sjns'] = SjnspelayananModel::find($id);

        $data['jns_pelayanan'] = JnspelayananModel::all();
        return view('admin.sjns_pelayanan.edit', $data);
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
        $sjns_pelayanan = SjnspelayananModel::find($id);

        if (!$sjns_pelayanan) return view('errors.404');

        $validator = Validator::make($request->all(), [
            
            'jenis_pelayanan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $sjns_pelayanan->id_pelayanan = $request->input('id_pelayanan');
        $sjns_pelayanan->jenis_pelayanan = $request->input('jenis_pelayanan');
        $sjns_pelayanan->save();

        return redirect()->route('sjns_pelayanan.index')->with('success', 'Server "'.$request->input('jenis_pelayanan').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sjns_pelayanan = sjnspelayananModel::find($id);

        if (!$sjns_pelayanan) return view('errors.404');

        $sjns_pelayanan_name = $sjns_pelayanan->jenis_pelayanan;

        $sjns_pelayanan->delete();

        return redirect()->route('sjns_pelayanan.index')->with('success', 'Data Reff Infra "'.$sjns_pelayanan_name.'" telah dihapus!');

    }
}