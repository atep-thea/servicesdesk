<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\FlowPelayanan;
use App\JnspelayananModel;
use App\Team;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Storage;
use Validator;

class JnspelayananController extends Controller
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

        return view('admin.jns_pelayanan.index');
    }

    public function jns_pelayananData()
    {

        $query = JnspelayananModel::all();

        return Datatables::of($query)

        // ->addColumn('action', function ($item) {

        //     $temp = "<span data-toggle='tooltip' title='Edit Posting'>

        //                     <a href=" . route('jns_pelayanan.edit', $item->id_pelayanan) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

        //     $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>

        //                     <a href='#delete'

        //                     data-delete-url=" . route('jns_pelayanan.destroy', $item->id_pelayanan) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";

        //     return $temp;
        // })

            ->editColumn('pelayanan', function ($item) {

                return "<a href='" . route('jns_pelayanan.show', $item->id_pelayanan) . "'>" . $item->pelayanan . "</a>";
            })

            ->make(true);
    }

    public function create()
    {
        $team = Team::all();
        $user_eselon_3 = User::whereHas('role_user', function ($q) {
            $q->where('name', 'eselon_3');
        })->get();

        $user_koordinator = User::whereHas('role_user', function ($q) {
            $q->where('name', 'coordinator_agent');
        })->get();

        // $user_verifikator_pd = User::whereHas('role_user', function ($q){
        //     $q->where('name','verifikator_pd');
        // })->with(array('organisasi'))->get();

        return view('admin.jns_pelayanan.create', compact('team', 'user_eselon_3', 'user_koordinator'));
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

            'pelayanan' => 'required',

        ]);

        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }
        $jenis_pelayanan = new JnspelayananModel;
        $jenis_pelayanan->pelayanan = $request->input('pelayanan');
        $jenis_pelayanan->penanggung_jawab_id = $request->input('png_jawab');
        $jenis_pelayanan->koordinator_penanggung_jawab_id = $request->input('koordinator_agent');
        $jenis_pelayanan->persyaratan= $request->input('syarat');
        if($request->has('notif_eselon3')){
            $jenis_pelayanan->notif_eselon3=1;
        }else{
            $jenis_pelayanan->notif_eselon3=0;
        }
        if($request->has('notif_koordinator_agen')){
            $jenis_pelayanan->notif_koordinator_agen=1;
        }else{
            $jenis_pelayanan->notif_koordinator_agen=0;
        }
        if($request->has('notif_team_leader')){
            $jenis_pelayanan->notif_team_leader=1;
        }else{
            $jenis_pelayanan->notif_team_leader=0;
        }
        // $jenis_pelayanan = JnspelayananModel::create([

        //     'pelayanan' => $request->input('pelayanan'),
        //     'penanggung_jawab_id' => $request->input('png_jawab'),
        //     'koordinator_penanggung_jawab_id' => $request->input('koordinator_agent'),
        //     'persyaratan' => $request->input('syarat'),

        // ]);
        $jenis_pelayanan->save();

        $array_flow_layanan = $request->input('flow_layanan');
        $total_stage = 0;
        foreach ($array_flow_layanan as $key => $layanan) {
            $team_id_index = $key - 2;
            $stage = $key + 1;
            if ($key >= 2) {
                $flowPelayanan = FlowPelayanan::create([
                    'name' => $layanan,
                    'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
                    'koordinator_id' => $request->input('team')[$team_id_index],
                    'stage' => $stage,
                ]);
                $checklist_index = $key + 1;
                foreach ($request->input('checklist_' . $checklist_index) as $array) {
                    Checklist::create([
                        'checklist_name' => $array,
                        'flow_pelayanan_id' => $flowPelayanan->id,
                    ]);
                }
            } else {
                // if($stage == 2)
                // {
                //     $flowPelayanan = FlowPelayanan::create([
                //         'name' => $layanan,
                //         'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
                //         // 'user_koordinator_id'=> $request->input('verifikator_pd_id')
                //     ]);
                // }else{
                $flowPelayanan = FlowPelayanan::create([
                    'name' => $layanan,
                    'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
                    'stage' => $stage,
                ]);
                // }
            }
            $total_stage = $stage;
        }
        $flowPelayanan = FlowPelayanan::create([
            'name' => 'Pemberian Hasil dan BA',
            'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
            'stage' => $total_stage + 1,
        ]);
        $flowPelayanan = FlowPelayanan::create([
            'name' => 'User membalas BA dan Survei',
            'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
            'stage' => $total_stage + 2,
        ]);
        $flowPelayanan = FlowPelayanan::create([
            'name' => 'Penutupan Permintaan Layanan',
            'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
            'stage' => $total_stage + 3,
        ]);
        $flowPelayanan = FlowPelayanan::create([
            'name' => 'Tiket Permintaan Ditutup',
            'jns_pelayanan_id' => $jenis_pelayanan->id_pelayanan,
            'stage' => $total_stage + 4,
        ]);

        return redirect()->route('jns_pelayanan.index')->with('success', 'Pelayanan "' . $request->input('pelayanan') . '" berhasil ditambahkan!');
    }

    /**

     * Display the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {

        $data['jns_pelayanan'] = JnspelayananModel::where('id_pelayanan', '=', $id)
            ->with(array('flowPelayanan', 'flowPelayanan.team', 'penanggungJawabEselon3', 'koordinatorAgen',
                'flowPelayanan.team.member', 'flowPelayanan.checklist'))->first();
        if (!$data['jns_pelayanan']) {
            return view('errors.404');
        }

        return view('admin.jns_pelayanan.detail', $data);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {

        $jns_pelayanan = JnspelayananModel::find($id);

        if (!$jns_pelayanan) {
            return view('errors.404');
        }

        return view('admin.jns_pelayanan.edit', compact('jns_pelayanan'));
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

        $jns_pelayanan = JnspelayananModel::find($id);

        if (!$jns_pelayanan) {
            return view('errors.404');
        }

        $validator = Validator::make($request->all(), [

            'pelayanan' => 'required',

        ]);

        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }

        $jns_pelayanan->pelayanan = $request->input('pelayanan');

        $jns_pelayanan->save();

        return redirect()->route('jns_pelayanan.index')->with('success', 'Server "' . $request->input('pelayanan') . '" berhasil dirubah!');
    }

    /**



     * Remove the specified resource from storage.

     *

     * @param  int id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {

        $jns_pelayanan = JnspelayananModel::find($id);

        if (!$jns_pelayanan) {
            return view('errors.404');
        }

        $jns_pelayanan_name = $jns_pelayanan->pelayanan;

        $jns_pelayanan->delete();

        return redirect()->route('jns_pelayanan.index')->with('success', 'Data Reff Infra "' . $jns_pelayanan_name . '" telah dihapus!');
    }
}
