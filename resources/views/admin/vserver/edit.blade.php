@section('server-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Edit Virtual Server
@endsection

@section('contentheader_title')
Edit Virtual Server
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>
<script src="https:/cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src='{{asset('public/plugins/tinymce/tinymce.min.js')}}'></script>
<script type="text/javascript">
	/*
	Pengecekan slideshow
	 */
	$('#yes').on('change', function() {
    if($(this).is(":checked")){
    	$('#slideshow_form').show();
    	document.getElementById("slideshow_file").required = true;
    }
  });
  $('#no').on('change', function() {
    if($(this).is(":checked")){
    	$('#slideshow_form').hide();
    	document.getElementById("slideshow_file").required = false;
    }
  });
  /*
  texeditor
   */
  $(function () {
    $(".textarea").wysihtml5();
  });
  /*
  Image preview
   */
  function readURL(input,preview) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#' + preview)
          .attr('src', e.target.result)
          .height(150);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Ubah Server</h3>
			</div>
			<div class="box-body border-box">
				@if($errors)
		        @foreach ($errors->all() as $message)
		        <div class="alert alert-danger alert-dismissable">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		          <i class="icon fa fa-warning"></i>
		          {{ $message }}
		        </div>
		        @endforeach
		        @endif
		        <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
				<form role="form" method="POST" action="{{route('vserver.update', $server->id_server)}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT') }}
                <div class="row top-22">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $server->nama_perangkat }}" required>
						</div>
						<div class="form-group">
							<label>Merek <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="merek" value="{{ $server->merek }}">
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ $server->model }}">
						</div>
						<div class="form-group">
							<label>IP Manajemen</label>
							<input type="text" class="form-control" name="ip_manajemen" value="{{ $server->ip_manajemen }}">
						</div>
						<div class="form-group">
							<label>Nomer Rak</label>
							<input type="text" class="form-control" name="no_rak" value="{{ $server->no_rak }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="nomer_aset" value="{{ $server->nomer_aset }}">
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="nomer_serial" value="{{ $server->nomer_serial }}">
						</div>
						<div class="form-group">
							<label>Lisensi</label>
							<input type="text" class="form-control" name="lisensi" value="{{ $server->lisensi }}">
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="status">
	                            <option value="">- Pilih Status -</option>
	                            @if($server->status == 'Aktif')
                            		<option value='Aktif' selected>Aktif</option>
                            		<option value="Non Aktif">Non Aktif</option>
                            	@else
                            		<option value='Non Aktif' selected>Non Aktif</option>
                            		<option value="Aktif">Aktif</option>
		                        @endif
	                        </select>
	                    </div>
					</div>
			    </div>
				<hr class="border-hr">
				<div class="row">
					<div class="col-md-12">
						
						<button type="submit" class="btn btn-primary">Save</button>&nbsp;
						<a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
					</div>
				</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
