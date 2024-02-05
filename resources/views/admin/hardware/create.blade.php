@section('server-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Input Hardware
@endsection

@section('contentheader_title')
Input Hardware
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
				<h3 class="box-title">Formulir Tambah Hardware</h3>
			</div>
			<div class="box-body border-box">
				
		        <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
		        <form role="form" method="POST" action="{{route('perangkat-keras.store')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="row top-22">
					<div class="col-md-8">
						<div class="form-group">
							<label>Jenis Perangkat Keras</label>
							<select name="id_jns_perangkat" class="form-control js-example-basic-single" required>
		                  	  <option value="">- Pilih Perangkat Keras -</option>
					  		  @foreach($jnsPerangkat as $jnsPerangkatData)
							  <option value='{{$jnsPerangkatData->id_jns_perangkat}}'>{{$jnsPerangkatData->nama_jns_perangkat}}</option>
							  @endforeach  
							 </select>
						</div>
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ old('nama_perangkat') }}" required>
						</div>
						<div class="form-group">
							<label>Merek </label>
							<input type="text" class="form-control" name="merek" value="{{ old('merek') }}">
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ old('model') }}">
						</div>
						<div class="form-group">
							<label>Perangkat Daerah <a class="text-red">*</a></label>
							<select name="id_organisasi" class="form-control js-example-basic-single" required>
		                  	  <option value="">- Pilih Perangkat Daerah -</option>
					  		  @foreach($org as $orgData)
							  <option value='{{$orgData->id_organisasi}}'>{{$orgData->nama_opd}}</option>
							  @endforeach  
							 </select>
						</div>
	                    <div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ old('phone') }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tanggal Pembelian</label>
							<input type="text" class="form-control datepicker dateStart" name="tgl_pembelian" value="{{ old('tgl_pembelian') }}">
						</div>
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="aset_number" value="{{ old('aset_number') }}">
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="serial_number" value="{{ old('serial_number') }}">
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="status">
	                          <option value="">- Pilih Status -</option>
					  		  @foreach($status as $statusData)
							  <option value='{{$statusData->status_name}}'>{{$statusData->status_name}}</option>
							  @endforeach 
	                        </select>
	                    </div>	
						<div class="form-group">
	                        <label>Keterangan </label>
	                        <textarea name="deskripsi" class="form-control"></textarea>
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
