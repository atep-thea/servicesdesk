<?php

namespace App\Http\Controllers;

use App\ChatSupport;
use App\ChatSupportAttachment;
use App\FlowPelayanan;
use App\ListChecklistPelayanan;
use App\Pelayanan;
use App\PelayananAgentTask;
use Auth;
use Datatables;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Storage;
use Validator;

class RequestProgressController extends Controller
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

    public function index(Request $request)
    {
        
        $status = $request->input('status');
        Log::info($status);
        return view('userportal.onprogress.index', compact('status'));
    }

    public function reqprgrsData($status = null)
    {
        
        $userId = Auth::user()->id;
        $roleUser = Auth::user()->role_user;
        $idTeam = Auth::user()->id_team;
        $query = Pelayanan::where('pelayanan.id_pelapor', $userId)
            ->with(array('organisasi', 'pelapor', 'agent',
                'flow_pelayanan', 'jenis_pelayanan'));
        if ($roleUser == 'User') { // User

            if ($status == "Open") {
                $query = $query->where('pelayanan.id_pelapor', $userId)
                    ->where('pelayanan.status', '=', $status)
                    ->where('pelayanan.id_agen','=',null);
            } 
            else if($status == "Diproses")
            {
                Log::info("Masuk Diproses");
                $query = $query->where('pelayanan.id_pelapor', $userId)
                ->where('pelayanan.status', '=', $status)
                ->where('pelayanan.id_agen','!=',null);
            }
             else if ($status != null) {
                $query = $query->where('pelayanan.id_pelapor', $userId)
                    ->where('pelayanan.status', '=', $status);
            } else if ($status == null) {
                $query = $query->where('pelayanan.id_pelapor', $userId)
                    ->whereIn('pelayanan.status', array('Diproses', 'Open'));
            }
            $query = $query->orderBy('pelayanan.tgl_pelaporan', 'DESC')->get();

        } else if ($roleUser == 'Helpdesk') { //helpdesk
            $query = $query->where('pelayanan.id_pelapor', '=', $userId)->orderBy('pelayanan.tgl_pelaporan', 'DESC')
                ->whereIn('pelayanan.status', array('Ditunda', 'Baru', 'Diproses', 'Pending', 'Disposisi'))
            //->where('pelayanan.id_team','=',$idTeam)
                ->get();
        } else {
            $query = $query->whereIn('pelayanan.status', array('Ditunda', 'Baru', 'Diproses', 'Pending', 'Disposisi'))
            // ->orderBy('pelayanan.tgl_pelaporan', 'DESC')
                ->get();
        }

        return Datatables::of($query)
            ->editColumn('kd_tiket', function ($item) {
                return "<a href='" . route('request_progress.show', $item->id_) . "'>" . $item->kd_tiket . "</a>";
            })
            ->addColumn('nama_agen', function ($item) {
                if ($item->agent == null) {
                    return "Belum Di Tentukan";
                } else {
                    return $item->agent->nama_depan;
                }
            })
            ->addColumn('proses_name', function ($item) {
                if ($item->flow_pelayanan == null) {
                    return "";
                } else {
                    return $item->flow_pelayanan->name;
                }
            })
            ->make(true);
    }

    public function submitRating(Request $request)
    {
        Pelayanan::find($request->input('pelayanan_id'))->update(['survey_rate' => $request->input('rating')]);
        return redirect()->route('request_progress.show', $request->input('pelayanan_id'))->with('success', 'Berhasil');
    }

    public function chatSupport(Request $request)
    {

        $userId = Auth::user()->id;
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        $pelayanan = Pelayanan::find($request->input('pelayanan_id'));
        $chat = $request->input('chat');
        $data = array();
        if ($request->hasFile('lampiran')) {

            foreach ($request->file('lampiran') as $file) {
                $attachment = $file;
                $extension = $attachment->getClientOriginalExtension();
                $attachment_real_path = $attachment->getRealPath();
                $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
                $filename = date('Ymdhis') . '_' . $real_filename;
                if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                    $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                    if ($result) {
                        $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                    }
                } else {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
                $attachment->move($destination_path, $filename);
                $data[] = $filename;
            }
        }

        $chat = new ChatSupport;
        $chat->chat = $request->input('chat');
        $chat->user_id = $userId;
        $chat->pelayanan_id = $request->input('pelayanan_id');
        $chat->save();
        if (count($data) > 0) {
            foreach ($data as $fileData) {
                $chat_attachment = new ChatSupportAttachment;
                $chat_attachment->chat_id = $chat->id;
                $chat_attachment->pelayanan_id = $chat->pelayanan_id;
                $chat_attachment->filename = $fileData;

                $chat_attachment->save();
            }
        }

        return redirect()->route('request_progress.show', $chat->pelayanan_id)->with('success', 'Berhasil');
    }

    public function create()
    {
        $parent_org = Pelayanan::all();
        return view('userportal.onprogress.create', compact('parent_org'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);

        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();

        if ($data->count()) {
            foreach ($data as $key => $value) {
                $arr[] = ['nama_opd' => $value->nama_opd, 'induk_organisasi' => $value->induk_organisasi, 'nama_pengelola' => $value->nama_pengelola, 'email' => $value->email, 'no_hp_pengelola' => $value->no_hp_pengelola, 'status' => $value->status];
            }

            if (!empty($arr)) {
                Pelayanan::insert($arr);
            }
        }
        return back()->with('success', 'Import data Excel Sukses..!!');
    }

    public function exportExcel(Request $request)
    {
        $data['title'] = 'Data Organisasi';
        $data['org'] = Pelayanan::all();
        Excel::create('Data Organisasi ' . date('Y') . '', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {

                $sheet->loadView('userportal.onprogress.excel_view', $data);
            });
        })->export('xls');
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
            'nama_opd' => 'required',
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
        Pelayanan::create([
            'induk_organisasi' => $request->input('induk_organisasi'),
            'nama_opd' => $request->input('nama_opd'),
            'nama_pengelola' => $request->input('nama_pengelola'),
            'no_hp_pengelola' => $request->input('no_hp_pengelola'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('request_progress.index')->with('success', 'Perangkat organisasi "' . $request->input('nama_opd') . '" berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $data_pelayanan = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')

            ->leftjoin(
                'reff_jns_pelayanan',
                'reff_jns_pelayanan.id_pelayanan',
                '=',
                'pelayanan.jns_pelayanan'
            )
            ->select(
                'pelayanan.id_',
                'users.id',
                'reff_jns_pelayanan.pelayanan as plynn',
                'organisasi.nama_opd',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'pelayanan.solusi',
                'pelayanan.id_pelapor',
                'pelayanan.tgl_pelaporan',
                'pelayanan.tgl_update',
                'organisasi.induk_organisasi',
                'users.nama_depan as nama_agen',
                'users.nama_belakang',
                'pelayanan.id_opd',
                'pelayanan.deskripsi as desk',
                'pelayanan.status as status_tiket',
                'pelayanan.id_agen as agenID',
                'pelayanan.desk_balasan',
                'pelayanan.komen_slaba','pelayanan.ba_bls',
                'pelayanan.file_ba','pelayanan.lampiran_balasan',
                'flow_pelayanan.name as proses_name',
                'pelayanan.contact_person',
                'pelayanan.jns_pelayanan', 'pelayanan.file_surat_dinas', 'pelayanan.lampiran', 'pelayanan.stage', 'pelayanan.survey_rate'
            )
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage', 'pelayanan.stage')
            ->where('pelayanan.id_', '=', $id)->with(array('timelines', 'timelines.timelineDetails'))
            ->with(array('chat_support', 'chat_support.attachment', 'chat_support.user', 'attachment'))
            ->first();
        $data['progress'] = $data_pelayanan;
        if (!$data['progress']) {
            return view('errors.404');
        }

        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $data_pelayanan->jns_pelayanan)->with(array('checklist'))->get();
        $data['checklist'] = ListChecklistPelayanan::where('flow_pelayanan_id', '=', $data_pelayanan->stage)
            ->where('pelayanan_id', '=', $id)->with(array('checklist'))->get();
        $data['flow_pelayanan'] = $flow_pelayanan;
        $total_flow = count($flow_pelayanan);
        $current_stage = 1;
        $completed_stage = true;
        foreach ($data['checklist'] as $checklist) {
            if (is_null($checklist->status)) {
                $completed_stage = false;
            }
        }
        $data['completed_stage'] = $completed_stage;
        foreach ($flow_pelayanan as $flow) {

            if ($flow->id == $data_pelayanan->stage) {
                $current_stage = $flow->stage;
            }
        }
        $data['total_flow'] = $total_flow;
        $data['current_stage'] = $current_stage;
        $solusiTask = PelayananAgentTask::where('pelayanan_id', '=', $id)->where('final_solution','=',1)->with(array('attachment', 'user'))
        ->first();
        $data['solusiTask']=$solusiTask;
        return view('userportal.onprogress.detail_progress', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['request_progress'] = Pelayanan::find($id);
        $data['parent_org'] = Pelayanan::where('induk_organisasi', '=', '')
            ->orWhere('induk_organisasi', '=', null)->get();
        //dd($data['request_progress']);exit();
        if (!$data['request_progress']) {
            return view('errors.404');
        }

        return view('userportal.onprogress.edit', $data);
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
        if (Input::get('update')) {
            var_dump('ini updatan ' . $id);
            exit();
        } else {
            var_dump('ini tidak produktif');
            exit();
        }
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organisasi = Pelayanan::find($id);

        if (!$organisasi) {
            return view('errors.404');
        }

        $organisasi_name = $organisasi->nama_opd;

        $organisasi->delete();

        return redirect()->route('request_progress.index')->with('success', 'Data organisasi "' . $organisasi_name . '" telah dihapus!');
    }
}
