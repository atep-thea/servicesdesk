@section('request_progress-link')class="active" @stop
@extends('layout.adminlte.user_portal')
@section('contentheader_title')
@endsection
@section('main-content')
@section('additional_scripts')
    <script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".btn-success").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });

        });

        function success() {
            if (document.getElementById("chat").value === "") {
                document.getElementById('update').disabled = true;
            } else {
                document.getElementById('update').disabled = false;
            }
        }
    </script>
@endsection
<style>
    .checked {
        color: orange;
    }

</style>

<div class="row">

    <div class="col-md-12">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Informasi</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tracking</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box-header" style="background-color: #4f715a; text-align: center; color: #fff;">

                        <h3 class="box-title">Detail Permintaan Diproses </h3>

                    </div>
                    <div class="box-body ">
                        <div class="box box-info" style="border-color: #4f715a !important">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detail Permintaan
                                    @if ($progress->status_tiket == 'Diproses')
                                        <small class="badge label-primary">{{ $progress->proses_name }}</small>
                                </h3>
                            @elseif ($progress->status_tiket == 'Selesai')
                                <small class="badge alert-danger">Selesai</small></h3>
                                @endif
        
        
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="">
                                <!-- test -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="fieldset-style" style="background: #f9f9f9;">
                                            <legend class="legend-style"
                                                style="width:30%;background-color:#e87c1e;color: #fff;border:none;">
                                                Informasi Umum</legend>
                                            <div class="panel panel-default"
                                                style="background: #f9f9f9;border-color: #fff !important;margin-top: -9px;">
                                                <div class="panel-body" style="padding: 0px;">
                                                    <div class="row top-22">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>No Tiket </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <b><span
                                                                                id="kode">{{ $progress->kd_tiket }}</span></b>
                                                                        <input type="hidden" id="kode3" name="kode_tiket">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>PIC & NO HP PIC</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span
                                                                            id="nm_dpn">{{ $progress->contact_person }}</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Organisasi</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span id="opd">{{ $progress->nama_opd }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
        
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Tanggal Laporan </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <!-- <input type="text" readonly class="form-control" name="" value="" id="tgl_dft"> -->
                                                                        <span
                                                                            id="tgl_dft">{{ $progress->tgl_pelaporan }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <form method="POST" action="{{ url('rating') }}"
                                                                enctype="multipart/form-data">
                                                                {!! csrf_field() !!}
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label>Rating </label>
                                                                        </div>
                                                                        @if ($progress->status_tiket == 'Close')
                                                                            <div class="col-sm-4">
                                                                                @if ($progress->survey_rate != null)
                                                                                    @for ($i = 0; $i < $progress->survey_rate; $i++)
                                                                                        <span class="fa fa-star checked"></span>
                                                                                    @endfor
                                                                                    ({{ $progress->survey_rate }} dari 5)
                                                                                @else
                                                                                    <i>Belum Ada Rating</i>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Perihal </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <input type="hidden" readonly class="form-control"
                                                                            name="judul" id="jdl3" value="">
                                                                        <span id="jdl">{{ $progress->judul }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Deskripsi User</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        {{ $progress->desk }}
                                                                    </div>
                                                                </div>
                                                            </div>
        
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Surat Dinas</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span id="nm_dpn">
                                                                            @if ($progress->file_surat_dinas != null)
                                                                                <a
                                                                                    href="{{ URL::asset('public/lampiran/'.$progress->kd_tiket.'/' . $progress->file_surat_dinas) }}">{{ $progress->file_surat_dinas }}</a>
                                                                            @endif
                                                                        </span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Lampiran</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span id="nm_dpn">
                                                                            @if ($progress->lampiran != null)
                                                                                <a
                                                                                    href="{{ URL::asset('public/lampiran/'.$progress->kd_tiket.'/' . $progress->lampiran) }}">{{ $progress->lampiran }}</a>
                                                                            @endif
                                                                        </span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
        
        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
        
                                        </fieldset>
                                        <br>
        
                                    </div>
                                    <div class="col-md-6">
        
                                        <fieldset class="fieldset-style"
                                            style="background: #f9f9f9;margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">
                                            <legend class="legend-style"
                                                style="width: 81px;background-color:#e87c1e;color: #fff;border:none;">
                                                Layanan</legend>
                                            <div class="panel panel-default"
                                                style="background: #f9f9f9;border-color: #fff !important;">
                                                <div class="panel-body" style="padding: 0px;">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Layanan </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <!-- <input type="text" readonly class="form-control" name="jns_pelayanan" id="plynn" value=""> -->
                                                                <span id="plynn">{{ $progress->plynn }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label>Agen</label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <span id="nm_dpn">{{ $progress->nama_agen }}</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($progress->status_tiket != 'Open')
                                                        @if(in_array($progress->proses_name,array('Pemberian Hasil dan BA','User membalas BA dan Survei','Penutupan Permintaan Layanan','Tiket Permintaan Ditutup')))
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label>Solusi</label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <span id="beritaAcara">
                                                                    <textarea class="form-control" disabled>{{ $solusiTask->task_report }}</textarea>
                                                                    </span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label>Berita Acara</label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <span id="beritaAcara">
                                                                        
                                                                        @foreach ($solusiTask->attachment as $attachment )
                                                                            @if ($attachment->is_ba == 1)
                                                                            <a
                                                                                href="{{ URL::asset('public/lampiran/'  . $progress->kd_tiket . '/' . $attachment->filename) }}">{{$attachment->filename }}</a>
                                                                            @endif
                                                                        @endforeach
                                                                       
                                                                    </span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label>Lampiran</label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <span id="lampiran">
                                                                        @foreach ($solusiTask->attachment as $attachment )
                                                                        @if ($attachment->is_ba == 0)
                                                                        <a
                                                                            href="{{ URL::asset('public/lampiran/'  . $progress->kd_tiket . '/' . $attachment->filename) }}">{{$attachment->filename }}</a>
                                                                        @endif
                                                                    @endforeach
                                                                    </span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(in_array($progress->proses_name,array('User membalas BA dan Survei')))
                                                            <form role="form" method="POST" action="{{ url('balasBAUser') }}" enctype="multipart/form-data">
                                                                <input type="hidden" name="pelayanan_id" value="{{$progress->id_}}">
                                                                {!! csrf_field() !!}
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <label>komentar</label>
                                                                        </div>
                                                                        <div class="col-sm-9" style="font-size: 16px;">
                                                                            <textarea name="komentar" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <label>Survey Kepuasan </label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                        <input type="hidden" name="pelayanan_id"
                                                                                value="{{ $progress->id_ }}">
                                                                            <select name="rating" id="rating" required>
                                                                                <option value="1">
                                                                                    &#11088;
                                                                                </option>
                                                                                <option value="2">&#11088;&#11088;</span>
                                                                                </option>
                                                                                <option value="3">&#11088;&#11088;&#11088;
                                                                                </option>
                                                                                <option value="4">
                                                                                    &#11088;&#11088;&#11088;&#11088;</option>
                                                                                <option value="5" selected>
                                                                                    &#11088;&#11088;&#11088;&#11088;&#11088;
                                                                                </option>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            <label>Balas Berita Acara</label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <input type="file" readonly class="form-control"
                                                                                name="file_ba">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="pull-right">
                                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            @endif
                                                            @else
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Balasan BA</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span id="beritaAcara">
                                                                            @if ($progress->ba_bls != null)
                                                                                <a
                                                                                    href="{{ URL::asset('public/lampiran/' . $progress->kd_tiket . '/'  . $progress->ba_bls) }}">{{ $progress->ba_bls }}</a>
                                                                            @endif
                                                                        </span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Survey Kepuasan </label>
                                                                    </div>
                                                                    
                                                                        <div class="col-sm-4">
                                                                            @if ($progress->survey_rate != null)
                                                                                @for ($i = 0; $i < $progress->survey_rate; $i++)
                                                                                    <span class="fa fa-star checked"></span>
                                                                                @endfor
                                                                                ({{ $progress->survey_rate }} dari 5)
                                                                            @else
                                                                                <i>Belum Ada Survey</i>
                                                                            @endif
                                                                        </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Komentar</label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <span id="beritaAcara">
                                                                        <textarea class="form-control" disabled>{{ $progress->komen_slaba }}</textarea>
                                                                        </span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </fieldset>
        
                                    </div>
                                </div>
                                {{-- Start Of Chat --}}
                                <div class="row">
                                    <form method="POST" action="{{ url('chatSupport') }}" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="col-md-6">
                                            <fieldset class="fieldset-style"
                                                style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                                <legend class="legend-style"
                                                    style="width: 65px;background-color:#e87c1e;color: #fff;border:none;">Chat
                                                </legend>
                                                <div class="panel panel-default"
                                                    style="background: #f9f9f9;border-color: #fff !important;">
                                                    <div class="panel-body" style="padding: 0px;">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label>Chat</label>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    @if (count($progress->chat_support) == 0)
        
                                                                    @else
                                                                        <div class="direct-chat-messages">
                                                                            @foreach ($progress->chat_support as $chat)
                                                                                <div class="direct-chat-msg">
                                                                                    <div class="direct-chat-infos clearfix">
                                                                                        <span
                                                                                            class="direct-chat-name float-left">{{ $chat->user->id }}
                                                                                            - {{ $chat->user->nama_depan }}
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
                                                                                                    href="{{ URL::asset('public/lampiran/' . $progress->kd_tiket . '/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
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
                                                                <label>Pesan</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input onkeyup="success()" type="text" id="chat" name="chat"
                                                                    class="form-control" @if ($progress->status_tiket == 'Selesai')
                                                                disabled
                                                                @endif>
                                                                <input type="hidden" name="pelayanan_id"
                                                                    value="{{ $progress->id_ }}">
                                                            </div>
                                                        </div>
        
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group control-group increment">
                                                            <input type="file" name="lampiran[]" class="form-control"
                                                                @if ($progress->status_tiket == 'Selesai')
                                                            disabled
                                                            @endif>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-success" type="button"><i
                                                                        class="glyphicon glyphicon-plus" @if ($progress->status_tiket == 'Selesai')
                                                                        disabled
                                                                        @endif></i>Add</button>
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
                                                                    disabled>Kirim</button>
                                                            </div>
                                                            <div class="col-sm-9">
        
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <fieldset class="fieldset-style"
                                                                    style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">
                                                                    <div class="panel panel-default"
                                                                        style="background: #f9f9f9;border-color: #fff !important;">
                                                                        <div class="panel-body" style="padding: 0px;">
                                                                            <div class="form-group">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <span
                                                                                            style="color:#3a6d99;font-weight:bold;">Lampiran
                                                                                            (Diurutkan berdasarkan Waktu
                                                                                            Upload)</span>
                                                                                    </div>
                                                                                    <div class="col-sm-12">
                                                                                        <ul>
                                                                                            @foreach ($progress->attachment as $attachment)
                                                                                                <li><a
                                                                                                        href="{{ URL::asset('public/lampiran/' . $progress->kd_tiket . '/' . $attachment->filename) }}">{{ $attachment->filename }}</a>
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
                                    </form>
                                </div>
                                {{-- End Of Chat --}}
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="row">
    {{-- <div class="col-md-6">
        <!-- The time line -->
        <ul class="timeline">
            @foreach ($progress->timelines as $timeline)
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-red">
                        {{ Common::change_date($timeline->timeline_date) }}
                    </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                @foreach ($timeline->timelineDetails as $detail)
                    <li>
                        @if ($detail->type == 'user_action')
                            <i class="fa fa-user bg-aqua"></i>
                        @elseif($detail->type == 'system_action')
                            <i class="fa fa-envelope bg-blue"></i>
                        @endif
                        <div class="timeline-item">
                            <span class="time"><i
                                    class="fa fa-clock-o"></i>{{ Common::get_time_ago($detail->created_at) }}</span>

                            <div class="timeline-body">
                                User id {{ $detail->user->id }} Melakukan {{ $detail->description }}
                            </div>

                        </div>
                    </li>
                @endforeach
                <!-- END timeline item -->
            @endforeach

            <li>
                <i class="fa fa-clock-o bg-gray"></i>
            </li>
        </ul>
    </div> --}}
    <div class="col-md-6">
        <!-- The time line -->
        <h1>Detail Progress</h1>
        <ul class="timeline">
            @foreach ($flow_pelayanan as $flow)
                <!-- timeline time label -->
                {{-- @if ($progress->file_surat_dinas != null)
                    @if($flow->name=='Validasi Permintaan Layanan')
                        @continue                        
                    @endif
                @endif --}}
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
{{-- Timeline --}}
                </div>
            </div>


            
        </div>
    </div>
</div>

</div>




@endsection
