@section('request_done-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
    Input Pelayanan
@endsection

@section('contentheader_title')
    Input Pelayanan
@endsection

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/adminlte/css/select22.min.css') }}" rel="stylesheet" />
@endsection

@section('additional_scripts')
    <script src="{{ asset('public/adminlte/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{ asset('public/js/select_dependent.js') }}"></script>
    <script src="{{ asset('public/js/select_team.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#warning-modal').modal('show');
        });
        function validateSize(input) {
	  const fileSize = input.files[0].size / 1024 / 1024; // in MiB
	  if (fileSize > 8) {
		alert('File yang anda upload lebih dari 8 MB');
		// $(file).val(''); //for clearing with Jquery
	  }
	}
	
	$(document).on('submit', '#form', function(event){
		var surat_dinas = document.getElementById("surat_dinas");
		  var lampiran = document.getElementById('lampiran');
	
		  let surat_dinas_file = surat_dinas.files[0].size; 
		  let lampiran_file = lampiran.files[0].size;
		  
		  if (surat_dinas_file > 8000000) {
			  alert("Ukuran File Surat Dinas Lebih dari 8 MB");
			  event.preventDefault();
		  }
	
		  if (lampiran_file > 8000000) {
			  alert("Ukuran File Lampiran Lebih dari 8 MB");
			  event.preventDefault();
		  }
		});
    </script>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="box-header bg-title-form">
                    <h3 class="box-title">Formulir Tiket Baru</h3>
                </div>
                <div class="box-body border-box">
                    @if (Session::has('warning'))
                        <div class="modal fade" id="warning-modal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" style="margin-left: 25%;margin-top: 20%;border-radius: 8px">
                                    <button data-remodal-action="close" class="remodal-close"></button>
                                    <div class="modal-body" style="text-align: center;padding-top:30px;">
                                        <div class="row">
                                            <p style="margin-bottom: 21px;">
                                                <image style="width: 30%" src="{{ asset('public/images/warningg.gif') }}">
                                                </image>
                                            </p>
                                            <h2 class="success-alert">
                                                Warning!!
                                            </h2>
                                            <div class="session-alert">
                                                {{ Session::get('warning') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="text-align: center">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            style="padding: 9px;width: 95px;font-size: 1.0625em;">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form id="form" role="form" method="POST" action="{{ route('pelayanan.store') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-12">
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
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Layanan *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <select class="form-control js-example-basic-single" required
                                                                    name="jns_pelayanan">
                                                                    <option value=""> Pilih Layanan </option>
                                                                    @foreach ($JnsPlynn as $plyn)
                                                                        <option value='{{ $plyn->id_pelayanan }}'>
                                                                            {{ $plyn->pelayanan }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>User Yang Bersangkutan <a
                                                                class="text-red">*</a></label>
                                                        <select class="form-control js-example-basic-single"
                                                            style="width: 100% !important;" name="id_pelapor" required>
                                                            <option value="">- Pilih User -</option>
                                                            @foreach ($user_requester as $user_requester)
                                                                <option value='{{ $user_requester->id }}'>
                                                                    {{ $user_requester->id }} -
                                                                    {{ $user_requester->nama_depan }}
                                                                    {{ $user_requester->nama_belakang }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Perihal</label>
                                                        <input type="text" class="form-control" name="judul"
                                                            value="" required>
                                                    </div>
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>PIC & NO HP PIC</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control"
                                                                    name="contact_person" required>
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi</label>
                                                        <textarea style="height: 220px;" class="form-control"
                                                            name="deskripsi" required></textarea>
                                                    </div>
                                                    <div class="form-group" style="margin-bottom:10px;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label>Surat Dinas </label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input
                                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*, pdf, .doc, .docx, .xls" onchange="validateSize(this)" 
                                                                    style="background: #f9f9f9;padding: 20px;width: 100%;"
                                                                    type="file" name="surat_dinas"><span
                                                                    style="color:#dd4b39;font-size:11px;">(Maximum File
                                                                    size: 8 MB)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Lampiran</label>
                                                        <input   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*, pdf, .doc, .docx, .xls" onchange="validateSize(this)"  class="form-control" type="file" name="lampiran">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                        <hr class="border-hr">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
