@section('router-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Edit router
@endsection

@section('contentheader_title')
Edit router
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
	TinyMCE
	 */
	tinymce.init({
    selector: '#mytextarea',
    plugins: "image imagetools",
    file_browser_callback_types: 'file image media',
    images_upload_url: 'postAcceptor.php',
	  images_upload_base_path: '/some/basepath',
	  images_upload_credentials: true
  });
  
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
 
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Ubah router</h3>
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
				<form role="form" method="POST" action="{{route('router.update', $router->id_server)}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT') }}
                <div class="row top-22">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $router->nama_perangkat }}" required>
						</div>
						<div class="form-group">
							<label>Merek <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="merek" value="{{ $router->merek }}">
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ $router->model }}">
						</div>
						<div class="form-group">
							<label>IP Manajemen</label>
							<input type="text" class="form-control" name="ip_manajemen" value="{{ $router->ip_manajemen }}">
						</div>
						<div class="form-group">
							<label>Nomer router</label>
							<input type="text" class="form-control" name="no_router" value="{{ $router->no_router }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="nomer_aset" value="{{ $router->nomer_aset }}">
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="nomer_serial" value="{{ $router->nomer_serial }}">
						</div>
						<div class="form-group">
							<label>Lisensi</label>
							<input type="text" class="form-control" name="lisensi" value="{{ $router->lisensi }}">
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="status">
	                            <option value="">- Pilih Status -</option>
	                            @if($router->status == 'Aktif')
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
