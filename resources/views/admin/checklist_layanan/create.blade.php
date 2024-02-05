@section('server-link')class="active" @stop

@extends('layout.adminlte.app')



@section('htmlheader_title')

Checklist Layanan					

@endsection



@section('contentheader_title')

Checklist Layanan

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

				<h3 class="box-title">Formulir Tambah Checklist Layanan</h3>

			</div>

			<div class="box-body border-box">

				

		        <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>

		        <form role="form" method="POST" action="{{route('checklist.store')}}" enctype="multipart/form-data">

					{!! csrf_field() !!}

				<div class="row top-22">

					<div class="col-md-8">

						<div class="form-group">

							<label>Jenis Pelayanan <a class="text-red">*</a></label>

							<select name="id_jns_pelayanan" class="form-control js-example-basic-single" required>

		                  	  <option value="">- Pilih Jenis Pelayanan -</option>

					  		  @foreach($layanan as $orgData)

							  <option value='{{$orgData->id}}'>{{$orgData->pelayanan}}</option>

							  @endforeach  

							 </select>

						</div>

						<div class="form-group">

							<label>Nama Checklist <a class="text-red">*</a></label>

							<input type="text" class="form-control" name="checklist_name" value="{{ old('checklist_name') }}" required>

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

