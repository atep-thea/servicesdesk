<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\FlowPelayanan;
use App\Helper\Common;
use App\JnspelayananModel;
use App\ListChecklistPelayanan;
use App\Organisasi;
use App\Pelayanan;
use App\ReffJnsPelayanan;
use App\Team;
use App\User;
use Auth;
use Datatables;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;
use Validator;

class NewTiketController extends Controller
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

        $role = Auth::user()->role_user;
        if ($role == 'Admin') {
            return view('vendor.adminlte.errors.404');
        }

        $org = Organisasi::all();

        $Agen = DB::table('users')->where('role_user', '=', 3)->get();

        $JnsPlynn = ReffJnsPelayanan::all();

        $Team = Team::all();

        Log::info(Auth::user()->id);

        return view('userportal.newrequest.index', compact('org', 'JnsPlynn', 'Agen', 'Team'));
    }

    public function newTiketData()
    {
        $userId = Auth::user()->id;
        $org = Auth::user()->id_organisasi;
        $query = ReffJnsPelayanan::select('id_pelayanan', 'pelayanan')
            ->orderBy('reff_jns_pelayanan.id_pelayanan', 'ASC')
            ->get();

        return Datatables::of($query)
            ->addColumn('action', function ($item) {

                $pelayanan = ReffJnsPelayanan::find($item['id_pelayanan']);
                $temp = "

                                <a href=''

                                data-jns='" . $item['id_pelayanan'] . "'

                                data-sjns='" . $item['id_sjns_pelayanan'] . "'

                                data-syarat='" . $pelayanan['persyaratan'] . "'

                                class='btn btn-xs btn-default'

                                data-toggle='modal'

                                data-target='#addNew'>

                                    <i class='glyphicon glyphicon-plus-sign'>

                                </a>";

                return $temp;
            })
            ->editColumn('ssjns', function ($item) {
                if (empty($item->ssjns)) {
                    return '<span style="text-align:center"> - </span>';
                } else {
                    return $item->ssjns;
                }
            })

            ->make(true);
    }

    public function getAgen($id)
    {

        $agen_id = DB::table('users')->where("id_team", $id)->pluck("nama_depan", "id");

        return json_encode($agen_id);
    }

    public function formPage(Request $request)
    {
        $jns_pelayanan = ReffJnsPelayanan::where('id_pelayanan', '=', $request->input('jns_pelayanan'))->first();
        return view('userportal.newrequest.form', compact('jns_pelayanan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'surat_dinas' => 'max:8240',
            'lampiran' => 'max:8240'
        ]);

        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();
        }

        $idTeam = Auth::user()->id_team;
        $roleUser = Auth::user()->role_user;
        // User Auth
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $orgId = Auth::user()->id_organisasi;
        //dd($orgId);exit();
        $org = Organisasi::where('id_organisasi', $orgId)->first();

        // Tgl Pelaporan
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_pelaporan = date('Y-m-d H:i:s');

        // Kode Tiket
        $inputJns = $request->input('jns_pelayanan');

        $cek = Pelayanan::get();
        $lastInsert = Pelayanan::latest('id_')->first();
        $split = $lastInsert['kd_tiket'];
        $lastId = substr($split, 5) + 1;
        $firstId = 'P-000';
        $kdTiket = $firstId . $lastId;

        $plynn = new Pelayanan;
        $plynn->kd_tiket = $kdTiket;
        $plynn->id_opd = $userData['id_organisasi'];
        $plynn->id_pelapor = $userId;
        $plynn->judul = $request->input('judul');
        $plynn->deskripsi = $request->input('deskripsi');
        $plynn->contact_person = $request->input('contact_person');
        $plynn->jns_pelayanan = $request->input('jns_pelayanan');

        $plynn->tgl_pelaporan = $tgl_pelaporan;
        $plynn->tgl_update = $tgl_pelaporan;
        $plynn->id_agen = $request->input('agen_id');
        $plynn->status = 'Open';

        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();

        $plynn->stage = $flow_pelayanan->id;

        // LAMPIRAN FILE
        if ($request->hasFile('lampiran')) {
            $attachment = $request->file('lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_lampiran_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $kdTiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $kdTiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $kdTiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $kdTiket . '/';
            }
            $attachment->move($destination_path, $filename);
            $plynn->lampiran = $filename;
        }

        if ($request->hasFile('surat_dinas')) {
            Log::info("MASUK ADA SURAT DINAS");
            $attachment = $request->file('surat_dinas');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_surat_dinas_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $kdTiket . '/')) {

                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $kdTiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $kdTiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $kdTiket . '/';
            }
            $attachment->move($destination_path, $filename);
            $plynn->file_surat_dinas = $filename;
            $target_flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();
            Log::info("MASUK SINI " . $target_flow_pelayanan);
            $plynn->stage = $target_flow_pelayanan->id + 1;
        }
        $team_flow_pelayanan = FlowPelayanan::find($plynn->stage);
        Log::info($plynn->stage);
        Log::info($team_flow_pelayanan);

        $plynn->id_team = $team_flow_pelayanan->koordinator_id;
        Log::info($plynn);
        $jns_pelayanan_id = $plynn->jns_pelayanan;
        $jns_pelayanan = JnspelayananModel::find($jns_pelayanan_id)->with('penanggungJawabEselon3', 'koordinatorAgen')->first();

        $usermail = Auth::user()->email; //Email User

        try
        {

            $judul = $request->input('judul');
            $subject2 = 'Tiket Baru Telah Dibuat';
            $keterangan = $request->input('deskripsi');
            $orgName = $org->nama_opd;

            // EMAIL NEW TIKET FOR USER
            $data = array(
                'email' => $usermail,
                'subject' => $subject2,
                'judul' => $judul,
                'opd' => $orgName,
                'keterangan' => $keterangan,
                'kdTiket' => $kdTiket,
            );

            Mail::send('email.notifUser', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $email_penanggung_jawab = [];
            if ($jns_pelayanan->notif_eselon3 == 1) {
                $email_penanggung_jawab[] = $jns_pelayanan->penanggungJawabEselon3->email;
            }
            if ($jns_pelayanan->notif_koordinator_agen == 1) {
                $email_penanggung_jawab[] = $jns_pelayanan->koordinatorAgen->email;
            }

            $data['email'] = $email_penanggung_jawab;
            Mail::send('email.notifDireksi', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $plynn->save();
        Common::update_timeline("user_action", "Pembuatan tiket baru", "Baru", $plynn->id_, Auth::user()->id);
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->with(array('checklist'))->get();

        foreach ($flow_pelayanan as $flow) {
            foreach ($flow->checklist as $c) {
                ListChecklistPelayanan::create(['flow_pelayanan_id' => $flow->id,
                    'pelayanan_id' => $plynn->id_,
                    'checklist_id' => $c->id]);
            }
        }

        return redirect()->route('request_progress.index')->with('success', 'Tiket Layanan "' . $kdTiket . '" berhasil dibuat!');

    }
}
