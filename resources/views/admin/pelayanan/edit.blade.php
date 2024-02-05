@section('pelayanan-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
    Edit Pelayanan
@endsection

@section('contentheader_title')
    Edit Pelayanan
@endsection

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/adminlte/css/select22.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .radio-toolbar {
            margin: 10px;
        }

        .radio-toolbar input[type="radio"] {
            opacity: 0;
            position: fixed;
            width: 0;
        }

        .radio-toolbar label {
            display: inline-block;
            background-color: #ddd;
            padding: 6px 24px;
            font-family: sans-serif, Arial;
            font-size: 13px;
            border: 2px solid #999;
            border-radius: 4px;
        }

        .radio-toolbar label:hover {
            background-color: #dfd;
        }

        .radio-toolbar input[type="radio"]:focus+label {
            border: 2px dashed #444;
        }

        .radio-toolbar input[type="radio"]:checked+label {
            background-color: #bfb;
            border-color: #4c4;
        }

    </style>
@endsection

@section('additional_scripts')
    <script src="{{ asset('public/adminlte/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('public/js/select_dependent.js') }}"></script>
    <script src="{{ asset('public/js/select_team.js') }}"></script>
    <script type="text/javascript">
        function cancelForm() {
            var x = document.getElementById("formDispo");
            var y = document.getElementById("btnDisposisi");
            var z = document.getElementById("pending");
            var o = document.getElementById("selesai");
            var p = document.getElementById("close");
            var a = document.getElementById("cancel");
            var q = document.getElementById("cancelx");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
                z.style.display = "none";
                o.style.display = "none";
                p.style.display = "none";
                q.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
                z.style.display = "block";
                o.style.display = "block";
                p.style.display = "block";
                q.style.display = "block";
            }
        }

        function agent_status_task_changed(statusAgentTask) {
            //If the checkbox has been checked
            if (statusAgentTask.checked) {
                //Set the disabled property to FALSE and enable the button.
                document.getElementById("solusi").disabled = false;
                document.getElementById("lampiran_balasan").disabled = false;
            } else {
                //Otherwise, disable the submit button.
                document.getElementById("solusi").disabled = true;
                document.getElementById("lampiran_balasan").disabled = true;
            }
        }

        function final_solution_checked(finalSolution) {
            if (finalSolution.checked) {
                //Set the disabled property to FALSE and enable the button.
                document.getElementById("lampiran_solusi").disabled = false;
                document.getElementById("final_solution").disabled = false;
            } else {
                //Otherwise, disable the submit button.
                document.getElementById("lampiran_solusi").disabled = true;
                document.getElementById("final_solution").disabled = true;
            }
        }
    </script>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="box-header bg-title-form">
                    <h3 class="box-title">Formulir Edit Pelayanan</h3>
                </div>
                <div class="box-body border-box">
                    @if ($errors)
                        @foreach ($errors->all() as $message)
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <i class="icon fa fa-warning"></i>
                                {{ $message }}
                            </div>
                        @endforeach
                    @endif

                    <form role="form" method="POST" action="{{ route('pelayanan.update', $pelayanan->id_) }}"
                        enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <!-- <div class="row" style="display: none;margin-bottom: 10px;padding: 5px;" id="formDispo">
                                                                    <div style="background-color: #b7d9ef; border:3px solid #1b94c4;padding:10px;" class="col-md-12">
                                                                    <div class="row" style="margin-bottom:10px">
                                                                    <div class="form-group">
                                                 <div class="col-md-1">
                                                 <label>Team </label>
                                                 </div>
                                                 <div class="col-md-3">
                                                 <select class="form-control js-example-basic-single" style="width: 100% !important;" name="id_team">
                                                    <option value="">- Pilih Team -</option>
                                                    @foreach ($Team as $dataTeam)
                                                            <option value='{{ $dataTeam->id_team }}'>{{ $dataTeam->name_team }}</option>
                                                           @endforeach
                                                    </select>
                                                 </div>
                                                   </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:10px">
                                                                    <div class="form-group">
                                                 <div class="col-md-1">
                                                 <label>Agen</label>
                                                 </div>
                                                 <div class="col-md-3">
                                                 <select class="form-control js-example-basic-single" style="width: 100% !important;" name="agen_id">
                                                    <option value="">- Pilih Agen -</option>
                                                    </select>
                                                 </div>
                                                   </div>
                                                                    </div>
                                                                    
                                                       <div class="row">
                                                        <div class="col-md-12">
                                                         <button name="dispo" value="disposisi" type="submit" class="btn btn-primary">Save</button>&nbsp;
                                                         <a id="cancel" onclick="cancelForm()" class="btn btn-danger">Cancel</a>
                                                        </div>
                                                       </div>
                                                                    </div>
                                                                    </div> -->
                        <div class="row" style="text-align: left;">
                            {{-- <div class="col-md-6">
                                <div class="radio-toolbar">
                                    @if ($pelayanan->status == 'Pending')
                                        <input type="radio" id="radioApple" name="statustiket" value="Pending" checked
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioApple">Pending</label>
                                        <input type="radio" id="radioBanana" name="statustiket" value="Selesai"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioBanana">Selesai</label>
                                        <input type="radio" id="radioOrange" name="statustiket" value="Close"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioOrange">Close Tiket</label>
                                        <input type="radio" id="radioGreen" name="statustiket" value="Diproses"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioGreen">Lanjut Proses</label>
                                    @elseif($pelayanan->status == 'Selesai')
                                        <input type="radio" id="radioOrange" name="statustiket" value="Close"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioOrange">Close Tiket</label>
                                    @elseif($pelayanan->status == 'Close')
                                        <input type="radio" id="radioOrange" name="statustiket" value="Re-open"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioOrange">Re-Open</label>
                                    @else
                                        <input type="radio" id="radioApple" name="statustiket" value="Pending"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioApple">Pending</label>
                                        <input type="radio" id="radioBanana" name="statustiket" value="Selesai"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioBanana">Selesai</label>
                                        <input type="radio" id="radioOrange" name="statustiket" value="Close"
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioOrange">Close Tiket</label>
                                        <input type="radio" id="radioGreen" name="statustiket" value="Diproses"
                                            {{ $pelayanan->status == 'Diproses' ? 'checked' : '' }}
                                            @if ($current_logged_user->role_user == 'Agent') disabled @endif>
                                        <label for="radioGreen">Diproses</label>
                                    @endif
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6" style="text-align: right;">
                                <button name="update" value="update" type="submit" class="btn btn-primary"
                                    style="width: 100px">Save</button>&nbsp;
                                <a href="{{ url()->previous() }}" class="btn btn-danger" style="width: 100px">Cancel</a>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="fieldset-style">
                                    <legend class="legend-style"
                                        style="background-color:#e87c1e;color: #fff;border:none;width: 125px;">Informasi
                                        Umum</legend>
                                    <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
                                    <div class="panel panel-default"
                                        style="border-color: #fff !important;margin-top: -9px;">
                                        <div class="panel-body" style="padding: 0px;">
                                            <div class="row top-22">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Kode Tiket </label>

                                                        <b><input type="text" readonly="" name="" class="form-control"
                                                                value="{{ $pelayanan->kd_tiket }}"></b>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Perangkat Daerah </label>
                                                        <select name="id_opd" disabled class="form-control"
                                                            class="form-control js-example-basic-single">
                                                            <option value="">- Pilih Perangkat Daerah -</option>
                                                            @foreach ($org as $dataorg)
                                                                @if ($pelayanan->id_opd == $dataorg->id_organisasi)
                                                                    <option value='{{ $dataorg->id_organisasi }}'
                                                                        selected>{{ $dataorg->nama_opd }}</option>
                                                                @else
                                                                    <option value="{{ $dataorg->id_organisasi }}">
                                                                        {{ $dataorg->nama_opd }}</option>
                                                                @endif
                                                            @endforeach
                                                            <input type="hidden" name="id_opd"
                                                                value="{{ $pelayanan->id_opd }}" />

                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Perihal</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            value="{{ $pelayanan->judul }}" required
                                                            @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                        @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD')
                                                            <input type="hidden" name="judul"
                                                                value="{{ $pelayanan->judul }}" />
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Contact Person</label>
                                                        <input type="text" class="form-control" name="contact_person"
                                                            value="{{ $pelayanan->contact_person }}"
                                                            @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status <a class="text-red">*</a></label>
                                                        <input
                                                            style="background-color:#ece9bd !important;color:red !important;"
                                                            class="form-control" type="text" name="status"
                                                            value="{{ $pelayanan->status }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi User</label>
                                                        <textarea style="height: 220px;" class="form-control"
                                                            name="deskripsi" readonly><?php echo trim($pelayanan->deskripsi); ?></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="fieldset-style"
                                    style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                    <legend class="legend-style"
                                        style="background-color:#e87c1e;color: #fff;border:none;width: 140px;">Reposisi
                                    </legend>
                                    <div class="panel panel-default" style="border-color: #fff !important;">
                                        <div class="panel-body" style="padding: 0px;">
                                            <div class="form-group">
                                                <label>Pelayanan <a class="text-red">*</a></label>
                                                <select class="form-control js-example-basic-single" name="jns_pelayanan"
                                                    @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                    <option value="">- Pilih Pelayanan -</option>
                                                    @foreach ($JnsPlynn as $dataJns)
                                                        @if ($pelayanan->jns_pelayanan == $dataJns->id_pelayanan)
                                                            <option value='{{ $dataJns->id_pelayanan }}' selected>
                                                                {{ $dataJns->pelayanan }}</option>
                                                        @else
                                                            <option value="{{ $dataJns->id_pelayanan }}">
                                                                {{ $dataJns->pelayanan }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD')
                                                    <input type="hidden" name="jns_pelayanan"
                                                        value="{{ $pelayanan->jns_pelayanan }}" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="fieldset-style"
                                    style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                    <legend class="legend-style"
                                        style="background-color:#e87c1e;color: #fff;border:none;width: 140px;">Disposisi
                                    </legend>
                                    <div class="panel panel-default" style="border-color: #fff !important;">
                                        <div class="panel-body" style="padding: 0px;">
                                            <div class="form-group">
                                                <label>Team <a class="text-red">*</a></label>
                                                <select class="form-control js-example-basic-single"
                                                    style="width: 100% !important;" name="id_team" disabled>
                                                    <option value="">- Pilih Team -</option>
                                                    @foreach ($Team as $dataTeam)
                                                        @if ($pelayanan->id_team == $dataTeam->id_team)
                                                            <option value='{{ $dataTeam->id_team }}' selected>
                                                                {{ $dataTeam->name_team }}</option>
                                                        @else
                                                            <option value='{{ $dataTeam->id_team }}'>
                                                                {{ $dataTeam->name_team }}</option>
                                                        @endif
                                                    @endforeach
                                                    {{-- @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') --}}
                                                    <input type="hidden" name="id_team"
                                                        value="{{ $pelayanan->id_team }}" />
                                                    {{-- @endif --}}
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Agen <a class="text-red">*</a></label>
                                                <select class="form-control js-example-basic-single"
                                                    style="width: 100% !important;" name="agen_id" @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>

                                                    @if (!empty($pelayanan->id_agen))
                                                        <option value='{{ $pelayanan->id_agen }}' selected>
                                                            {{ $pelayanan->agent->nama_depan }}</option>
                                                    @elseif (!empty($pelayanan->team)))
                                                        <option value="">- Pilih Agen -</option>
                                                        @foreach ($pelayanan->team->member as $member)
                                                            <option value="{{ $member->id }}">
                                                                {{ $member->nama_depan }}
                                                                {{ $member->nama_belakang }}</option>
                                                        @endforeach

                                                    @endif
                                                </select>
                                                @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD')
                                                    <input type="hidden" name="agen_id"
                                                        value="{{ $pelayanan->id_agen }}" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="fieldset-style"
                                    style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">
                                    <legend class="legend-style"
                                        style="background-color:#e87c1e;color: #fff;border:none;width: 120px;">Data Layanan
                                    </legend>
                                    <div class="panel panel-default" style="border-color: #fff !important;">
                                        <div class="panel-body" style="padding: 0px;">
                                            <div class="row top-22">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="statusTiket" class="form-control"
                                                                    value="{{ $pelayanan->status }}" disabled />
                                                                <input type="hidden" name="statusTiket"
                                                                    class="form-control"
                                                                    value="{{ $pelayanan->status }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Tanggal Laporan </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" readonly class="form-control" name=""
                                                                    value="{{ $pelayanan->tgl_pelaporan }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Tanggal Update</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" readonly class="form-control"
                                                                    name="tgl_update"
                                                                    value="{{ $pelayanan->tgl_update }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Lampiran file User</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                @if (empty($pelayanan->lampiran))
                                                                    Tidak Ada Lampiran
                                                                @else
                                                                    <a href="{{ url('downloadLampiran') }}/{{ $pelayanan->id_ }}"
                                                                        type="button">{{ $pelayanan->lampiran }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Lampiran Surat Dinas</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <a
                                                                    href="{{ URL::asset('public/lampiran/' . $pelayanan->kd_tiket . '/' . $pelayanan->file_surat_dinas) }}">{{ $pelayanan->file_surat_dinas }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                @if ($progres_agen != null)
                                    <fieldset class="fieldset-style"
                                        style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;width: 80px;">Lainnya
                                        </legend>
                                        <div class="panel panel-default" style="border-color: #fff !important;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group">
                                                    <label>File Extend</label>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if (empty($pelayanan->lampiran_balasan))
                                                        <i>Not Found </i>
                                                    @else
                                                        <a href="{{ url('downloadInsisden') }}/{{ $pelayanan->id_ }}"
                                                            type="button">{{ $pelayanan->lampiran_balasan }}</a>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Lampiran</label>
                                                    <input class="form-control" id="lampiran_balasan" type="file"
                                                        name="lampiran_balasan" @if ($progres_agen->status == 1) disabled @endif>
                                                    <input type="hidden" name="stage" value="{{ $pelayanan->stage }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Terhubung dengan koordinator agen & agen</label>
                                                    <textarea style="height: 180px;" class="form-control" id="solusi"
                                                        name="solusi" @if ($progres_agen->status == 1) disabled @endif></textarea>
                                                </div>
                                                @if ($progres_agen != null)
                                                    <div class="form-group">
                                                        <div
                                                            class="checkbox 
                                                    @if (Auth::user()->role_user == 'Agen')
                                                        btn btn-success
                                                    @elseif(Auth::user()->role_user == 'Koordinator Agen')
                                                        btn btn-danger
                                                    @endif
                                                    ">
                                                            <label>
                                                                @if (Auth::user()->role_user == 'Agen')
                                                                    <input type="checkbox" name="statusTask" value="1"
                                                                        @if ($progres_agen->status == 1) checked disabled @endif> Selesai
                                                                @elseif(Auth::user()->role_user == 'Koordinator Agen')
                                                                    <input type="checkbox" name="statusTask"
                                                                        onclick="agent_status_task_changed(this)" value="0"
                                                                        @if ($progres_agen->status == 0) checked @endif>
                                                                    Diproses
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                    @if (Auth::user()->role_user == 'Koordinator Agen' && $progres_agen->status == 1)
                                        <fieldset class="fieldset-style"
                                            style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                            <legend class="legend-style"
                                                style="background-color:#1e21e8;color: #fff;border:none;width: 6vw;">Solusi
                                                Akhir
                                            </legend>
                                            <div class="panel panel-default" style="border-color: #fff !important;">
                                                <div class="panel-body" style="padding: 0px;">

                                                    <div class="form-group">
                                                        <div class="checkbox btn btn-primary">
                                                            <label>
                                                                <input onclick="final_solution_checked(this)"
                                                                    type="checkbox" name="finalSolution" value="1">Solusi
                                                                Akhir
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Lampiran</label>
                                                        <input class="form-control" id="lampiran_solusi" type="file"
                                                            name="lampiran_solusi" @if ($progres_agen->status == 1) disabled @endif>
                                                        <input type="hidden" name="stage"
                                                            value="{{ $pelayanan->stage }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Solusi Akhir </label>
                                                        <textarea style="height: 180px;" class="form-control"
                                                            id="final_solution" name="final_solution"
                                                            @if ($progres_agen->status == 1) disabled @endif></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>
                                    @endif
                                @endif

                                @if (in_array(Auth::user()->role_user, ['Agen', 'Koordinator Agen']) && $pelayanan->flow_pelayanan->name == 'Pemberian Hasil dan BA')
                                    @if (Auth::user()->role_user == 'Agen')


                                        @if (in_array($pelayanan->status_ba_agent, [0]))
                                            <fieldset class="fieldset-style"
                                                style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                                <legend class="legend-style"
                                                    style="background-color:#1e21e8;color: #fff;border:none;width: 6vw;">
                                                    Berita
                                                    Acara</legend>
                                                <div class="panel panel-default" style="border-color: #fff !important;">
                                                    <div class="panel-body" style="padding: 0px;">

                                                        <div class="form-group">
                                                            <label>Deskripsi Berita Acara</label>
                                                            <textarea style="height: 180px;" class="form-control"
                                                                id="komen_slaba" name="komen_slaba"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Lampiran Berita Acara</label>
                                                            <input class="form-control" id="lampiran_solusi" type="file"
                                                                name="file_ba">
                                                            <input type="hidden" name="stage"
                                                                value="{{ $pelayanan->stage }}" />
                                                        </div>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        @else
                                            <fieldset class="fieldset-style"
                                                style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                                <legend class="legend-style"
                                                    style="background-color:#1e21e8;color: #fff;border:none;width: 6vw;">
                                                    Berita
                                                    Acara</legend>
                                                <div class="panel panel-default" style="border-color: #fff !important;">
                                                    <div class="panel-body" style="padding: 0px;">

                                                        <div class="form-group">
                                                            <label>Deskripsi Berita Acara</label>
                                                            <textarea style="height: 180px;" class="form-control"
                                                                id="komen_slaba"
                                                                readonly>{{ $pelayanan->komen_slaba }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-9">
                                                                @if (!empty($pelayanan->file_ba))
                                                                    Download file BA : <a
                                                                        href="{{ url('downloadBA') }}/{{ $pelayanan->id_ }}"
                                                                        type="button">{{ $pelayanan->file_ba }}</a>
                                                                @else
                                                                    <i style="color:red">Belum ditindak lanjuti</i>
                                                                @endif
                                                                <p></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        @endif
                                    @else
                                        <fieldset class="fieldset-style"
                                            style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                            <legend class="legend-style"
                                                style="background-color:#1e21e8;color: #fff;border:none;width: 6vw;">
                                                Berita
                                                Acara</legend>
                                            <div class="panel panel-default" style="border-color: #fff !important;">
                                                <div class="panel-body" style="padding: 0px;">

                                                    <div class="form-group">
                                                        <label>Deskripsi Berita Acara</label>
                                                        <textarea style="height: 180px;" class="form-control"
                                                            id="komen_slaba"
                                                            readonly>{{ $pelayanan->komen_slaba }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            @if (!empty($pelayanan->file_ba))
                                                                Download file BA : <a
                                                                    href="{{ url('downloadBA') }}/{{ $pelayanan->id_ }}"
                                                                    type="button">{{ $pelayanan->file_ba }}</a>
                                                            @else
                                                                <i style="color:red">Belum ditindak lanjuti</i>
                                                            @endif
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="cars">Validasi BA</label>
                                                        <select class="form-control" name="status_ba_agent"
                                                            id="status_ba_agent">
                                                            <option value="0">Perbaiki</option>
                                                            <option value="1">Selesai</option>
                                                        </select>

                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>
                                    @endif

                                @endif
                                @if ($pelayanan->id_agen != null)
                                    <fieldset class="fieldset-style"
                                        style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;width: 75px;">Checklist
                                        </legend>
                                        <div class="panel panel-default" style="border-color: #fff !important;">
                                            <div class="panel-body" style="padding: 0px;">
                                                @foreach ($checklist as $c)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="list_checklist[]"
                                                                value="{{ $c->id }}"
                                                                {{ $c->status == 1 ? 'checked' : '' }}
                                                                @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                            {{ $c->checklist->checklist_name }}
                                                        </label><input type="text" class="form-control"
                                                            name="{{ $c->id }}-detailChecklist"
                                                            placeholder="Detail Checklist" value="{{ $c->detail }}"
                                                            @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </fieldset>
                                @endif
                            </div>


                        </div>
                        <hr class="border-hr">
                        <div class="row text-right">
                            <div class="col-md-12">
                                <button name="update" value="update" type="submit" class="btn btn-primary"
                                    style="width: 100px">Simpan</button>&nbsp;
                                <a href="{{ url()->previous() }}" class="btn btn-danger"
                                    style="width: 100px">Kembali</a>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="{{ url('chatUser') }}" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <fieldset class="fieldset-style"
                                    style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                    <legend class="legend-style"
                                        style="width: 65px;background-color:#e87c1e;color: #fff;border:none;">
                                        Chat
                                    </legend>
                                    <div class="panel panel-default"
                                        style="background: #f9f9f9;border-color: #fff !important;">
                                        <div class="panel-body" style="padding: 0px;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Komentar & Balasan</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="direct-chat-messages">
                                                            @foreach ($pelayanan->chat_support as $chat)
                                                                <div class="direct-chat-msg">
                                                                    <div class="direct-chat-infos clearfix">
                                                                        <span
                                                                            class="direct-chat-name float-left">{{ $chat->user->id }}
                                                                            -
                                                                            ({{ $chat->user->role_user }}){{ $chat->user->nama_depan }}
                                                                            {{ $chat->user->nama_belakang }}</span>
                                                                        <span
                                                                            class="direct-chat-timestamp float-right">{{ $chat->created_at }}</span>
                                                                    </div>
                                                                    <div class="direct-chat-text" style="margin:5px">
                                                                        {{ $chat->chat }} @if (count($chat->attachment) > 0)
                                                                            <br>Lampiran : <br>
                                                                            @foreach ($chat->attachment as $attachment)
                                                                                - <a
                                                                                    href="{{ URL::asset('public/lampiran/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
                                                                                <br>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <!-- /.direct-chat-text -->
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Balas Komentar</label>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="text" name="chat" class="form-control">
                                                    <input type="hidden" name="pelayanan_id"
                                                        value="{{ $pelayanan->id_ }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="input-group control-group increment">
                                                <input type="file" name="lampiran[]" class="form-control">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-success" type="button"><i
                                                            class="glyphicon glyphicon-plus"></i>Add</button>
                                                </div>
                                            </div>
                                            <div class="clone hide">
                                                <div class="control-group input-group" style="margin-top:10px">
                                                    <input type="file" name="lampiran[]" class="form-control">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-danger" type="button"><i
                                                                class="glyphicon glyphicon-remove"></i>
                                                            Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
							<div class="row">
								<div class="col-sm-3">
									<label>Lampiran</label>
								</div>
								<div class="col-sm-9">
									<input type="file" name="lampiran" class="form-control">
								</div>
							</div>
						</div> --}}
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <button type="submit" name="update" value="update"
                                                        class="btn"
                                                        style="background: #4f715a;color: #fff;">Kirim</button>
                                                </div>
                                                <div class="col-sm-9">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="fieldset-style"
                                style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                <legend class="legend-style"
                                    style="width: 81px;background-color:#e87c1e;color: #fff;border:none;">
                                    Lampiran</legend>
                                <div class="panel panel-default"
                                    style="background: #f9f9f9;border-color: #fff !important;">
                                    <div class="panel-body" style="padding: 0px;">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span style="color:#3a6d99;font-weight:bold;">Lampiran
                                                        (Diurutkan berdasarkan Waktu Upload</span>
                                                </div>
                                                <div class="col-sm-12">
                                                    <ul>
                                                        @foreach ($pelayanan->attachment as $attachment)
                                                            <li><a
                                                                    href="{{ URL::asset('public/lampiran/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
