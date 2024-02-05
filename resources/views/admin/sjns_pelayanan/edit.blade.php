@section('sjns_pelayanan-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Edit Sub Jenis Pelayanan
@endsection

@section('contentheader_title')
Edit Sub Jenis Pelayanan
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
 
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Ubah Pelayanan</h3>
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
				<form role="form" method="POST" action="{{route('sjns_pelayanan.update', $sjns->id_sjns_pelayanan)}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT') }}
                <div class="row top-22">
					<div class="col-md-12">
						<div class="form-group">
							<label>Pelayanan</label>
							<select class="form-control js-example-basic-single" name="id_pelayanan">
							   <option value="">- Pilih Jenis Pelayanan -</option>
							   @foreach($jns_pelayanan as $dataPelayanan)
				                @if ($dataPelayanan->id_pelayanan == $sjns->id_pelayanan )
									<option value='{{ $dataPelayanan->id_pelayanan }}' selected>{{ $dataPelayanan->pelayanan }}</option>
								@else
									<option value="{{$dataPelayanan->id_pelayanan}}">{{$dataPelayanan->pelayanan}}</option>
								@endif
				               @endforeach
	                        </select>

						</div>
						<div class="form-group">
							<label>Jenis Pelayanan</label>
							<input type="text" class="form-control" name="jenis_pelayanan" value="{{$sjns->jenis_pelayanan}}">

						</div>
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
