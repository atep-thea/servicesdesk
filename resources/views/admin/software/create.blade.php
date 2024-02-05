@section('server-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Input Software							
@endsection

@section('contentheader_title')
Input Software
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
				<h3 class="box-title">Formulir Tambah Software</h3>
			</div>
			<div class="box-body border-box">
				
		        <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
		        <form role="form" method="POST" action="{{route('perangkat-lunak.store')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="row top-22">
					<div class="col-md-8">
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
							<label>Software <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="software" value="{{ old('software') }}" required>
						</div>
						<div class="form-group">
							<label>Lisensi </label>
							<input type="text" class="form-control" name="lisensi" value="{{ old('lisensi') }}">
						</div>
						<div class="form-group">
							<label>Kadaluarsa</label>
							<input type="text" class="form-control datepicker dateStart" name="kadaluarsa" value="{{ old('kadaluarsa') }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tanggal Pembelian</label>
							<input type="text" class="form-control datepicker dateStart" name="tgl_pembelian" value="{{ old('tgl_pembelian') }}">
						</div>
						<div class="form-group">
	                        <label>Keterangan </label>
	                        <textarea name="keterangan" class="form-control"></textarea>
	                    </div>
						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" name="status" value="{{ old('status') }}">
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
