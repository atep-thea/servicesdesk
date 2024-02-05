<?php

namespace App\Http\Controllers;

use App\RefInfraModel;
use Illuminate\Http\Request;

use Auth;
use Datatables;
use Image;
use File;
use Validator;
use Storage;


class RefInfraController extends Controller
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
        return view('admin.ref_infra.index');
    }

    public function reffInfraData()
    {
        $query = RefInfraModel::all();
        return Datatables::of($query)
                            ->addColumn('action', function($item) {

                                $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                                <a href=".route('ref-infrastruktur.edit', $item->id_infrastruktur)." class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                                $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                                <a href='#delete' 
                                data-delete-url=".route('ref-infrastruktur.destroy', $item->id_infrastruktur)." role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                                return $temp;
                            })
                            ->make(true);
    }


    public function create()
    {
        return view('admin.ref_infra.create');
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
            'id_infrastruktur' => 'required',
            'infrastruktur' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        // $tglevent = $request->input('tgl_event');
        // $tgl_event = date('Y-m-d H:i:s', strtotime($tglevent));
        //var_dump($tgl_event);exit();
        RefInfraModel::create([
            'id_infrastruktur' => $request->input('id_infrastruktur'),
            'infrastruktur' => $request->input('infrastruktur'),
        ]);

        return redirect()->route('ref-infrastruktur.index')->with('success', 'Rak "'.$request->input('id_infrastruktur').'" berhasil ditambahkan!');
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
        $refInfra = RefInfraModel::find($id);
        
        if (!$refInfra) return view('errors.404');

        return view('admin.ref_infra.edit', compact('refInfra'));
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
        $ref_infra = RefInfraModel::find($id);

        if (!$ref_infra) return view('errors.404');

        $validator = Validator::make($request->all(), [
            'id_infrastruktur' => 'required',
            'infrastruktur' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // Upload feature photo

        // end of upload feature photo
        $ref_infra->id_infrastruktur = $request->input('id_infrastruktur');
        $ref_infra->infrastruktur = $request->input('infrastruktur');
        $ref_infra->save();

        return redirect()->route('ref-infrastruktur.index')->with('success', 'Server "'.$request->input('infrastruktur').'" berhasil dirubah!');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reff_infra = RefInfraModel::find($id);

        if (!$reff_infra) return view('errors.404');

        $reff_infra_name = $reff_infra->infrastruktur;

        $reff_infra->delete();

        return redirect()->route('ref-infrastruktur.index')->with('success', 'Data Reff Infra "'.$reff_infra_name.'" telah dihapus!');

    }
}