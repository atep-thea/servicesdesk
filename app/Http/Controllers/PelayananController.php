<?php

namespace App\Http\Controllers;

use App\AgentTaskAttachment;
use App\AssignmentHistory;
use App\ChatSupport;
use App\ChatSupportAttachment;
use App\FlowPelayanan;
use App\Helper\Common;
use App\JnspelayananModel;
use App\ListChecklistPelayanan;
use App\Organisasi;
use App\Pelayanan;
use App\PelayananAgentTask;
use App\ReffJnsPelayanan;
use App\Subsubkategori;
use App\Team;
use App\User;
use Auth;
use DB;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mail;
use Storage;
use Yajra\Datatables\Facades\Datatables;

class PelayananController extends Controller
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
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index', compact('role'));
    }

    public function helpdeskPelayanan($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_helpdesk', compact('role', 'status'));
    }

    public function validatorPDPelayanan($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_validator_pd', compact('role', 'status'));
    }

    public function koordinatorAgenPelayananPage($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_koordinator_agen', compact('role', 'status'));
    }

    public function agenPelayananPage($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_agen', compact('role', 'status'));
    }

    public function pelayananDataUnverifiedPage($status_task = null)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.pelayanan_data_unverified', compact('role', 'status_task'));
    }
    public function eselon3PelayananPage($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_eselon3', compact('role', 'status'));
    }
    public function superAdminPelayananPage($status)
    {
        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.index_pelayanan_superadmin', compact('role', 'status'));
    }

    public function historyTiket()
    {

        $home = User::all();
        $role = Auth::user()->role_user;
        if (!$home || $role == 'User') {
            return view('vendor.adminlte.errors.404');
        }

        return view('admin.pelayanan.history_pelayanan_agen', compact('role'));
    }

    public function pelayananAgentTaskData(Request $request, $pelayanan_id)
    {
        $pelayanan = Pelayanan::find($pelayanan_id);
        $query = PelayananAgentTask::where('final_solution', '=', 1)
            ->where('pelayanan_id', '=', $pelayanan_id)
            ->with(array('user', 'attachment', 'flow'))->get();
        return Datatables::of($query)
            ->addColumn('stage', function (PelayananAgentTask $agent_task) {
                return $agent_task->flow->stage;
            })
            ->addColumn('solusi', function (PelayananAgentTask $agent_task) {
                return $agent_task->task_report;
            })
            ->addColumn('lampiran', function (PelayananAgentTask $agent_task) use ($pelayanan) {
                if (empty($agent_task->attachment)) {
                    return "No Attachment";
                } else {
                    foreach ($agent_task->attachment as $attachment) {
                        if ($attachment->is_ba == 0) {

                            return '<a href="' . url('public/lampiran/' . $pelayanan->kd_tiket . '/' . $agent_task->attachmentFinalSolution->filename) . '">' . $agent_task->attachmentFinalSolution->filename . '</a>';
                        } else {
                            return "Tidak ada lampiran";
                        }
                    }

                }
            })
            ->addColumn('berita_acara', function (PelayananAgentTask $agent_task) use ($pelayanan) {
                if (empty($agent_task->attachment)) {
                    return "No Attachment";
                } else {
                    foreach ($agent_task->attachment as $attachment) {
                        if ($attachment->is_ba == 1) {
                            return '<a href="' . url('public/lampiran/' . $pelayanan->kd_tiket . '/' . $agent_task->attachmentFinalSolution->filename) . '">' . $agent_task->attachmentFinalSolution->filename . '</a>';
                        } else {return "Tidak ada Berita Acara";}
                    }

                }
            })
            ->addColumn('nama_agen', function (PelayananAgentTask $agent_task) {
                return $agent_task->user->nama_depan;
            })
            ->addColumn('nama_stage', function (PelayananAgentTask $agent_task) {
                return $agent_task->flow->name;
            })
            ->make(true);
    }

    public function pelayananAgentTaskAttachmentData(Request $request, $pelayanan_id)
    {
        $query_agen_task_attachment = AgentTaskAttachment::where('pelayanan_id', '=', $pelayanan_id)
            ->with(array('agent_task', 'agent_task.user', 'agent_task.flow'));
        return Datatables::eloquent($query_agen_task_attachment)
            ->addColumn('stage', function (AgentTaskAttachment $agent_task) {
                return $agent_task->agent_task->flow->stage;
            })
            ->addColumn('lampiran', function (AgentTaskAttachment $agent_task) {
                return '<a href="' . url('public/lampiran/' . $agent_task->filename) . '">' . $agent_task->filename . '</a>';
            })
            ->addColumn('nama_agen', function (AgentTaskAttachment $agent_task) {
                return $agent_task->agent_task->user->nama_depan;
            })
            ->addColumn('nama_stage', function (AgentTaskAttachment $agent_task) {
                return $agent_task->agent_task->flow->name;
            })
            ->make(true);
    }

    public function pelayananDataEselon3(Request $request, $status = null)
    {
        $query_pelayanan = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage')
            ->select(
                'pelayanan.id_ as ids',
                'organisasi.nama_opd',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'pelayanan.id_pelapor',
                'pelayanan.tgl_pelaporan',
                'users.nama_depan as nama_agen',
                'users.nama_belakang',
                'pelayanan.status as status_tiket',
                'pelayanan.id_agen as agenID',
                'flow_pelayanan.name as proses_name',
                'flow_pelayanan.stage as step'
            );
        // ->orderBy('pelayanan.tgl_pelaporan', 'DESC');
        // }
        $current_logged_user = Auth::user();
        $query_pelayanan = $query_pelayanan->whereHas('jns_pelayanan', function ($query) use ($current_logged_user) {
            return $query->where('penanggung_jawab_id', '=', $current_logged_user->id)->where('flow_pelayanan.name', '!=', 'Validasi Permintaan Layanan');
        });

        if ($status == 'Diproses') {
            $query = $query_pelayanan
                ->where('pelayanan.status', '=', $status)
                ->orWhere('pelayanan.status', '=', 'Selesai')
                ->get();
        } else {
            $query = $query_pelayanan->where('pelayanan.status', '=', $status)->get();
        }

        return Datatables::of($query)
            ->addColumn('action', function ($item) {
                $roleUser = Auth::user()->role_user;
                if ($roleUser == 'Admin') {
                    $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                            <a href=" . route('pelayanan.edit', $item->ids) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                    $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                            <a href='#delete' data-delete-url=" . route('pelayanan.destroy', $item->ids) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                } else {
                    $temp = "";
                }
                return $temp;
            })
            ->editColumn('kd_tiket', function ($item) {
                $roleUser = Auth::user()->role_user;
                if (in_array($roleUser, array('Agen', 'Admin', 'Koordinator Agen', 'Eselon 3'))) {
                    return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                } else if ($roleUser == 'Verifikator PD') {
                    if ($item->step == 2) {
                        return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                    } else {
                        return $item->kd_tiket;
                    }
                }
            })
        // ->editColumn('nama_agen', function($item) {
        //     return "<a href='".route('user.show', $item->agenID)."'>".$item->nama_agen.' '.$item->nama_belakang."</a>";
        // })
            ->editColumn('status_tiket', function ($item) {
                if ($item->status_tiket == 'Selesai') {
                    $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Open') {
                    $span = '<h5><span class="label label-primary" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Close') {
                    $span = '<h5><span class="label label-default" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Diproses') {
                    $span = '<h5><span class="label" style="background-color:#00B5AD;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Pending') {
                    $span = '<h5><span class="label" style="background-color:#A5673F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Disposisi') {
                    $span = '<h5><span class="label" style="background-color:#E03997;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Re-Open') {
                    $span = '<h5><span class="label" style="background-color:#DE627F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                }
                //return $span.$item->status_tiket.'</span></h5>';
            })
            ->make(true);
    }

    public function pelayananDataHistoryClosed(Request $request)
    {
        $query_pelayanan = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage')
            ->select(
                'pelayanan.id_ as ids',
                'organisasi.nama_opd',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'pelayanan.id_pelapor',
                'pelayanan.tgl_pelaporan',
                'users.nama_depan as nama_agen',
                'users.nama_belakang',
                'pelayanan.status as status_tiket',
                'pelayanan.id_agen as agenID',
                'flow_pelayanan.name as proses_name',
                'flow_pelayanan.stage as step'
            )
            ->orderBy('pelayanan.tgl_pelaporan', 'DESC');
        // }
        $current_logged_user = Auth::user();
        $query_pelayanan = $query_pelayanan->whereHas('agent_task', function ($query) use ($current_logged_user) {
            return $query->whereIn('user_agent', array($current_logged_user->id));
        });

        $query = $query_pelayanan->where('pelayanan.status', '=', 'Selesai')->get();

        return Datatables::of($query)
            ->addColumn('action', function ($item) {
                $roleUser = Auth::user()->role_user;
                if ($roleUser == 'Admin') {
                    $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                            <a href=" . route('pelayanan.edit', $item->ids) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                    $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                            <a href='#delete' data-delete-url=" . route('pelayanan.destroy', $item->ids) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                } else {
                    $temp = "";
                }
                return $temp;
            })
            ->editColumn('kd_tiket', function ($item) {
                $roleUser = Auth::user()->role_user;
                if (in_array($roleUser, array('Agen', 'Admin', 'Koordinator Agen'))) {
                    return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                } else if ($roleUser == 'Verifikator PD') {
                    if ($item->step == 2) {
                        return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                    } else {
                        return $item->kd_tiket;
                    }
                }
            })
        // ->editColumn('nama_agen', function($item) {
        //     return "<a href='".route('user.show', $item->agenID)."'>".$item->nama_agen.' '.$item->nama_belakang."</a>";
        // })
            ->editColumn('status_tiket', function ($item) {
                if ($item->status_tiket == 'Selesai') {
                    $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Baru') {
                    $span = '<h5><span class="label label-primary" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Close') {
                    $span = '<h5><span class="label label-default" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Diproses') {
                    $span = '<h5><span class="label" style="background-color:#00B5AD;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Pending') {
                    $span = '<h5><span class="label" style="background-color:#A5673F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Disposisi') {
                    $span = '<h5><span class="label" style="background-color:#E03997;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Re-Open') {
                    $span = '<h5><span class="label" style="background-color:#DE627F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                }
                //return $span.$item->status_tiket.'</span></h5>';
            })
            ->make(true);
    }

    public function pelayananDataUnverified(Request $request, $status_task = null)
    {
        Log::info("Pelayanan Data Unverified " . $status_task);
        $query_pelayanan = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage')
            ->select(
                'pelayanan.id_ as ids',
                'organisasi.nama_opd',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'pelayanan.id_pelapor',
                'pelayanan.tgl_pelaporan',
                'users.nama_depan as nama_agen',
                'users.nama_belakang',
                'pelayanan.status as status_tiket',
                'pelayanan.id_agen as agenID',
                'flow_pelayanan.name as proses_name',
                'flow_pelayanan.stage as step'
            )
            ->orderBy('pelayanan.tgl_pelaporan', 'DESC')
            ->whereHas('agent_task_last', function ($query) use ($status_task) {
                return $query->where('status', '=', 1)->where('final_solution', '=', null);
            });

        $current_logged_user = Auth::user();

        $query_pelayanan = $query_pelayanan
            ->where('pelayanan.status', '=', 'Diproses')
            // ->orWhere('flow_pelayanan.stage', '>=',3)
            ->whereHas('jns_pelayanan', function ($query) use ($current_logged_user) {
                return $query->where('koordinator_penanggung_jawab_id', '=', $current_logged_user->id);
            });
        Log::info($query_pelayanan->toSql());
        $query = $query_pelayanan->get();

        return Datatables::of($query)
            ->addColumn('action', function ($item) {
                $roleUser = Auth::user()->role_user;
                if ($roleUser == 'Admin') {
                    $temp = "<span data-toggle='tooltip' title='Edit Posting'>
                            <a href=" . route('pelayanan.edit', $item->ids) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

                    $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
                            <a href='#delete' data-delete-url=" . route('pelayanan.destroy', $item->ids) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
                } else {
                    $temp = "";
                }
                return $temp;
            })
            ->editColumn('kd_tiket', function ($item) {
                $roleUser = Auth::user()->role_user;
                if (in_array($roleUser, array('Agen', 'Admin', 'Koordinator Agen', 'Helpdesk'))) {
                    return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                } else if ($roleUser == 'Verifikator PD') {
                    if ($item->step == 2) {
                        return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                    } else {
                        return $item->kd_tiket;
                    }
                }
            })
        // ->editColumn('nama_agen', function($item) {
        //     return "<a href='".route('user.show', $item->agenID)."'>".$item->nama_agen.' '.$item->nama_belakang."</a>";
        // })
            ->editColumn('status_tiket', function ($item) {
                if ($item->status_tiket == 'Selesai') {
                    $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Open') {
                    $span = '<h5><span class="label label-primary" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Close') {
                    $span = '<h5><span class="label label-default" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Diproses') {
                    $span = '<h5><span class="label" style="background-color:#00B5AD;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Pending') {
                    $span = '<h5><span class="label" style="background-color:#A5673F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Disposisi') {
                    $span = '<h5><span class="label" style="background-color:#E03997;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Re-Open') {
                    $span = '<h5><span class="label" style="background-color:#DE627F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                }
                //return $span.$item->status_tiket.'</span></h5>';
            })
            ->make(true);
    }

    public function pelayananData(Request $request, $status = null)
    {
        $query_pelayanan = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftJoin('flow_pelayanan', 'flow_pelayanan.id', '=', 'pelayanan.stage')
            ->select(
                'pelayanan.id_ as ids',
                'organisasi.nama_opd',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'pelayanan.id_pelapor',
                'pelayanan.tgl_pelaporan',
                'users.nama_depan as nama_agen',
                'users.nama_belakang',
                'pelayanan.status as status_tiket',
                'pelayanan.id_agen as agenID',
                'flow_pelayanan.name as proses_name',
                'flow_pelayanan.stage as step'
            );
        // ->orderBy('pelayanan.tgl_pelaporan', 'DESC');
        // }
        $current_logged_user = Auth::user();
        if (Auth::user()->role_user == 'Admin') {

            if ($status == 'Open') {
                $query_pelayanan = $query_pelayanan->where('pelayanan.status', '=', $status);
            } else if ($status == 'Diproses') {
                $query_pelayanan = $query_pelayanan
                    ->orWhere('pelayanan.status', '=', $status)
                    ->orWhere('pelayanan.status', '=', 'Selesai');
            } else if ($status = 'Close') {
                $query_pelayanan = $query_pelayanan->where('pelayanan.status', '=', $status);
            }
        } else if (Auth::user()->role_user == 'Verifikator PD') {
            $query_pelayanan = $query_pelayanan->whereHas('pelapor', function ($query) use ($current_logged_user) {
                return $query->where('id_organisasi', '=', $current_logged_user->id_organisasi);
            });
            // $query_pelayanan = $query_pelayanan->where('flow_pelayanan.user_koordinator_id', '=', Auth::user()->id);
            if ($status == 'Open') {
                $query_pelayanan = $query_pelayanan->where('flow_pelayanan.stage', '=', 2)->where('pelayanan.status', '=', $status);
            } else if ($status == 'Close') {
                $query_pelayanan = $query_pelayanan->whereHas('assignment_history', function ($query) use ($current_logged_user) {
                    return $query->where('user_id', '=', $current_logged_user->id);
                });;
            }
        } else if ($current_logged_user->role_user == 'Koordinator Agen') {
            if ($status == 'Open') {
                // $team = DB::table('team_user')->selectRaw('users.id as userId,users.nama_depan as nama_depan ,users.nama_belakang as nama_belakang')
                //             ->join('users','team_user.user_id','users.id')
                //             ->where('team_user.team_id','=',$data['pelayanan']->id_team)->get();
                $query_pelayanan = $query_pelayanan
                    ->where('pelayanan.status', '=', $status)
                    ->where('pelayanan.id_agen', '=', null)
                    ->where('flow_pelayanan.name', '!=', 'Validasi Permintaan Layanan')
                    ->orWhereHas('jenis_pelayanan', function ($query) use ($current_logged_user) {
                        return $query->where('koordinator_penanggung_jawab_id', '=', $current_logged_user->id);
                    })->orWhereHas('flow_pelayanan', function ($query) use ($current_logged_user) {
                        $query->whereHas('team', function ($query) use ($current_logged_user) {
                            $query->whereHas('member', function ($query) use ($current_logged_user) {
                                return $query->where('user_Id', '=', $current_logged_user)->where('leader', '=', 1);
                            });
                        });
                    });;

            } else if ($status == 'Diproses') {
                $query_pelayanan = $query_pelayanan
                    ->where('pelayanan.status', '=', 'Diproses')
                    ->orWhereHas('flow_pelayanan', function ($query) use ($current_logged_user) {
                        $query->whereHas('team', function ($query) use ($current_logged_user) {
                            $query->whereHas('member', function ($query) use ($current_logged_user) {
                                return $query->where('user_Id', '=', $current_logged_user)->where('leader', '=', 1);
                            });
                        });
                    });
                // ->orWhere('pelayanan.status', '=', 'Selesai');

            } else if ($status == 'Ditutup') {
                $query_pelayanan = $query_pelayanan
                    ->where('pelayanan.status', '=', 'selesai')
                    ->whereNotNull('pelayanan.ba_bls')
                    ->whereNotNull('pelayanan.survey_rate');
            } else if ($status = 'Close') {
                $query_pelayanan = $query_pelayanan->where('pelayanan.status', '=', $status);
            }
            $query_pelayanan = $query_pelayanan
                ->whereHas('jns_pelayanan', function ($query) use ($current_logged_user) {
                    return $query->where('koordinator_penanggung_jawab_id', '=', $current_logged_user->id);
                });
        } else if ($current_logged_user->role_user == 'Agen') {

            if ($status == 'Diproses') {
                $query_pelayanan = $query_pelayanan->where('pelayanan.id_agen', '=', $current_logged_user->id)
                    ->whereHas('agent_task_last', function ($query) use ($current_logged_user) {
                        return $query->where('status', '=', 0);
                    });
                // ->where('pelayanan.status', '=', $status);
                // ->orWhere('pelayanan.status', '=', 'Selesai');
            } else if ($status == 'Close') {
                $query_pelayanan = $query_pelayanan->whereHas('agent_task_last', function ($query) use ($current_logged_user) {
                    return $query->where('status', '=', 1)->where('user_agent', '=', $current_logged_user->id);
                })->whereHas('assignment_history', function ($query) use ($current_logged_user) {
                        return $query->where('user_id', '=', $current_logged_user->id);
                    });
            }

            // $query_pelayanan = $query_pelayanan->whereHas('agent_task_last', function ($query) {
            //         return $query->where('status', '=', 0);
            //     });
            // $query_pelayanan = $query_pelayanan->whereHas('agent', function ($query) use ($current_logged_user) {
            //     return $query->where('id', '=', $current_logged_user->id);
            // });

        } else if ($current_logged_user->role_user == 'Helpdesk') {
            if ($status != null) {
                $query_pelayanan = $query_pelayanan->where('pelayanan.status', '=', $status);
            }
        }

        $query = $query_pelayanan->orderBy('pelayanan.tgl_pelaporan', 'DESC')->get();

        Log::info($query_pelayanan->toSql());
        // Log::info(DB::QueryLog());
        return Datatables::of($query)
        // ->addColumn('action', function ($item) {
        //     $roleUser = Auth::user()->role_user;
        //     if ($roleUser == 'Admin') {
        //         $temp = "<span data-toggle='tooltip' title='Edit Posting'>
        //                 <a href=" . route('pelayanan.edit', $item->ids) . " class='btn btn-xs btn-default'><i class='glyphicon glyphicon-edit'></i></a></span>";

        //         $temp .= "<span data-toggle='tooltip' title='Hapus Posting'>
        //                 <a href='#delete' data-delete-url=" . route('pelayanan.destroy', $item->ids) . " role='button' class='btn btn-xs btn-default delete'><i class='fas fa-trash-alt'></i></a></span>";
        //     } else {
        //         $temp = "";
        //     }
        //     return $temp;
        // })
            ->editColumn('kd_tiket', function ($item) {
                $roleUser = Auth::user()->role_user;
                if (in_array($roleUser, array('Agen', 'Admin', 'Koordinator Agen', 'Helpdesk', 'Verifikator PD'))) {
                    return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                }
                // else if ($roleUser == 'Verifikator PD') {
                //     if ($item->step == 2 && $item->status_tiket != 'Close') {
                //         return "<a href='" . route('pelayanan.show', $item->ids) . "'>" . $item->kd_tiket . "</a>";
                //     } else {
                //         return $item->kd_tiket;
                //     }
                // }
            })
            ->editColumn('nama_agen', function ($item) {
                if ($item->nama_agen == null) {
                    return "Belum Di Tentukan";
                } else {
                    return $item->nama_agen . ' ' . $item->nama_belakang;
                }
                return "<a href='" . route('user.show', $item->agenID) . "'>" . $item->nama_agen . ' ' . $item->nama_belakang . "</a>";
            })
            ->editColumn('status_tiket', function ($item) {
                if ($item->status_tiket == 'Selesai') {
                    $span = '<h5><span class="label" style="background-color:#21BA45;padding:3px 8px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Open') {
                    $span = '<h5><span class="label label-primary" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Close') {
                    $span = '<h5><span class="label label-default" style="padding:3px 13px;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Diproses') {
                    $span = '<h5><span class="label" style="background-color:#00B5AD;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Pending') {
                    $span = '<h5><span class="label" style="background-color:#A5673F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Disposisi') {
                    $span = '<h5><span class="label" style="background-color:#E03997;">';
                    return $span . $item->status_tiket . '</span></h5>';
                } elseif ($item->status_tiket == 'Re-Open') {
                    $span = '<h5><span class="label" style="background-color:#DE627F;">';
                    return $span . $item->status_tiket . '</span></h5>';
                }
                //return $span.$item->status_tiket.'</span></h5>';
            })
            ->make(true);
    }

    public function create()
    {
        Log::info("Create New TIcket by admin");
        $org = Organisasi::all();
        $Agen = DB::table('users')
            ->where('role_user', '=', 'Helpdesk')
            ->where('role_user', '!=', 'Admin')
            ->get();
        $user_requester = User::where('role_user', '=', 'User')->get();
        $JnsPlynn = JnspelayananModel::all();

        return view('admin.pelayanan.create', compact('JnsPlynn', 'user_requester'));
    }

    public function prosesTiket($id)
    {

        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        $diproses = Pelayanan::find($id);
        $diproses->tgl_update = $tgl_update;
        $diproses->status = 'Diproses';

        $diproses->stage = $diproses->stage + 1;

        $emailUser = User::where('id', '=', $diproses->id_pelapor)->first();
        // dd($diproses->id_pelapor);exit();
        $org = Organisasi::where('id_organisasi', '=', $emailUser->id_organisasi)->first();
        //dd($org->nama_opd);exit();
        $subject = 'Pemberitahuan Progress Servicedesk';
        $email = array($emailUser->email);
        $judul = $diproses->judul;
        $keterangan = $diproses->deskripsi;
        $tiketKode = $diproses->kd_tiket;
        $mailhelpdesk = array('dwiyanti.nisa@gmail.com', 'dian.ciamis5@gmail.com', 'syaiful.muflih95@gmail.com', 'taufikrahadina10@gmail.com', 'dandimiqbal@gmail.com', 'erigarna@gmail.com', 'agen.grab95@gmail.com', 'muhamadnurgasikemal@gmail.com');

        $data = array(
            'email' => $email,
            'subject' => 'Pemberitahuan Progress Servicedesk',
            'judul' => $judul,
            'keterangan' => $keterangan,
            'tiketKode' => $tiketKode,
            'status' => 'Diproses',
            'org' => $org->nama_opd,
            'code' => 'user',
            'catatan' => $diproses->solusi,
        );

        Mail::send('email.notifStatus', $data, function ($message) use ($data) {
            $message->subject($data['subject']);
            $message->to($data['email']);
            $message->replyTo('servicedesk@jabarprov.go.id');
        });

        $data2 = array(
            'email' => $mailhelpdesk,
            'subject' => 'Pemberitahuan Progress Servicedesk',
            'judul' => $judul,
            'keterangan' => $keterangan,
            'tiketKode' => $tiketKode,
            'status' => 'Selesai',
            'code' => 'helpdesk',
            'org' => $org->nama_opd,
            'catatan' => $diproses->catatan_khusus,
        );

        Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            $message->subject($data2['subject']);
            $message->to($data2['email']);
            //$message->cc($cc);
            $message->replyTo('servicedesk@jabarprov.go.id');
        });
        Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $diproses->status, $diproses->status, $id, Auth::user()->id);

        $diproses->save();
        Common::update_timeline("user_action", "Update Status Tiket Ke status " . $diproses->status, $diproses->status, $id, Auth::user()->id);

        return redirect('pelayanan/' . $id)->with('success', 'Status Tiket Sedang Diproses!');
    }

    public function getSubjns($id)
    {
        $sub_jns_pelayanan = DB::table('reff_sjns_pelayanan')->where("id_pelayanan", $id)->pluck("jenis_pelayanan", "id_sjns_pelayanan");

        return json_encode($sub_jns_pelayanan);
    }

    public function getSsjns($id)
    {
        $ssjns = DB::table('reff_ssjns_pelayanan')->where("id_sjns", $id)->pluck("ssjns", "id_ssjns");

        return json_encode($ssjns);
    }

    public function getAgen($id)
    {

        $agen_id = DB::table('users')
            ->where("id_team", $id)
            ->where('role_user', '!=', 'Admin')
            ->pluck("nama_depan", "id");

        return json_encode($agen_id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idPelapor = $request->id_pelapor;
        $lastInsert = Pelayanan::latest('id_')->first();
        $split = $lastInsert['kd_tiket'];
        $lastId = substr($split, 5) + 1;
        $firstId = 'P-000';
        $kdTiket = $firstId . $lastId;
        // End Attachment
        $user_pelapor = User::find($idPelapor)->first();
        $plynn = new Pelayanan;
        $plynn->kd_tiket = $kdTiket;
        $plynn->id_opd = $user_pelapor->id_organisasi;
        $plynn->judul = $request->input('judul');
        $plynn->deskripsi = $request->input('deskripsi');
        $plynn->jns_pelayanan = $request->input('jns_pelayanan');
        $plynn->status = 'Open';
        $plynn->id_pelapor = $idPelapor;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();
        $plynn->stage = $flow_pelayanan->id;
        $plynn->contact_person = $request->input('contact_person');

        // LAMPIRAN FILE
        if ($request->hasFile('lampiran')) {
            $attachment = $request->file('lampiran');
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
            $plynn->lampiran = $filename;
        }

        if ($request->hasFile('surat_dinas')) {
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
            $plynn->stage = $target_flow_pelayanan->id + 1;
        }
        $plynn->save();

        return redirect()->route('pelayanan.index')->with('success', 'Tiket Permintaan ' . $kdTiket . ' berhasil ditambahkan!');
    }
    public function chatUser(Request $request)
    {
        Log::info("Masuk Sini");

        $userId = Auth::user()->id;
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);

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

        return redirect()->route('pelayanan.show', $chat->pelayanan_id)->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pelayanan'] = Pelayanan::with(array(
            'jenis_pelayanan', 'pelapor', 'agent', 'agent.team','agent_task_last','team', 'team.member',
        ))
            ->find($id);
        Log::info($data['pelayanan']->id_agen);
        $data['syarat'] = json_encode($data['pelayanan']->jenis_pelayanan->persyaratan);
        $data['current_logged_user'] = Auth::user();
        $data['org'] = Organisasi::all();
        $data['Agen'] = DB::table('users')->where('role_user', '=', 'Helpdesk')->get();
        $data['JnsPlynn'] = ReffJnsPelayanan::all();
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $data['pelayanan']['jns_pelayanan'])
            ->with(array('checklist'))->get();
        $data['checklist'] = ListChecklistPelayanan::where('flow_pelayanan_id', '=', $data['pelayanan']['stage'])->where('pelayanan_id', '=', $id)->with(array('checklist'))->get();
        $data['flow_pelayanan'] = $flow_pelayanan;
        // $data['team_member']=Team::where("id_team","=",$data['pelayanan']->id_team)->with(array('member'))->first();
        // Log::info($data['team_member']);
        $total_flow = count($flow_pelayanan);
        $current_stage = 1;
        $completed_stage = true;
        Log::info(count($data['checklist']));
        foreach ($data['checklist'] as $checklist) {
            if (is_null($checklist->status)) {
                $completed_stage = false;
            }
        }
        $data['completed_stage'] = $completed_stage;
        foreach ($flow_pelayanan as $flow) {
            if ($flow->id == $data['pelayanan']->stage) {
                $current_stage = $flow->stage;
            }
        }
        $data['total_flow'] = $total_flow;
        $data['current_stage'] = $current_stage;

        $next_flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $data['pelayanan']['jns_pelayanan'])
            ->where('id', '=', $data['pelayanan']['stage'] + 1)->first();

        $before_end = false;
        if (!empty($next_flow_pelayanan->name)) {
            if ($next_flow_pelayanan->name == 'Pemberian Hasil dan BA') {
                $before_end = true;
            }
        }
        $progres_agen = PelayananAgentTask::where('pelayanan_id', '=', $id)->with(array('attachment', 'user'))
            ->get();

        $data['before_end'] = $before_end;
        $data['progres_agen'] = $progres_agen;
        $data['last_progres_agen'] = false;
        if (!$progres_agen->isEmpty()) {

            $data['last_progres_agen'] = $progres_agen[count($progres_agen) - 1];
        }

        if (!$data['pelayanan']) {
            return view('errors.404');
        }

        $agen = DB::table('team_user')->selectRaw('users.id as userId,users.nama_depan as nama_depan ,users.nama_belakang as nama_belakang')
            ->join('users', 'team_user.user_id', 'users.id')->where('team_user.leader', '=', 0)
            ->where('team_user.team_id', '=', $data['pelayanan']->id_team)->get();

        $data['agen'] = $agen;
        return view('admin.pelayanan.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //var_dump('edit pelayanan');exit();
        $current_logged_user = Auth::user();

        $pelayanan = Pelayanan::with(array('flow_pelayanan', 'pelapor', 'agent'))
            ->where('id_', '=', $id)
            ->with(['team', 'team.member' => function ($q) {
                // Query the name field in status table
                $q->where('leader', '!=', 1); // '=' is optional
            }])
            ->first();

        $org = Organisasi::all();

        $agen = User::where('id_team', '=', $pelayanan->id_team)
            ->get();

        $JnsPlynn = ReffJnsPelayanan::all();
        // $SjnsPlynn = ReffSjnsPelayanan::all();
        // $TipePermin = ReffTipePermintaan::all();
        // $Urgensi = ReffUrgensi::all();
        $Ssjns = Subsubkategori::all();
        $Team = Team::all();
        if (!$pelayanan) {
            return view('errors.404');
        }

        $progres_agen = PelayananAgentTask::where('pelayanan_id', '=', $id)
            ->where('stage', '=', $pelayanan->stage)->latest('id')
            ->first();

        $checklist = ListChecklistPelayanan::where('pelayanan_id', '=', $id)->where('flow_pelayanan_id', '=', $pelayanan->stage)->with(array('checklist'))->get();
        foreach ($checklist as $c) {
        }
        return view('admin.pelayanan.edit', compact('pelayanan', 'Team', 'org', 'agen', 'checklist', 'JnsPlynn', 'current_logged_user', 'progres_agen'));
    }

    public function downloadfile(Request $request, $id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('images/lampiran') . '/' . $data->lampiran;
        return response()->download($file_path);
    }

    public function downloadBalasan(Request $request, $id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('lampiran').'/'.$data->kd_tiket . '/' . $data->lampiran_balasan;
        return response()->download($file_path);
    }

    public function downloadTaskAttachment(Request $request, $kd_tiket, $id)
    {
        $data = DB::table('agent_task_attachment')->where('id', $id)->first();
        $file_path = public_path('lampiran') . '/' . $kd_tiket . '/' . $data->filename;
        return response()->download($file_path);
    }

    public function nextStage($id, $current_stage)
    {
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        $pelayanan = Pelayanan::with(array('agent', 'pelapor', 'team', 'team.member'))->find($id);
        $prev_agent = $pelayanan->agent->id;
        $pelayanan->tgl_update = $tgl_update;

        $nextStage = $pelayanan->stage + 1;

        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->where('id', '=', $nextStage)->first();
        if ($flow_pelayanan == null) {
            $pelayanan->status = 'Close';
        } else {
            $pelayanan->id_team = $flow_pelayanan->koordinator_id;
            $pelayanan->id_agen = null;
            if ($nextStage > 3) {
                $pelayanan->status = 'Diproses';
            }
            if ($flow_pelayanan->name == 'Pemberian Hasil dan BA') {
                $pelayanan->status = 'Selesai';
                $pelayanan->id_agen = $prev_agent;
            }
            if ($flow_pelayanan->name == 'User membalas BA dan Survei') {
                $pelayanan->status = 'Selesai';
                $pelayanan->id_agen = $prev_agent;
            }
            if ($flow_pelayanan->name == 'Penutupan Permintaan Layanan') {
                $pelayanan->status = 'Selesai';
                $pelayanan->id_agen = $prev_agent;
            }
            if ($flow_pelayanan->name == 'Selesai') {
                $pelayanan->status = 'Selesai';
                $pelayanan->id_agen = $prev_agent;
            }
            $pelayanan->stage = $nextStage;
        }

        $emailUser = $pelayanan->pelapor->email;
        $org = Organisasi::where('id_organisasi', '=', $pelayanan->pelapor->id_organisasi)->first();

        $jns_pelayanan_id = $pelayanan->jns_pelayanan;
        $jns_pelayanan = JnspelayananModel::find($jns_pelayanan_id)->with('penanggungJawabEselon3', 'koordinatorAgen')->first();

        $email_penanggung_jawab = [];
        if ($jns_pelayanan->notif_eselon3 == 1) {
            $email_penanggung_jawab[] = $jns_pelayanan->penanggungJawabEselon3->email;
        }
        if ($jns_pelayanan->notif_koordinator_agen == 1) {
            $email_penanggung_jawab[] = $jns_pelayanan->koordinatorAgen->email;
        }
        if ($pelayanan->id_agen != null) {
            $email_penanggung_jawab[] = $pelayanan->agent->email;
        }
        try {
            $subject = 'Pemberitahuan Progress Servicedesk';
            $email = array($emailUser);
            $judul = $pelayanan->judul;
            $keterangan = $pelayanan->deskripsi;
            $tiketKode = $pelayanan->kd_tiket;

            $data = array(
                'email' => $email,
                'subject' => $subject,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'tiketKode' => $tiketKode,
                'status' => 'Diproses',
                'org' => $org->nama_opd,
                'code' => 'user',
                'catatan' => $pelayanan->solusi,
            );

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $data2 = array(
                'email' => $email_penanggung_jawab,
                'subject' => $subject,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'tiketKode' => $tiketKode,
                'status' => 'Proses ke langkah selanjutnya',
                'code' => 'helpdesk',
                'org' => $org->nama_opd,
                'catatan' => $pelayanan->catatan_khusus,
            );

            Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
                $message->subject($data2['subject']);
                $message->to($data2['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $pelayanan->status, $pelayanan->status, $id, Auth::user()->id);

        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $flow_pelayanan->name, $flow_pelayanan->name, $id, Auth::user()->id);
        if (Auth::user()->role_user == 'Verifikator PD') {
            return redirect()->route('pelayanan.index')->with('success', 'Status Tiket Berubah ke ' . $flow_pelayanan->name);
        } else {
            return redirect('pelayanan/' . $id)->with('success', 'Progress Tiket Berubah');
        }
    }

    public function closeTiket($id)
    {
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        $pelayanan = Pelayanan::with(array('agent', 'pelapor', 'team', 'team.member'))->find($id);
        $prev_agent = $pelayanan->agent;
        $pelayanan->tgl_update = $tgl_update;

        $pelayanan->status = 'Close';

        $emailUser = User::where('id', '=', $pelayanan->id_pelapor)->first();

        $org = Organisasi::where('id_organisasi', '=', $emailUser->id_organisasi)->first();

        try {

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $data2 = array(
                'email' => $mailhelpdesk,
                'subject' => $subject,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'tiketKode' => $tiketKode,
                'status' => 'Proses ke langkah selanjutnya',
                'code' => 'helpdesk',
                'org' => $org->nama_opd,
                'catatan' => $pelayanan->catatan_khusus,
            );

            Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
                $message->subject($data2['subject']);
                $message->to($data2['email']);
                //$message->cc($cc);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });
            Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $pelayanan->status, $pelayanan->status, $id, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $pelayanan->status, $pelayanan->status, $id, Auth::user()->id);

        return redirect()->route('pelayanan.show', $id)->with('success', 'Progress Tiket Berubah');
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
        $statusTiket = $request->input('statusTiket');
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');

        if ($request->has('list_checklist')) {
            ListChecklistPelayanan::whereIn('id', $request->list_checklist)->update(array('status' => 1));
            ListChecklistPelayanan::whereNotIn('id', $request->list_checklist)->update(array('status' => null));

            $list_checklist_data = ListChecklistPelayanan::where('pelayanan_id', '=', $id)->get();

            foreach ($list_checklist_data as $lcd) {
                $input_name = $lcd->id . '-detailChecklist';
                $detail = $request->input($input_name);
                $lcd->detail = $detail;
                $lcd->save();
            }
        }
        // === SAVE DATA === //
        $pelayanan = Pelayanan::with(array('jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3', 'jenis_pelayanan.koordinatorAgen', 'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org'))->find($id);
        if (!$pelayanan) {
            return view('errors.404');
        }

        if ($pelayanan->flow_pelayanan->name == 'Pemberian Hasil dan BA') {
            $pelayanan->komenf_slaba = $request->input('komen_slaba');
            // 2 => Check
            // 1 => Selesai
            // 0 => Perbaiki
            //  Null => Belum Dikerjakan
            $pelayanan->status_ba_agent = 2;
            if ($request->hasFile('file_ba')) {
                $attachment3 = $request->file('file_ba');
                $extension3 = $attachment3->getClientOriginalExtension();
                $attachment_real_path3 = $attachment3->getRealPath();
                $filename3 = str_random(5) . date('Ymdhis') . '.' . $extension3;

                if (!File::exists(getcwd() . '/public/BA/' . $pelayanan->kd_tiket)) {
                    $result3 = File::makeDirectory(getcwd() . '/public/BA/' . $pelayanan->kd_tiket . '/', 0777, true);
                    if ($result3) {
                        $destination_path3 = getcwd() . '/public/BA/' . $pelayanan->kd_tiket . '/';
                    }
                } else {
                    $destination_path3 = getcwd() . '/public/BA/' . $pelayanan->kd_tiket . '/';
                }

                $attachment3->move($destination_path3, $filename3);
                $pelayanan->file_ba = $filename3;
            }
            if (Auth::user()->role_user == 'Koordinator Agen') {
                $pelayanan->status_ba_agent = $request->input('status_ba_agent');
                if ($request->input('status_ba_agent') == 1) {
                    $nextStage = $pelayanan->stage + 1;
                    $pelayanan->stage = $nextStage;
                }
            }
        }
        $oldStatus = $pelayanan->status;
        $pelayanan->contact_person = $request->input('contact_person');

        $pelayanan->judul = $request->input('judul');
        $pelayanan->deskripsi = $request->input('deskripsi');

        if ($pelayanan->jns_pelayanan != $request->input('jns_pelayanan')) {
            // Create New Tiket
            Log::info("CREATING NEW TICKET");
            // Tgl Pelaporan
            $timezone = "Asia/Jakarta";
            date_default_timezone_set($timezone);
            $tgl_pelaporan = date('Y-m-d H:i:s');

            $lastInsert = Pelayanan::latest('id_')->first();
            $split = $lastInsert['kd_tiket'];
            $lastId = substr($split, 5) + 1;
            $firstId = 'P-000';
            $kdTiket = $firstId . $lastId;

            $plynn = new Pelayanan;
            $plynn->kd_tiket = $kdTiket;
            $plynn->id_opd = $pelayanan->id_opd;
            $plynn->id_pelapor = $pelayanan->id_pelapor;
            $plynn->judul = $pelayanan->judul;
            $plynn->deskripsi = $pelayanan->deskripsi;
            $plynn->contact_person = $pelayanan->contact_person;
            $plynn->jns_pelayanan = $pelayanan->jns_pelayanan;

            $plynn->tgl_pelaporan = $tgl_pelaporan;
            $plynn->tgl_update = $tgl_pelaporan;
            $plynn->status = 'Open';

            $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();

            $plynn->stage = $flow_pelayanan->id;
            $plynn->lampiran = $pelayanan->lampiran;

            if ($pelayanan->file_surat_dinas != null) {
                $plynn->file_surat_dinas = $pelayanan->file_surat_dinas;
                $target_flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $plynn->jns_pelayanan)->where('name', '=', 'Verifikasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();
                $plynn->stage = $target_flow_pelayanan->id;
            }
            $jns_pelayanan_id = $plynn->jns_pelayanan;
            $jns_pelayanan = JnspelayananModel::find($jns_pelayanan_id)->with('penanggungJawabEselon3', 'koordinatorAgen')->first();
            $usermail = $pelayanan->pelapor->email; //Email User

            $judul = $request->input('judul');
            $subject2 = 'Tiket Baru Telah Dibuat Otomatis Karena Perubahan pada Jenis Pelayanan';
            $keterangan = $pelayanan->deskripsi;
            Log::info($usermail);
            // EMAIL NEW TIKET FOR USER
            $data = array(
                'email' => $usermail,
                'subject' => $subject2,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'kdTiket' => $kdTiket,
                'opd' => $pelayanan->pelapor->org->nama_opd,
            );
            try {
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

            // End Create New Tiket
            $statusTiket = 'Close';
            $plynn->save();
        }
        $pelayanan->jns_pelayanan = $request->input('jns_pelayanan');

        $pelayanan->tgl_update = $tgl_update;

        $pelayanan->solusi = $request->input('solusi');
        if ($pelayanan->id_agen != $request->input('agen_id')) {
            $description = "Disposisi Dari Agen " . $pelayanan->id_agen . " Ke Agen " . $request->input('agen_id');
            if (empty($pelayanan->id_agen)) {
                $description = "Disposisi Ke Agen " . $request->input('agen_id');
            }
            $statusTiket = 'Diproses';
            Common::update_timeline("user_action", $description, $statusTiket, $id, Auth::user()->id);
        }

        $email_penanggung_jawab = [];

        if ($pelayanan->jenis_pelayanan->notif_eselon3 == 1) {
            $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->penanggungJawabEselon3->email;
        }
        if ($pelayanan->jenis_pelayanan->notif_koordinator_agen == 1) {
            $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->koordinatorAgen->email;
        }
        if ($pelayanan->id_agen != null) {
            $user_agent = User::find($pelayanan->id_agen);
            $email_penanggung_jawab[] = $user_agent->email;
        }

        if ($pelayanan->id_agen == null) {
            $progress_agent_task = PelayananAgentTask::create([
                'user_agent' => Auth::user()->id,
                'pelayanan_id' => $id,
                'task_report' => "Anda Telah Diberikan Tugas, Silahkan Update progres",
                'stage' => $pelayanan->stage,
                'status' => 0,
            ]);

            $data_email_notification_internal = array(
                'email' => $email_penanggung_jawab,
                'subject' => "Disposisi Agen",
                'judul' => $pelayanan->judul,
                'keterangan' => "Anda Telah Diberikan Tugas, Silahkan Update progres",
                'tiketKode' => $pelayanan->kd_tiket,
                'status' => 'Disposisi Agent',
                'code' => 'helpdesk',
                'catatan' => $pelayanan->catatan_khusus,
            );

            try {
                Mail::send('email.notifStatus', $data_email_notification_internal, function ($message) use ($data_email_notification_internal) {
                    $message->subject($data_email_notification_internal['subject']);
                    $message->to($data_email_notification_internal['email']);
                    $message->replyTo('servicedesk@jabarprov.go.id');
                });
            } catch (\Exception $e) {
                // exception is raised and it'll be handled here
                // $e->getMessage() contains the error message
                Log::error($e->getMessage());
            }
        } else {
            if ($request->filled('solusi')) {
                $progress_agent_task = PelayananAgentTask::create([
                    'user_agent' => Auth::user()->id,
                    'pelayanan_id' => $id,
                    'task_report' => $request->input('solusi'),
                    'stage' => $pelayanan->stage,
                    'status' => $request->input('statusTask'),
                ]);
                $data_email_notification_internal = array(
                    'email' => $email_penanggung_jawab,
                    'subject' => "Pemenuhan Pekerjaan Agen",
                    'judul' => $pelayanan->judul,
                    'keterangan' => "Update Progress Task Agent, Silahkan Cek Dashboard Service Desk",
                    'tiketKode' => $pelayanan->kd_tiket,
                    'status' => $pelayanan->flow_pelayanan->name,
                    'code' => 'helpdesk',
                    'catatan' => $pelayanan->catatan_khusus,
                );

                try {
                    Mail::send('email.notifStatus', $data_email_notification_internal, function ($message) use ($data_email_notification_internal) {
                        $message->subject($data_email_notification_internal['subject']);
                        $message->to($data_email_notification_internal['email']);
                        $message->replyTo('servicedesk@jabarprov.go.id');
                    });
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
            if ($request->has('finalSolution')) {
                $progress_agent_task = PelayananAgentTask::create([
                    'user_agent' => Auth::user()->id,
                    'pelayanan_id' => $id,
                    'task_report' => $request->input('final_solution'),
                    'stage' => $pelayanan->stage,
                    'status' => 1,
                    'final_solution' => 1,
                ]);
                if ($request->hasFile('lampiran_solusi')) {
                    $attachment = $request->file('lampiran_solusi');
                    $extension = $attachment->getClientOriginalExtension();
                    $attachment_real_path = $attachment->getRealPath();
                    $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
                    $filename = date('Ymdhis') . '_' . $real_filename;

                    if (!File::exists(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket)) {
                        $result = File::makeDirectory(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket, 0777, true);
                        if ($result) {
                            $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
                        }
                    } else {
                        $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
                    }
                    $attachment->move($destination_path, $filename);
                    $pelayanan->lampiran_balasan = $filename;
                    AgentTaskAttachment::create([
                        'filename' => $pelayanan->lampiran_balasan,
                        'agent_task_id' => $progress_agent_task->id,
                        'pelayanan_id' => $id,
                    ]);
                }
                try {
                    $data_email_notification_internal = array(
                        'email' => $email_penanggung_jawab,
                        'subject' => "Pemenuhan Pelayanan di Alur " . $pelayanan->flow_pelayanan->name,
                        'judul' => $judul,
                        'keterangan' => "Pemenuhan Pelayanan di Alur " . $pelayanan->flow_pelayanan->name,
                        'tiketKode' => $pelayanan->kd_tiket,
                        'status' => $pelayanan->flow_pelayanan->name,
                        'code' => 'helpdesk',
                        'catatan' => $pelayanan->catatan_khusus,
                    );

                    Mail::send('email.notifStatus', $data_email_notification_internal, function ($message) use ($data_email_notification_internal) {
                        $message->subject($data_email_notification_internal['subject']);
                        $message->to($data_email_notification_internal['email']);
                        $message->replyTo('servicedesk@jabarprov.go.id');
                    });
                } catch (\Exception $e) {
                    // exception is raised and it'll be handled here
                    // $e->getMessage() contains the error message
                    Log::error($e->getMessage());
                }
            } else {
                //Checkbox not checked
            }
        }

        $pelayanan->id_agen = $request->input('agen_id');
        $pelayanan->id_team = $request->input('id_team');
        $jns_pelayanan_id = $pelayanan->jns_pelayanan;
        $jns_pelayanan = JnspelayananModel::find($jns_pelayanan_id)->with('penanggungJawabEselon3', 'koordinatorAgen')->first();

        $pelayanan->status = $request->input('statusTiket');

        // Attach File
        if ($request->hasFile('lampiran_balasan')) {
            $attachment = $request->file('lampiran_balasan');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_' . $real_filename;

            if (!File::exists(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket)) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket, 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
            }
            $attachment->move($destination_path, $filename);
            $pelayanan->lampiran_balasan = $filename;
            AgentTaskAttachment::create([
                'filename' => $pelayanan->lampiran_balasan,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $id,
            ]);
        }

        if ($statusTiket == 'Selesai') {
            $pelayanan->status = $statusTiket;

            // SEND EMAIL
            $emailUser = User::where('id', '=', $pelayanan->id_pelapor)->first();
            $org = Organisasi::where('id_organisasi', '=', $emailUser->id_organisasi)->first();
            $subject = 'Pemberitahuan Progress Servicedesk';
            $email = $emailUser->email;
            $judul = $pelayanan->judul;
            $keterangan = $pelayanan->deskripsi;
            $tiketKode = $pelayanan->kd_tiket;

            $data = array(
                'email' => $emailUser->email,
                'subject' => 'Pemberitahuan Progress Servicedesk',
                'judul' => $judul,
                'keterangan' => $keterangan,
                'tiketKode' => $tiketKode,
                'status' => 'Selesai',
                'org' => $org->nama_opd,
                'code' => 'user',
                'catatan' => $pelayanan->solusi,
            );

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            Mail::send('email.notifStatus', $data_email_notification_internal, function ($message) use ($data_email_notification_internal) {
                $message->subject($data_email_notification_internal['subject']);
                $message->to($data_email_notification_internal['email']);

                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            Common::update_timeline("system_action", "System Mengirimkan Email Ke User & Agent yang Terkait ", $statusTiket, $id, Auth::user()->id);
            $pelayanan->save();

            return redirect()->route('pelayanan.show', $id)->with('success', 'Status pelayanan berubah menjadi "Selesai"');

            $pelayanan->save();

            Common::update_timeline("system_action", "System Mengirimkan Email Ke User & Agent yang Terkait ", $statusTiket, $id, Auth::user()->id);
            return redirect()->route('pelayanan.index')->with('success', 'Status pelayanan berubah menjadi "Pending"');
        } else {
            $pelayanan->status = $statusTiket;
            $pelayanan->save();
            if ($oldStatus != $statusTiket) {
                Common::update_timeline("user_action", "Update Status Menjadi " . $statusTiket, $statusTiket, $id, Auth::user()->id);
            }
            return redirect()->route('pelayanan.show', $id)->with('success', 'Data Pelayanan telah diperbaharui..');
        }
    }

    public function validasiPD(Request $request)
    {

        $pelayanan_id = $request->input('pelayanan_id');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->where('id', '=', $pelayanan->stage + 1)->first();
        Log::info($flow_pelayanan);
        $pelayanan->stage = $pelayanan->stage + 1;
        $pelayanan->id_team = $flow_pelayanan->koordinator_id;
        $pelayanan->save();
        AssignmentHistory::create(['pelayanan_id' => $pelayanan->id_, 'user_id' => Auth::user()->id]);
        try {
            $org = Organisasi::where('id_organisasi', $pelayanan->pelapor->id_organisasi)->first();
            $judul = $pelayanan->judul;
            $subject2 = 'Status Tiket ' . $pelayanan->kd_tiket;
            $keterangan = "Detail Progres Tiket Anda sudah berubah silahkan cek dashboard anda";
            $orgName = $org->nama_opd;

            $data = array(
                'email' => $pelayanan->pelapor->email,
                'subject' => $subject2,
                'judul' => $judul,
                'opd' => $orgName,
                'keterangan' => $keterangan,
                'tiketKode' => $pelayanan->kd_tiket,
            );

            Mail::send('email.notifUser', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $email_penanggung_jawab = [];
            if ($pelayanan->jenis_pelayanan->notif_eselon3 == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->penanggungJawabEselon3->email;
            }
            if ($pelayanan->jenis_pelayanan->notif_koordinator_agen == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->koordinatorAgen->email;
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

        return redirect('/home')->with('success', 'Validasi Berhasil');
    }

    public function finalTutupTiket(Request $request)
    {

        $pelayanan_id = $request->input('pelayanan_id');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $kdTiket = $pelayanan->kd_tiket;

        if ($request->hasFile('file_lampiran')) {
            $attachment = $request->file('file_lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_lampiran_' . $real_filename;

            if (!File::exists(getcwd() . '/public/lampiran/' . $kdTiket)) {

                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $kdTiket, 0777, true);

                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $kdTiket;
                }
            } else {

                $destination_path = getcwd() . '/public/lampiran/' . $kdTiket;
            }

            $attachment->move($destination_path, $filename);
            $pelayanan->lampiran_balasan = $filename;
        }

        if ($request->hasFile('file_ba')) {
            $attachment = $request->file('file_ba');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_lampiran_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $kdTiket)) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $kdTiket, 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $kdTiket;
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $kdTiket;
            }
            $attachment->move($destination_path, $filename);
            $pelayanan->file_ba = $filename;
        }

        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->with(array('checklist'))->get();

        $last_element = $flow_pelayanan[count($flow_pelayanan) - 1];

        $pelayanan->stage = $last_element->id;
        $pelayanan->status = "Close";
        $pelayanan->komen_slaba = $request->input('deskripsi');
        $pelayanan->save();
        $data = array(
            'email' => $pelayanan->pelapor->email,
            'subject' => "Tutup Tiket",
            'judul' => "Tutup Tiket",
            'keterangan' => "Tiket Telah Ditutup Silahkan Cek dashboard anda ",
            'tiketKode' => $pelayanan->kd_tiket,
            'opd' => $pelayanan->pelapor->org->nama_opd,
        );

        try {

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            // $data2 = array(
            //     'email' => $mailhelpdesk,
            //     'subject' => $subject,
            //     'judul' => $judul,
            //     'keterangan' => $keterangan,
            //     'tiketKode' => $tiketKode,
            //     'status' => 'Proses ke langkah selanjutnya',
            //     'code' => 'helpdesk',
            //     'org' => $org->nama_opd,
            //     'catatan' => $pelayanan->catatan_khusus,
            // );

            // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            //     $message->subject($data2['subject']);
            //     $message->to($data2['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });
            // Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $pelayanan->status, $pelayanan->status, $id, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return redirect()->back()->with('success', 'Tutup Tiket Berhasil');
    }

    public function tutupTiket(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('deskripsi');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $pelayanan->komen_slaba = $deskripsi;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->with(array('checklist'))->get();

        $last_element = $flow_pelayanan[count($flow_pelayanan) - 1];
        $pelayanan->stage = $last_element->id;
        if ($request->hasFile('file_lampiran')) {
            $attachment = $request->file('file_lampiran');
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
            $pelayanan->lampiran_balasan = $filename;
        }

        if ($request->hasFile('file_ba')) {

            $attachment = $request->file('file_ba');
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
            $pelayanan->file_ba = $filename;
        }

        $pelayanan->status = 'Close';

        $emailUser = User::where('id', '=', $pelayanan->id_pelapor)->first();

        $org = Organisasi::where('id_organisasi', '=', $emailUser->id_organisasi)->first();

        $data = array(
            'email' => $emailUser,
            'subject' => "Tutup Tiket",
            'judul' => "Tutup Tiket",
            'keterangan' => "Tiket Telah Ditutup ",
            'kdTiket' => $pelayanan->kd_tiket,
            'opd' => $pelayanan->pelapor->org->nama_opd,
        );
        try {

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            // $data2 = array(
            //     'email' => $mailhelpdesk,
            //     'subject' => $subject,
            //     'judul' => $judul,
            //     'keterangan' => $keterangan,
            //     'tiketKode' => $tiketKode,
            //     'status' => 'Proses ke langkah selanjutnya',
            //     'code' => 'helpdesk',
            //     'org' => $org->nama_opd,
            //     'catatan' => $pelayanan->catatan_khusus,
            // );

            // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            //     $message->subject($data2['subject']);
            //     $message->to($data2['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });
            Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $pelayanan->status, $pelayanan->status, $id, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $pelayanan->status, $pelayanan->status, $pelayanan->id, Auth::user()->id);
        return redirect()->route('pelayanan.koordinatorAgen','Ditutup')->with('success', 'Tutup Tiket Berhasil');
    }
    public function laporanProgressAgen(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('solusi');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $pelayanan->id_agen = NULL;
        $pelayanan->komen_slaba = $deskripsi;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->with(array('checklist'))->get();
        $progress_agent_task = PelayananAgentTask::create([
            'user_agent' => Auth::user()->id,
            'pelayanan_id' => $pelayanan_id,
            'task_report' => $request->input('solusi'),
            'stage' => $pelayanan->stage,
            'status' => 1,
        ]);

        if ($request->hasFile('file_lampiran')) {
            $attachment = $request->file('file_lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_lampiran = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_lampiran);
            AgentTaskAttachment::create([
                'filename' => $filename_lampiran,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 0,
            ]);
        }

        if ($request->hasFile('file_ba')) {

            $attachment = $request->file('file_ba');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_ba = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_ba);

            AgentTaskAttachment::create([
                'filename' => $filename_ba,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 1,
            ]);
        }

        try {
            $data = array(
                'email' => $pelayanan->jenis_pelayanan->koordinatorAgen->email,
                'subject' => "Laporan Pemenuhan Layanan",
                'judul' => "Pemenuhan Layanan",
                'keterangan' => "Ada Laporan Baru untuk Pemenuhan layanan ",
                'tiketKode' => $pelayanan->kd_tiket,
            );
            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            // $data2 = array(
            //     'email' => $mailhelpdesk,
            //     'subject' => $subject,
            //     'judul' => $judul,
            //     'keterangan' => $keterangan,
            //     'tiketKode' => $tiketKode,
            //     'status' => 'Proses ke langkah selanjutnya',
            //     'code' => 'helpdesk',
            //     'org' => $org->nama_opd,
            //     'catatan' => $pelayanan->catatan_khusus,
            // );

            // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            //     $message->subject($data2['subject']);
            //     $message->to($data2['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });
            Common::update_timeline("system_action", "Mengirimkan Email ke Koordinator Agent" . $pelayanan->status, $pelayanan->status, $pelayanan_id, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $pelayanan->status, $pelayanan->status, $pelayanan->id, Auth::user()->id);
        return redirect()->route('pelayanan.agen', 'Diproses')->with('success', 'Lapor Progres Berhasil');
    }

    public function laporanSelesaiProgressAgen(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('solusi');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org','agent_task_last'
            )
        )->find($pelayanan_id);
        if ($request->has('list_checklist')) {
            Log::info($request->list_checklist);
            ListChecklistPelayanan::whereIn('id', $request->list_checklist)->update(array('status' => 1));
            ListChecklistPelayanan::whereNotIn('id', $request->list_checklist)->update(array('status' => null));

            $list_checklist_data = ListChecklistPelayanan::where('pelayanan_id', '=', $pelayanan_id)->get();

            foreach ($list_checklist_data as $lcd) {
                $input_name = $lcd->id . '-detailChecklist';
                $detail = $request->input($input_name);
                $lcd->detail = $detail;
                $lcd->save();
            }
        }
        $progress_agent_task = PelayananAgentTask::create([
            'user_agent' => Auth::user()->id,
            'pelayanan_id' => $pelayanan_id,
            'task_report' => $deskripsi,
            'stage' => $pelayanan->stage,
            'status' => 1,
            'final_solution' => 1,
        ]);

        if ($request->hasFile('file_lampiran')) {
            $attachment = $request->file('file_lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_lampiran = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_lampiran);
            AgentTaskAttachment::create([
                'filename' => $filename_lampiran,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 0
            ]);
        }

        if ($request->hasFile('file_ba')) {

            $attachment = $request->file('file_ba');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_ba = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_ba);

            AgentTaskAttachment::create([
                'filename' => $filename_ba,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 1
            ]);
            $pelayanan->file_ba = $filename_ba;
        }
        $prev_agent = $pelayanan->agent_task_last->user_agent;
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_update = date('Y-m-d H:i:s');
        $nextStage = $pelayanan->stage + 1;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->where('id', '=', $nextStage)->first();
        $pelayanan->tgl_update = $tgl_update;
        if ($flow_pelayanan->name == 'Pemberian Hasil dan BA') {
            $pelayanan->status = 'Selesai';
            $pelayanan->id_agen = $prev_agent;
            $nextStage = $nextStage + 1;
        }
        if ($flow_pelayanan->name == 'User membalas BA dan Survei') {
            $pelayanan->status = 'Selesai';
            $pelayanan->id_agen = $prev_agent;
        }
        if ($flow_pelayanan->name == 'Penutupan Permintaan Layanan') {
            $pelayanan->status = 'Selesai';
            $pelayanan->id_agen = $prev_agent;
        }
        if ($flow_pelayanan->name == 'Selesai') {
            $pelayanan->status = 'Selesai';
            $pelayanan->id_agen = $prev_agent;
        }
        $pelayanan->stage = $nextStage;
        $pelayanan->id_agen = null;
        $emailUser = User::where('id', '=', $pelayanan->id_pelapor)->first();

        $org = Organisasi::where('id_organisasi', '=', $emailUser->id_organisasi)->first();

        $data = array(
            'email' => $pelayanan->pelapor->email,
            'subject' => "Tiket Selesai",
            'judul' => "Status Tiket",
            'keterangan' => "Tiket Telah Selesai ",
            'tiketKode' => $pelayanan->kd_tiket,
            'opd' => $pelayanan->pelapor->org->nama_opd,
        );
        try {

            Mail::send('email.notifStatus', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            // $data2 = array(
            //     'email' => $mailhelpdesk,
            //     'subject' => $subject,
            //     'judul' => $judul,
            //     'keterangan' => $keterangan,
            //     'tiketKode' => $tiketKode,
            //     'status' => 'Proses ke langkah selanjutnya',
            //     'code' => 'helpdesk',
            //     'org' => $org->nama_opd,
            //     'catatan' => $pelayanan->catatan_khusus,
            // );

            // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
            //     $message->subject($data2['subject']);
            //     $message->to($data2['email']);
            //     //$message->cc($cc);
            //     $message->replyTo('servicedesk@jabarprov.go.id');
            // });
            Common::update_timeline("system_action", "Mengirimkan Email ke Agent dan User terkait" . $pelayanan->status, $pelayanan->status, $pelayanan_id, Auth::user()->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $pelayanan->status, $pelayanan->status, $pelayanan->id, Auth::user()->id);
        return redirect()->route('pelayananDataUnverifiedPage',0)->with('success', 'Hasil Pemenuhan Berhasil Diunggah');
    }

    public function perbaikiProgresAgen(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('Solusi');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org','assignment_history'
            )
        )->find($pelayanan_id);
        $pelayanan->komen_slaba = $deskripsi;
        
        $pelayanan->id_agen=$pelayanan->assignment_history->user_id;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->with(array('checklist'))->get();
        $progress_agent_task = PelayananAgentTask::create([
            'user_agent' => Auth::user()->id,
            'pelayanan_id' => $pelayanan_id,
            'task_report' => $request->input('solusi'),
            'stage' => $pelayanan->stage,
            'status' => 0,
        ]);
        if ($request->hasFile('file_lampiran')) {
            $attachment = $request->file('file_lampiran');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_lampiran = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_lampiran);

            AgentTaskAttachment::create([
                'filename' => $filename_lampiran,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
            ]);
        }

        // $data = array(
        //     'email' => $pelayanan->agent->email,
        //     'subject' => "Layanan Perlu Perbaikan",
        //     'judul' => "Pemenuhan Layanan",
        //     'keterangan' => "Yang anda Kerjakan masih perlu perbaikan, silahkan cek lagi",
        //     'tiketKode' => $pelayanan->kd_tiket,
        // );
        // try {

        //     Mail::send('email.notifStatus', $data, function ($message) use ($data) {
        //         $message->subject($data['subject']);
        //         $message->to($data['email']);
        //         $message->replyTo('servicedesk@jabarprov.go.id');
        //     });

        //     // $data2 = array(
        //     //     'email' => $mailhelpdesk,
        //     //     'subject' => $subject,
        //     //     'judul' => $judul,
        //     //     'keterangan' => $keterangan,
        //     //     'tiketKode' => $tiketKode,
        //     //     'status' => 'Proses ke langkah selanjutnya',
        //     //     'code' => 'helpdesk',
        //     //     'org' => $org->nama_opd,
        //     //     'catatan' => $pelayanan->catatan_khusus,
        //     // );

        //     // Mail::send('email.notifStatus', $data2, function ($message) use ($data2) {
        //     //     $message->subject($data2['subject']);
        //     //     $message->to($data2['email']);
        //     //     //$message->cc($cc);
        //     //     $message->replyTo('servicedesk@jabarprov.go.id');
        //     // });
        //     Common::update_timeline("system_action", "Mengirimkan Email ke Agent" . $pelayanan->status, $pelayanan->status, $pelayanan_id, Auth::user()->id);
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        // }
        $pelayanan->save();
        Common::update_timeline("user_action", "Koordinator Meminta Perbaikan Ke Agen " . $pelayanan->status, $pelayanan->status, $pelayanan->id, Auth::user()->id);
        return redirect()->route('pelayanan.index')->with('success', 'Request Perbaikan Progres Berhasil');
    }

    public function balasBAUser(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('solusi');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $pelayanan->jwb_komen_slaba = $deskripsi;
        $pelayanan->survey_rate = $request->input('rating');
        $pelayanan->stage = $pelayanan->stage + 1;
        $pelayanan->status = "Selesai";
        if ($request->hasFile('file_ba')) {
            $attachment = $request->file('file_ba');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename_ba = date('Ymdhis') . '_' . $real_filename;
            if (!File::exists(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $pelayanan->kd_tiket . '/';
            }
            $attachment->move($destination_path, $filename_ba);
            $pelayanan->ba_bls = $filename_ba;
        }
        $pelayanan->save();
        try {
            $org = Organisasi::where('id_organisasi', $pelayanan->pelapor->id_organisasi)->first();
            $judul = $pelayanan->judul;
            $subject2 = 'BA Balasan User';
            $keterangan = "User Telah Mengupload BA balasan";
            $orgName = $org->nama_opd;

            $data = array(
                'email' => $pelayanan->pelapor->email,
                'subject' => $subject2,
                'judul' => $judul,
                'opd' => $orgName,
                'keterangan' => $keterangan,
                'tiketKode' => $pelayanan->kd_tiket,
            );

            Mail::send('email.notifUser', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $email_penanggung_jawab = [];
            if ($pelayanan->jenis_pelayanan->notif_eselon3 == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->penanggungJawabEselon3->email;
            }
            if ($pelayanan->jenis_pelayanan->notif_koordinator_agen == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->koordinatorAgen->email;
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
        return redirect()->back()->with('success', 'Kirim BA Balasan Berhasil');
    }

    public function nextStep(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $deskripsi = $request->input('finalSolution');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $pelayanan->komen_slaba = $deskripsi;
        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $pelayanan->jns_pelayanan)
            ->where('id', $pelayanan->stage + 1)->with(array('checklist'))->first();
        if ($flow_pelayanan->name == 'Pemberian Hasil dan BA') {
            $pelayanan->stage = $flow_pelayanan->id + 2;
            $pelayanan->status = 'Selesai';
        } else {
            $pelayanan->stage = $pelayanan->stage + 1;
        }

        $progress_agent_task = PelayananAgentTask::create([
            'user_agent' => Auth::user()->id,
            'pelayanan_id' => $pelayanan_id,
            'task_report' => $request->input('final_solution'),
            'stage' => $pelayanan->stage,
            'status' => 1,
            'final_solution' => 1,
        ]);
        if ($request->hasFile('lampiran_solusi')) {
            $attachment = $request->file('lampiran_solusi');
            $extension = $attachment->getClientOriginalExtension();
            $attachment_real_path = $attachment->getRealPath();
            $real_filename = preg_replace('/\s+/', '_', $attachment->getClientOriginalName());
            $filename = date('Ymdhis') . '_' . $real_filename;

            if (!File::exists(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket)) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket, 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran_balasan/' . $pelayanan->kd_tiket;
            }
            $attachment->move($destination_path, $filename);
            $pelayanan->lampiran_balasan = $filename;
            AgentTaskAttachment::create([
                'filename' => $pelayanan->lampiran_balasan,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 0,
            ]);
        }
        if ($request->hasFile('file_ba')) {

            $attachment = $request->file('file_ba');
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
            $pelayanan->file_ba = $filename;
            AgentTaskAttachment::create([
                'filename' => $pelayanan->lampiran_balasan,
                'agent_task_id' => $progress_agent_task->id,
                'pelayanan_id' => $pelayanan_id,
                'is_ba' => 1,
            ]);
        }

        try {
            $org = Organisasi::where('id_organisasi', $pelayanan->pelapor->id_organisasi)->first();
            $judul = $pelayanan->judul;
            $subject2 = 'Perubahan Progres';
            $keterangan = "Perubahan Detail Progress menjadi " . $pelayanan->flow_pelayanan->name;
            $orgName = $org->nama_opd;

            $data = array(
                'email' => $pelayanan->pelapor->email,
                'subject' => $subject2,
                'judul' => $judul,
                'opd' => $orgName,
                'keterangan' => $keterangan,
                'tiketKode' => $pelayanan->kd_tiket,
            );

            Mail::send('email.notifUser', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $email_penanggung_jawab = [];
            if ($pelayanan->jenis_pelayanan->notif_eselon3 == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->penanggungJawabEselon3->email;
            }
            if ($pelayanan->jenis_pelayanan->notif_koordinator_agen == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->koordinatorAgen->email;
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
        $pelayanan->save();
        Common::update_timeline("user_action", "Update Progress Tiket Ke Langkah " . $pelayanan->status, $pelayanan->status, $pelayanan->id, Auth::user()->id);
        return redirect()->route('pelayanan.index')->with('success', 'Update Tiket Ke proses selanjutnya berhasil');
    }
    public function disposisi(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $agen_id = $request->input('agen');
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $progress_agent_task = PelayananAgentTask::create([
            'user_agent' => Auth::user()->id,
            'pelayanan_id' => $pelayanan_id,
            'task_report' => "Anda Telah Diberikan Tugas, Silahkan Update progres",
            'stage' => $pelayanan->stage,
            'status' => 0,
        ]);
        $pelayanan->id_agen = $agen_id;
        $pelayanan->status = "Diproses";
        $pelayanan->save();
        AssignmentHistory::create(['pelayanan_id' => $pelayanan->id_, 'user_id' => $agen_id]);
        try {
            $org = Organisasi::where('id_organisasi', $pelayanan->pelapor->id_organisasi)->first();
            $judul = $pelayanan->judul;
            $subject2 = 'Perubahan Progres';
            $keterangan = "Perubahan Detail Progress menjadi " . $pelayanan->flow_pelayanan->name;
            $orgName = $org->nama_opd;

            // EMAIL NEW TIKET FOR USER
            $data = array(
                'email' => $pelayanan->pelapor->email,
                'subject' => $subject2,
                'judul' => $judul,
                'opd' => $orgName,
                'keterangan' => $keterangan,
                'tiketKode' => $pelayanan->kd_tiket,
            );

            Mail::send('email.notifUser', $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['email']);
                $message->replyTo('servicedesk@jabarprov.go.id');
            });

            $email_penanggung_jawab = [];
            if ($pelayanan->jenis_pelayanan->notif_eselon3 == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->penanggungJawabEselon3->email;
            }
            if ($pelayanan->jenis_pelayanan->notif_koordinator_agen == 1) {
                $email_penanggung_jawab[] = $pelayanan->jenis_pelayanan->koordinatorAgen->email;
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

        return redirect('/home')->with('success', 'Disposisi Berhasil');
    }

    public function reposisi(Request $request)
    {
        $pelayanan_id = $request->input('pelayanan_id');
        $new_layanan_id = $request->input('new_layanan');
        Log::info($new_layanan_id);
        $pelayanan = Pelayanan::with(
            array(
                'jenis_pelayanan', 'jenis_pelayanan.penanggungJawabEselon3',
                'jenis_pelayanan.koordinatorAgen',
                'flow_pelayanan', 'agent', 'pelapor', 'pelapor.org',
            )
        )->find($pelayanan_id);
        $timezone = "Asia/Jakarta";
        date_default_timezone_set($timezone);
        $tgl_pelaporan = date('Y-m-d H:i:s');

        $lastInsert = Pelayanan::latest('id_')->first();
        $split = $lastInsert['kd_tiket'];
        $lastId = substr($split, 5) + 1;
        $firstId = 'P-000';
        $kdTiket = $firstId . $lastId;

        $plynn = new Pelayanan;
        $plynn->kd_tiket = $kdTiket;
        $plynn->id_opd = $pelayanan->id_opd;
        $plynn->id_pelapor = $pelayanan->id_pelapor;
        $plynn->judul = $pelayanan->judul;
        $plynn->deskripsi = $pelayanan->deskripsi;
        $plynn->contact_person = $pelayanan->contact_person;
        $plynn->jns_pelayanan = $new_layanan_id;

        $plynn->tgl_pelaporan = $tgl_pelaporan;
        $plynn->tgl_update = $tgl_pelaporan;
        $plynn->status = 'Open';

        $flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $new_layanan_id)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();

        $plynn->stage = $flow_pelayanan->id+1;
        $plynn->lampiran = $pelayanan->lampiran;

        if ($pelayanan->file_surat_dinas != null) {
            $plynn->file_surat_dinas = $pelayanan->file_surat_dinas;

            $source = public_path('lampiran/' . $pelayanan->kd_tiket . '/');
            $target = public_path('lampiran/' . $plynn->kd_tiket . '/');
            if (!File::exists(getcwd() .'/public/lampiran/' . $plynn->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/';
            }
            Log::info($source.$pelayanan->file_surat_dinas);
            Log::info($target.$pelayanan->file_surat_dinas);
            File::copy($source.$pelayanan->file_surat_dinas, $target.$pelayanan->file_surat_dinas);
        }
        if ($pelayanan->lampiran != null) {
            $plynn->lampiran = $pelayanan->lampiran;
            // $target_flow_pelayanan = FlowPelayanan::where('jns_pelayanan_id', '=', $new_layanan_id)->where('name', '=', 'Validasi Permintaan Layanan')->orderBy('stage', 'ASC')->first();
            // Log::info($target_flow_pelayanan);
            // $plynn->stage = $target_flow_pelayanan->id+1;
            $source = public_path('lampiran/' . $pelayanan->kd_tiket . '/');
            $target = public_path('lampiran/' . $plynn->kd_tiket . '/');
            if (!File::exists(getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/')) {
                $result = File::makeDirectory(getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/', 0777, true);
                if ($result) {
                    $destination_path = getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/';
                }
            } else {
                $destination_path = getcwd() . '/public/lampiran/' . $plynn->kd_tiket . '/';
            }
            File::copy($source.$pelayanan->lampiran, $target.$pelayanan->lampiran);
        }
        $jns_pelayanan_id = $plynn->jns_pelayanan;
        $jns_pelayanan = JnspelayananModel::find($jns_pelayanan_id)->with('penanggungJawabEselon3', 'koordinatorAgen')->first();
        $usermail = $pelayanan->pelapor->email; //Email User

        $judul = $request->input('judul');
        $subject2 = 'Tiket Baru Telah Dibuat Otomatis Karena Perubahan pada Jenis Pelayanan';
        $keterangan = $pelayanan->deskripsi;
        Log::info($usermail);
        // Set to latest stage
        $prevFlowPelayananLastStage = FlowPelayanan::where('jns_pelayanan_Id', '=', $pelayanan->jns_pelayanan)->orderBy('stage', 'DESC')->first();
        Log::info($prevFlowPelayananLastStage);
        $pelayanan->stage = $prevFlowPelayananLastStage->id;
        // EMAIL NEW TIKET FOR USER
        $data = array(
            'email' => $usermail,
            'subject' => $subject2,
            'judul' => $judul,
            'keterangan' => $keterangan,
            'tiketKode' => $kdTiket,
            'opd' => $pelayanan->pelapor->org->nama_opd,
        );
        try {
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

        // End Create New Tiket

        $pelayanan->status = 'Close';
        $pelayanan->save();
        $plynn->save();
        return redirect()->route('pelayanan.koordinatorAgen','Open')->with('success', 'Reposisi Berhasil Dilakukan');
    }

    public function getSla($id)
    {
        $data['pelayanan'] = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->select(
                'pelayanan.id_',
                'pelayanan.tgl_kirim_sla',
                'pelayanan.file_sla',
                'pelayanan.file_ba',
                'pelayanan.kd_tiket',
                'pelayanan.judul',
                'organisasi.nama_opd as opd',
                'pelayanan.sla_bls',
                'pelayanan.ba_bls',
                'pelayanan.komen_slaba',
                'pelayanan.jwb_komen_slaba'
            )
            ->find($id);
        //dd( $data['pelayanan']);exit();

        if (!$data['pelayanan']) {
            return view('errors.404');
        }

        return view('admin.pelayanan.sla', $data);
    }

    public function updateSla(Request $request)
    {
        $id = $request->id_;
        //var_dump($request->all());exit();
        $sla = Pelayanan::find($id);
        $sla->tgl_kirim_sla = $request->input('tgl_kirim_sla');
        $sla->komen_slaba = $request->input('komen_slaba');

        if ($request->hasFile('file_sla')) {
            $attachment2 = $request->file('file_sla');
            $extension2 = $attachment2->getClientOriginalExtension();
            $attachment_real_path2 = $attachment2->getRealPath();
            $filename2 = str_random(5) . date('Ymdhis') . '.' . $extension2;

            if (!File::exists(getcwd() . '/public/SLA/')) {
                $result2 = File::makeDirectory(getcwd() . '/public/SLA/', 0777, true);
                if ($result2) {
                    $destination_path2 = getcwd() . '/public/SLA/';
                }
            } else {
                $destination_path2 = getcwd() . '/public/SLA/';
            }

            $attachment2->move($destination_path2, $filename2);
            $sla->file_sla = $filename2;
        }

        if ($request->hasFile('file_ba')) {
            $attachment3 = $request->file('file_ba');
            $extension3 = $attachment3->getClientOriginalExtension();
            $attachment_real_path3 = $attachment3->getRealPath();
            $filename3 = str_random(5) . date('Ymdhis') . '.' . $extension3;

            if (!File::exists(getcwd() . '/public/BA/')) {
                $result3 = File::makeDirectory(getcwd() . '/public/BA/', 0777, true);
                if ($result3) {
                    $destination_path3 = getcwd() . '/public/BA/';
                }
            } else {
                $destination_path3 = getcwd() . '/public/BA/';
            }

            $attachment3->move($destination_path3, $filename3);
            $sla->file_ba = $filename3;
        }

        $sla->save();

        return redirect()->back()->with('success', 'Surat SLA telah disimpan !');
    }

    public function downloadSla(Request $request, $id)
    {
        $data = DB::table('pelayanan')->where('id_', $id)->first();
        $file_path = public_path('SLA') . '/' . $data->file_sla;
        return response()->download($file_path);
    }

    public function downloadBA(Request $request, $id)
    {

        $data = Pelayanan::find($id);
        $file_path = public_path('lampiran').'/'.$data->kd_tiket . '/' . $data->lampiran_balasan;
        return response()->download($file_path);
    }

    public function exportExcel(Request $request)
    {
        $data['title'] = 'Data Pelayanan';
        $data['pelayanan'] = Pelayanan::leftjoin(
            'organisasi',
            'organisasi.id_organisasi',
            '=',
            'pelayanan.id_opd'
        )
            ->leftjoin('users', 'users.id', '=', 'pelayanan.id_agen')
            ->leftjoin('reff_sjns_pelayanan', 'reff_sjns_pelayanan.id_sjns_pelayanan', '=', 'pelayanan.sub_jns_pelayanan')
            ->select('pelayanan.id_ as ids', 'organisasi.nama_opd', 'pelayanan.kd_tiket', 'pelayanan.judul', 'pelayanan.id_pelapor', 'pelayanan.tgl_pelaporan', 'users.nama_depan as nama_agen', 'users.nama_belakang', 'pelayanan.status as status_tiket', 'reff_sjns_pelayanan.jenis_pelayanan as sub_pelynn', 'pelayanan.id_agen as agenID', 'pelayanan.lampiran')
            ->where('pelayanan.jns_pelayanan', '!=', 6)
            ->orderBy('ids', 'DESC')
            ->get();
        Excel::create('Data Pelayanan ' . date('Y') . '', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->loadView('admin.pelayanan.excel_view', $data);
            });
        })->export('xls');
    }
    /**

     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelayanan = Pelayanan::find($id);

        if (!$pelayanan) {
            return view('errors.404');
        }

        $pelayanan->delete();

        return redirect()->route('superAdminPelayananPage', 'Open')->with('success', 'Tiket "' . $pelayanan->kd_tiket . '" telah dihapus!');
    }
}
