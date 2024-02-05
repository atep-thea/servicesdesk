@section('server-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Update Hardware
@endsection

@section('contentheader_title')
Update Hardware
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
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

    $(".dateStart").daterangepicker({
    	"locale" : {
    		"format" : 'YYYY-MM-DD',
    		"daysOfWeek": [
				            "Mg",
				            "Sn",
				            "Sl",
				            "Rb",
				            "Km",
				            "Jm",
				            "Sb"
				        ],
			"monthNames": [
				            "Januari",
				            "Februari",
				            "Maret",
				            "April",
				            "Mei",
				            "Juni",
				            "Juli",
				            "Agustus",
				            "September",
				            "Oktober",
				            "November",
				            "Desember"
				        ],
			"firstDay": 1
    	},
    	"startDate": moment(),
    	"singleDatePicker" : true
    });
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Update Hardware</h3>
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
		        <form role="form" method="POST" action="{{route('perangkat-keras.update',$hardware->id_perangkat)}}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}                        
				<div class="row top-22">
					<div class="col-md-8">
						<div class="form-group">
							<label>Jenis Perangkat Keras</label>
							

							 <select class="form-control" name="id_jns_perangkat">
							   <option value="">- Pilih Perangkat Keras -</option>
							   @foreach($jnsPerangkat as $jnsPerangkatData)
				                @if ($jnsPerangkatData->id_jns_perangkat == $hardware->jns_perangkat )
									<option value='{{ $jnsPerangkatData->id_jns_perangkat }}' selected>{{ $jnsPerangkatData->nama_jns_perangkat }}</option>
								@else
									<option value="{{$jnsPerangkatData->id_jns_perangkat}}">{{$jnsPerangkatData->nama_jns_perangkat}}</option>
								@endif
				               @endforeach
	                        </select>
						</div>
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $hardware->nama_perangkat}}" required>
						</div>
						<div class="form-group">
							<label>Merek </label>
							<input type="text" class="form-control" name="merek" value="{{ $hardware->merek}}" placeholder="merek">
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ $hardware->model}}" placeholder="model">
						</div>
						<div class="form-group">
							<label>Perangkat Daerah</label>
							 <select class="form-control js-example-basic-single" name="id_organisasi">
							   <option value="">- Pilih Organisasi -</option>
							   @foreach($org as $orgdata)
				                @if ($orgdata->id_organisasi == $hardware->id_organisasi )
									<option value='{{ $orgdata->id_organisasi }}' selected>{{ $orgdata->nama_opd }}</option>
								@else
									<option value="{{$orgdata->id_organisasi}}">{{$orgdata->nama_opd}}</option>
								@endif
				               @endforeach
	                        </select>
						</div>
	                    <div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ $hardware->phone}}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tanggal Pembelian</label>
							<input type="text" class="form-control datepicker dateStart" name="tgl_pembelian" value="{{ $hardware->tgl_pembelian}}">
						</div>
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="aset_number" value="{{ $hardware->aset_number}}" placeholder="aset nomer">
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="serial_number" value="{{ $hardware->serial_number}}" placeholder="serial number">
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="id_status">
	                            <option value="">- Pilih Status -</option>
	                        	 @foreach($status as $statusData)
					                @if($statusData->id_status == $hardware->status )
										<option value='{{ $statusData->id_status }}' selected>{{ $statusData->status_name }}</option>
									@else
										<option value="{{$statusData->id_status}}">{{$statusData->status_name}}</option>
									@endif
				               	 @endforeach
	                        </select>
	                    </div>	
						<div class="form-group">
	                        <label>Keterangan </label>
	                        <textarea name="deskripsi" class="form-control">{{$hardware->deskripsi}}</textarea>
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
