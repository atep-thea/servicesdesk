@section('pelayanan-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
    Detail Permintaan
@endsection

@section('contentheader_title')
    Detail Permintaan
@endsection

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/adminlte/css/select22.min.css') }}" rel="stylesheet" />
    <style>
        .checked {
            color: orange;
        }

    </style>
@endsection

@section('additional_scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('public/adminlte/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
    {{-- <script src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {

            $('#syarat').html(marked.parse(JSON.parse({!! json_encode($syarat) !!})));
            $(".btn-success").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });

            $(function() {
                var table = $('#dataTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: '{!! route('pelayananAgentTaskData.data', $pelayanan->id_) !!}',
                    search: {
                        caseInsensitive: false
                    },
                    columns: [{
                            data: 'stage',
                            name: 'agent_task.flow.stage',
                            searchable: true
                        },
                        {
                            data: 'solusi',
                            name: 'agent_task.task_report',
                            searchable: true
                        },
                        {
                            data: 'lampiran',
                            name: 'attachmentFinalSolution.filename',
                            searchable: true
                        },
                        {
                            data: 'berita_acara',
                            name: 'attachmentFinalSolution.filename',
                            searchable: true
                        },
                        {
                            data: 'nama_stage',
                            name: 'agent_task.flow.name'
                        },
                        {
                            data: 'nama_agen',
                            name: 'agent_task.user.nama_depan',
                            searchable: true
                        },
                    ],
                });
                new $.fn.dataTable.FixedHeader(table);
            });



        });

        function success() {
            if (document.getElementById("chat").value === "") {
                document.getElementById('update').disabled = true;
            } else {
                document.getElementById('update').disabled = false;
            }
        }


        $('#reposisi_layanan').select2({
            dropdownParent: $('#modal-reposisi')
        });

        var checklist_length = {{ count($checklist) }};

        // $('#chk1').change(function () {
        //     console.log("Di checklist");
        //     console.log($("#chk1:checked").length);
        // if ($("#chk1:checked").length >= checklist_length) {
        //     $('#btnSelesai').removeAttr('disabled');
        //     } else {
        //         $('#btnClick').attr('disabled', 'disabled');
        //     }
        // });
        function toggle(source) {
            console.log('Di klik');
            checkboxes = document.getElementsByClassName('chk1');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = true;
                var newdiv = document.createElement('div');
                inputField = document.getElementById("" + checkboxes[i].value + "-detailChecklist")

                newdiv.innerHTML = "<input type='hidden' name='list_checklist[]' value='" + checkboxes[i].value +
                    "'><br><input type='hidden' name='" + checkboxes[i].value + "-detailChecklist' value='" + inputField
                    .value + "'>";

                document.getElementById('formLaporanSelesaiProgressAgen').appendChild(newdiv);


            }
            document.getElementById("btnSelesai").disabled = false;

        }
    </script>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Informasi</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Tracking</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box-header bg-title-form">
                            <h3 class="box-title">Form Permintaan</h3>
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
                            @if (Session::has('success'))
                                <script>
                                    $(document).ready(function() {
                                        $('#sukses-modal').modal('show');
                                    });
                                </script>
                                <div class="modal fade" id="sukses-modal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content" style="margin-left: 37%;margin-top: 20%;width: 50%;">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12" style="text-align: center">
                                                        <img src="{{ asset('public/images/success-icon.png') }}"
                                                            style="width: 50%;">
                                                        <h4 class="modal-title" id="exampleModalLongTitle">
                                                            <strong>Sukses!</strong>
                                                        </h4>
                                                        <h5>{{ Session::get('success') }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-success" style="text-align: center">
                                                <button type="button" class="btn btn-success" data-dismiss="modal"
                                                    style="width:95%;">Ok</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="fieldset-style">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;width: 125px;">Informasi
                                            Umum</legend>
                                        <div class="panel panel-default"
                                            style="border-color: #fff !important;margin-top: -9px;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="row top-22">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>No Tiket </label>
                                                                </div>
                                                                <div class="col-sm-9" style="font-size: 16px;">
                                                                    <b>{{ $pelayanan->kd_tiket }}</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Pelapor </label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($pelayanan->pelapor))
                                                                        {{ $pelayanan->pelapor->nama_depan }}
                                                                        {{ $pelayanan->pelapor->nama_belakang }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>PIC & NO HP PIC</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    {{ $pelayanan->contact_person }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Organisasi </label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    {{ $pelayanan->organisasi->nama_opd }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Tanggal Laporan </label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <input type="text" readonly class="form-control"
                                                                        name="" value="{{ $pelayanan->tgl_pelaporan }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Perihal</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <input type="text" readonly class="form-control"
                                                                        name="judul" value="{{ $pelayanan->judul }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Deskripsi User </label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <textarea style="height:280px" class="form-control" readonly>{{ $pelayanan->deskripsi }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Surat Dinas</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <a
                                                                        href="{{ URL::asset('public/lampiran/' . $pelayanan->kd_tiket . '/' . $pelayanan->file_surat_dinas) }}">{{ $pelayanan->file_surat_dinas }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Lampiran file User</label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <a
                                                                        href="{{ URL::asset('public/lampiran/' . $pelayanan->kd_tiket . '/' . $pelayanan->lampiran) }}">{{ $pelayanan->lampiran }}</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <br>
                                    <form method="POST" action="{{ url('chatUser') }}" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <fieldset class="fieldset-style"
                                            style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                            <legend class="legend-style"
                                                style="width: 10vw;background-color:#e87c1e;color: #fff;border:none;">
                                                Chat dengan user
                                            </legend>
                                            <div class="panel panel-default"
                                                style="background: #f9f9f9;border-color: #fff !important;">
                                                <div class="panel-body" style="padding: 0px;">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Pesan</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                @if (count($pelayanan->chat_support) == 0)
                                                                @else
                                                                    <div class="direct-chat-messages">
                                                                        @foreach ($pelayanan->chat_support as $chat)
                                                                            <div class="direct-chat-msg">
                                                                                <div class="direct-chat-infos clearfix">
                                                                                    <span
                                                                                        class="direct-chat-name float-left">{{ $chat->user->id }}
                                                                                        - ({{ $chat->user->role_user }})
                                                                                        {{ $chat->user->nama_depan }}
                                                                                        {{ $chat->user->nama_belakang }}</span>
                                                                                    <span
                                                                                        class="direct-chat-timestamp float-right">{{ $chat->created_at }}</span>
                                                                                </div>
                                                                                <div class="direct-chat-text"
                                                                                    style="margin:5px">
                                                                                    {{ $chat->chat }} @if (count($chat->attachment) > 0)
                                                                                        <br>Lampiran : <br>
                                                                                        @foreach ($chat->attachment as $attachment)
                                                                                            - <a
                                                                                                href="{{ URL::asset('public/lampiran/' . $pelayanan->kd_tiket . '/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
                                                                                            <br>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                                <!-- /.direct-chat-text -->
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <label>Balas Pesan</label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="chat" type="text" onkeyup="success()" name="chat"
                                                                class="form-control"
                                                                @if (in_array($pelayanan->status, ['Selesai', 'Close']) || Auth::user()->role_user == 'Helpdesk') disabled @endif>
                                                            <input type="hidden" name="pelayanan_id"
                                                                value="{{ $pelayanan->id_ }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group control-group increment">
                                                        <input type="file" name="lampiran[]" class="form-control"
                                                            @if (in_array($pelayanan->status, ['Selesai', 'Close']) || Auth::user()->role_user == 'Helpdesk') disabled @endif>
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-success" type="button"
                                                                @if (in_array($pelayanan->status, ['Selesai', 'Close']) || Auth::user()->role_user == 'Helpdesk') disabled @endif><i
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
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <button type="submit" id="update" name="update" value="update"
                                                                class="btn"
                                                                style="background: #4f715a;color: #fff;"
                                                                disabled>Simpan</button>
                                                        </div>
                                                        <div class="col-sm-9">

                                                        </div>
                                                    </div>
                                                </div>
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
                                                                            href="{{ URL::asset('public/lampiran/' . $pelayanan->kd_tiket . '/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <br>
                                </div>

                                <div class="col-md-6">
                                    <fieldset class="fieldset-style"
                                        style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="width: 6vw;background-color:#e87c1e;color: #fff;border:none;">Layanan
                                        </legend>
                                        <div class="panel panel-default"
                                            style="background: #f9f9f9;border-color: #fff !important;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Layanan</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" readonly class="form-control"
                                                                name="jns_pelayanan"
                                                                value="{{ $pelayanan->jenis_pelayanan->pelayanan }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Detail Progress</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <small
                                                                class="badge label-primary">{{ $pelayanan->flow_pelayanan->name }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Tanggal Update </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" readonly class="form-control" name=""
                                                                value="{{ $pelayanan->tgl_update }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role_user != 'Verifikator PD')

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Agen </label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                @if (empty($pelayanan->agent))
                                                                    -
                                                                @else
                                                                    {{ $pelayanan->agent->nama_depan }}
                                                                    {{ $pelayanan->agent->nama_belakang }}
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Tanggal Update </label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" readonly class="form-control" name=""
                                                                    value="{{ $pelayanan->tgl_update }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">

                                                            <div class="col-sm-3">
                                                                <label>File Berita Acara</label>
                                                            </div>
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
                                                    @if (in_array($pelayanan->status_tiket, ['Selesai', 'Closed']))
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label>Survey Kepuasan </label>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    @if ($pelayanan->survey_rate != null)
                                                                        @for ($i = 0; $i < $pelayanan->survey_rate; $i++)
                                                                            <span class="fa fa-star checked"></span>
                                                                        @endfor
                                                                        ({{ $pelayanan->survey_rate }} dari 5)
                                                                    @else
                                                                        Belum Ada Rating
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <b>Balas BA</b>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    @if (!empty($pelayanan->ba_bls))
                                                                        Download file => <a
                                                                            href="{{ url('downloadBAReply') }}/{{ $pelayanan->id_ }}"
                                                                            type="button">{{ $pelayanan->ba_bls }}</a>
                                                                    @else
                                                                        <i style="color:red">Belum ditindak lanjuti</i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                            </div>
                                        </div>
                                        @endif
                                    </fieldset>
                                    @if (Auth::user()->role_user != 'Verifikator PD')
                                    <fieldset class="fieldset-style"
                                        style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;">Progres Agen
                                        </legend>
                                        <div class="row" style="width: 40vw;height: 10vw;overflow: scroll;">
                                            <div class="col-md-12">
                                                @if ($progres_agen->isEmpty())
                                                    <p>Belum ada data</p>
                                                @else
                                                    <ul class="timeline">

                                                        @foreach ($progres_agen as $p)
                                                            <li>
                                                                <i class="fa fa-user bg-blue"></i>

                                                                <div class="timeline-item">
                                                                    <span class="time"><i
                                                                            class="fa fa-clock-o"></i>{{ $p->created_at }}</span>

                                                                    <h3 class="timeline-header">
                                                                        {{ $p->user->role_user }}
                                                                        {{ $p->user->nama_depan }}
                                                                        -
                                                                        {{ $p->user->nama_belakang }} @if ($p->final_solution == 1)
                                                                            <small class="badge label-primary">Solusi
                                                                                Langkah
                                                                                {{ $pelayanan->flow_pelayanan->stage }}</small>
                                                                        @endif
                                                                    </h3>
                                                                    <div class="timeline-body">
                                                                      Solusi :  {{ $p->task_report }}
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        @foreach ($p->attachment as $attachment)
                                                                            <a href="{{ url('downloadTaskAttachment') }}/{{ $pelayanan->kd_tiket }}/{{ $attachment->id }}"
                                                                                type="button">{{ $attachment->filename }}</a>
                                                                            <br>
                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif


                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="fieldset-style"
                                        style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;">Lampiran Progres Agen
                                        </legend>
                                        <div class="panel panel-default" style="border-color: #fff !important;">
                                            <div class="panel-body table-responsive" style="padding: 0px;">
                                                <table class="table table-hover table-striped" id="dataTable"
                                                    style="width: 100%">
                                                    <thead class="bg-head-table">
                                                        <tr>
                                                            <th>Stage</th>
                                                            <th>Solusi</th>
                                                            <th>Lampiran</th>
                                                            <th>Berita Acara</th>
                                                            <th>Nama Stage</th>
                                                            <th>Agen</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                            </div>
                                        </div>
                                    </fieldset>
                                    @if (Auth::user()->role_user == 'Koordinator Agen'  && is_object($last_progres_agen) && $last_progres_agen->status == 1 && ($pelayanan->status == 'Diproses' || !empty($pelayanan->id_agen)))
                                        <fieldset class="fieldset-style"
                                            style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                            <legend class="legend-style"
                                                style="background-color:#e87c1e;color: #fff;border:none;width: 75px;">
                                                Checklist
                                            </legend>
                                            <div class="panel panel-default" style="border-color: #fff !important;">
                                                <div class="panel-body" style="padding: 0px;">

                                                    @foreach ($checklist as $c)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="chk1"
                                                                    name="list_checklist[]" value="{{ $c->id }}"
                                                                    {{ $c->status == 1 ? 'checked' : '' }}
                                                                    @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                                {{ $c->checklist->checklist_name }}
                                                            </label><input type="text" class="form-control"
                                                                name="{{ $c->id }}-detailChecklist"
                                                                id="{{ $c->id }}-detailChecklist"
                                                                placeholder="Detail Checklist" value="{{ $c->detail }}"
                                                                @if ($current_logged_user->role_user == 'Agen' or $current_logged_user->role_user == 'Verifikator PD') disabled @endif>
                                                        </div>
                                                    @endforeach
                                                    <button onClick="toggle(this)">Checklist Semua</button><br />
                                                </div>
                                            </div>
                                        </fieldset>
                                    @else
                                        @if (!$checklist->isEmpty())
                                            <fieldset class="fieldset-style"
                                                style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                                <legend class="legend-style"
                                                    style="background-color:#e87c1e;color: #fff;border:none;width: 75px;">
                                                    Checklist
                                                </legend>
                                                <div class="panel panel-default" style="border-color: #fff !important;">
                                                    <div class="panel-body" style="padding: 0px;">

                                                        @foreach ($checklist as $c)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" id="chk1" name="list_checklist[]"
                                                                        value="{{ $c->id }}"
                                                                        {{ $c->status == 1 ? 'checked' : '' }} disabled>
                                                                    {{ $c->checklist->checklist_name }}
                                                                </label><input type="text" class="form-control"
                                                                    placeholder="Detail Checklist"
                                                                    value="{{ $c->detail }}" disabled>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </fieldset>
                                        @endif
                                    @endif
                                    <fieldset class="fieldset-style"
                                        style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                        <legend class="legend-style"
                                            style="background-color:#e87c1e;color: #fff;border:none;width: 100px;">
                                            Persyaratan
                                        </legend>
                                        <div class="panel panel-default" style="border-color: #fff !important;">
                                            <div class="panel-body" style="padding: 0px;" id="syarat">

                                            </div>
                                        </div>
                                    </fieldset>
                                    @endif
                                </div>



                                <div class="row pull-right">
                                    @if (Auth::user()->role_user == 'Agen' && is_object($last_progres_agen) && $last_progres_agen->status != 1 && ($pelayanan->status == 'Diproses' || !empty($pelayanan->id_agen)))
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-solusi-agen">
                                                Laporkan Progres
                                            </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                                Batal
                                            </a>
                                        </div>
                                    @endif


                                    @if (Auth::user()->role_user == 'Koordinator Agen' && is_object($last_progres_agen) && $last_progres_agen->status == 1 && ($pelayanan->status == 'Diproses' || !empty($pelayanan->id_agen)))
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-perbaiki-progress-agent-task">
                                                Perbaiki
                                            </button>
                                            <button type="button" id="btnSelesai" class="btn btn-info"
                                                data-toggle="modal" data-target="#modal-selesai-solusi-agen" disabled>
                                                Selesai
                                            </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                                Batal
                                            </a>
                                        </div>
                                    @endif

                                    @if (Auth::user()->role_user == 'Koordinator Agen' && $pelayanan->flow_pelayanan->name == 'Penutupan Permintaan Layanan')
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-toggle="modal"
                                                data-target="#modal-finalTutupTiket">
                                                Tutup Tiket
                                            </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                                Batal
                                            </a>
                                        </div>
                                    @endif

                                    @if (Auth::user()->role_user == 'Verifikator PD' && $pelayanan->flow_pelayanan->name == 'Validasi Permintaan Layanan')
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#modal-valid">
                                                Valid
                                            </button>

                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#modal-tutupTiket">
                                                Tutup Tiket
                                            </button>

                                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                                Batal
                                            </a>
                                        </div>
                                    @endif
                                    @if (Auth::user()->role_user == 'Koordinator Agen' && empty($pelayanan->id_agen) && !is_object($last_progres_agen) && ($pelayanan->status == 'Open' || $pelayanan->status == 'Diproses'))
                                        <div class="col-md-12">
                                            @if ($current_stage == 3)
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#modal-reposisi">
                                                    Reposisi
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#modal-disposisi">
                                                Proses
                                            </button>
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#modal-nextStep">
                                                Lanjut Next Step
                                            </button>
                                            @if ($current_stage == 3)
                                                <button type="button" class="btn btn-default" data-toggle="modal"
                                                    data-target="#modal-tutupTiket">
                                                    Tutup Tiket
                                                </button>
                                            @endif
                                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                                Batal
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- Modal Valid --}}
                            <div class="modal fade" id="modal-valid" style="display: none;">
                                <form role="form" method="POST" action="{{ url('validasiPD') }}"
                                    enctype="multipart/form-data">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Validasi PD</h4>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                Apa Anda Yakin Akan Melanjutkan?
                                            </div>
                                            <div class="modal-footer">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-primary">Validasi Tiket</button>
                                                    <button type="button" data-dismiss="modal"
                                                        class="btn">Batal</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- End of Modal Valid --}}
                            {{-- Modal Agen Selesai Laporan Progres --}}
                            <div class="modal fade" id="modal-selesai-solusi-agen" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Input Solusi Final</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formLaporanSelesaiProgressAgen" role="form" method="POST"
                                                action="{{ url('laporanSelesaiProgressAgen') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Solusi</label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <textarea name="solusi" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Lampiran</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" readonly class="form-control"
                                                                name="file_lampiran">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($before_end == true)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Berita Acara</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="file" readonly class="form-control"
                                                                    name="file_ba">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success ">Simpan</button>
                                                        <button type="button" class="btn btn-default "
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of Modal Agen Selesai Laporan Progres --}}
                            {{-- Modal Agen Laporan Progres --}}
                            <div class="modal fade" id="modal-solusi-agen" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Laporan Progres</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('laporanProgresAgen') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Solusi</label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <textarea name="solusi" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Lampiran</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" readonly class="form-control"
                                                                name="file_lampiran">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($before_end)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Berita Acara</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="file" readonly class="form-control"
                                                                    name="file_ba">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of Modal Agen Laporan Progres --}}

                            {{-- Modal Agen Perbaiki Laporan Progres --}}
                            <div class="modal fade" id="modal-perbaiki-progress-agent-task" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Perbaiki Laporan Progres</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('perbaikiProgresAgen') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Komentar</label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <textarea name="solusi" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Lampiran</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" readonly class="form-control"
                                                                name="file_lampiran">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of Modal Perbaiki Agen Laporan Progres --}}

                            {{-- Modal Reposisi --}}
                            <div class="modal fade" id="modal-reposisi" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Reposisi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('reposisi') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>No Tiket </label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <b>{{ $pelayanan->kd_tiket }}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <select id="new_layanan" name="new_layanan" style="width:100%">
                                                        <option selected disabled>Pilih Layanan</option>
                                                        @foreach ($JnsPlynn as $layanan)
                                                            <option value='{{ $layanan->id_pelayanan }}'>
                                                                {{ $layanan->pelayanan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of Modal Reposisi --}}
                            {{-- Modal Disposisi --}}
                            <div class="modal fade" id="modal-disposisi" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Proses Disposisi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('diposisiTeam') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>No Tiket </label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <b>{{ $pelayanan->kd_tiket }}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Layanan</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" readonly class="form-control"
                                                                name="jns_pelayanan"
                                                                value="{{ $pelayanan->jenis_pelayanan->pelayanan }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Team</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            @if($pelayanan->team != NUll)
                                                                <input type="text" readonly class="form-control"
                                                                name="team_name"
                                                                value="{{ $pelayanan->team->name_team }}">
                                                            @endif
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <select id="agen" name="agen" style="width:100%">
                                                        <option selected disabled>Pilih Agen</option>
                                                        @foreach ($agen as $agen)
                                                            <option value='{{ $agen->userId }}'>
                                                                {{ $agen->nama_depan }}
                                                                {{ $agen->nama_belakang }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Proses</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of ModaL Disposisi --}}
                            {{-- Modal Tutup Tiket Final --}}
                            <div class="modal fade" id="modal-finalTutupTiket" style="display: none;">
                                <form role="form" method="POST" action="{{ url('tutupTiket') }}"
                                    enctype="multipart/form-data">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Tutup Tiket</h4>
                                            </div>
                                            <div class="modal-body">

                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                Apa Anda Yakin akan menutup Tiket?

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary pull-right">Tutup
                                                    Tiket</button>
                                                <button type="button" data-dismiss="modal"
                                                    class="btn pull-right">Batal</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- End of Modal Tutup Tiket --}}
                            {{-- Modal Tutup Tiket --}}
                            <div class="modal fade" id="modal-tutupTiket" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Tutup Tiket</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('finalTutupTiket') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Deskripsi</label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <textarea name="deskripsi" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Lampiran</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" readonly class="form-control"
                                                                name="file_lampiran">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role_user != 'Verifikator PD')
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Berita Acara Ditutup</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="file" readonly class="form-control"
                                                                    name="file_ba">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Proses</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of Modal Tutup Tiket --}}
                            {{-- Modal Next Step --}}
                            <div class="modal fade" id="modal-nextStep" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Lanjut Next Step</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('nextStep') }}"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id_ }}">
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Solusi</label>
                                                        </div>
                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                            <textarea name="finalSolution" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>File Lampiran Solusi</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="file" readonly class="form-control"
                                                                name="lampiran_solusi">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($before_end == true)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Berita Acara</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="file" readonly class="form-control"
                                                                    name="file_ba">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">Proses</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of modal Next Step --}}

                        </div>
                        <hr class="border-hr">
                    </div>
                    <div class="tab-pane" id="tab_2">
                        {{-- Timeline --}}
                        <div class="row">

                            <div class="col-md-6">
                                <!-- The time line -->
                                <h1>Detail Progress</h1>
                                <ul class="timeline">
                                    @foreach ($flow_pelayanan as $flow)
                                        <!-- timeline time label -->
                                        @if ($current_stage >= $flow->stage)
                                            <li class="time-label">
                                                <span class="bg-blue">
                                                    Proses Ke {{ $flow->stage }}
                                                </span>
                                            </li>
                                        @else
                                            <li class="time-label">
                                                <span class="bg-gray">
                                                    Proses Ke {{ $flow->stage }}
                                                </span>
                                            </li>
                                        @endif

                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-arrow-down bg-aqua"></i>
                                            <div class="timeline-item">
                                                <div class="timeline-body">
                                                    {{ $flow->name }}
                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="time-label">
                                        <span class="bg-red">
                                            Selesai
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>


@endsection
