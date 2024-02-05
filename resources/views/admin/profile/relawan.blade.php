@section('ganti-profile')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Ubah Profil
@endsection

@section('contentheader_title')
Ubah Profil
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />
<style type="text/css">
.autocomplete-suggestion {
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.1);
  border-style: solid;

  
}	
</style>
@endsection

@section('additional_scripts')
<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('public/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('public/js/autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<script type="text/javascript">
 function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
  // Tinymce
  tinymce.init({
  	fullpage_default_font_family: "'Times New Roman', Georgia, Serif;",
		relative_urls : false,
		document_base_url : "/",
		mode : "specific_textareas",
		editor_selector:'tinymce',
		height: 400,
		plugins: [
		  "advlist autolink autosave link image jbimages lists charmap print preview hr anchor pagebreak spellchecker",
		  "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		  "save table contextmenu directionality template paste textcolor"
		],
		paste_data_images: true,
    toolbar: "insertfile jbimages undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | preview fullpage",
    autosave_interval: "60s",
    autosave_retention: "10080m"
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
  /*
  texeditor
   */
  $(function () {
    $(".textarea").wysihtml5();
  });
  
  /*
  Select 2 Kota
   */
  $(".select2Kota").select2({
  	id: function(data){ return data.text; },
    ajax: {
      dataType: 'json',
      url: "{{url('api/cari-kota')}}",
      delay: 400,
      data: function(params) {
        return {
          query: params.term
        }
      },
      processResults: function (data, page) {
        return {
          results: data
        };
      },
    }
  });
  /*
  Select 2 Kategori
   */
  $(".select2Kategori").select2({
    ajax: {
      dataType: 'json',
      url: "{{url('api/categories')}}",
      delay: 400,
      data: function(params) {
        return {
          query: params.term
        }
      },
      processResults: function (data, page) {
        return {
          results: data
        };
      },
    },
    tags: true
  });
  /*
  Datepicker
   */
  $(function() {
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

    $(".dateEnd").daterangepicker({
    	"locale" : {
    		"format" : 'D MMMM YYYY',
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
    	"startDate": moment().add(1,'month'),
    	"singleDatePicker" : true
    });

    $('#amount').on('keyup', function() {
	    var donasi = $(this).val().replace(/\./g, ',');
	    if (donasi != ""){
	      var donasi_string = numeral(donasi);
	      var number = numeral(donasi_string);
	      var donasi_number = number.format('0,0').replace(/,/g, '.');
	      $(this).val(donasi_number);
	    }
	  });

    $('#name').on('keyup', function() {
        var name = $(this).val();
        var slug = $('#name').val().toLowerCase().replace(/ /g,'');
        $('#slug').val(slug);
        $('#url').html("{{ route('campaign.index') }}/"+slug);
    });

    $('#slug').on('keyup', function() {
        var slug = $(this).val().toLowerCase().replace(' ', '');
        $(this).val(slug);
        $('#url').html("{{ route('campaign.index') }}/"+slug);
    });
});
$('#domicile').autocomplete({
                  serviceUrl: '{{url('api/cari-kota-public')}}',
                  showNoSuggestionNotice: true,
                  noSuggestionNotice: 'Mohon maaf, kota tidak tersedia'
                });
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-9 col-md-offset-2">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Ubah Profil Relawan</h3>

			</div>

			<div class="box-body">
				@if($errors)
		        @foreach ($errors->all() as $message)
		        <div class="alert alert-danger alert-dismissable">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		          <i class="icon fa fa-warning"></i>
		          {{ $message }}
		        </div>
		        @endforeach
		        @endif
				<div class="rows">
				<div class="col-md-9">
					<h3><p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p></h3><br>
					<form role="form" method="POST" action="{{route('change-profile.update', $user->id)}}" enctype="multipart/form-data">
						{!! csrf_field() !!}
                        {{ method_field('PUT') }}

                        <div class="form-group">
		                  <label>Avatar (size 350px X 350px) <a class="text-red"></a></label>
		                  <br>
		                  <?php
		                  $profil_pic = $user->profpic_url;
		                  if (substr($profil_pic,0,5)!='https')
		                  {
		                      $profil_pic = 'photos/profile/'.$profil_pic;
		                  }

		                  ?>
		                  @if($user->is_silhouette)
		                  <img id="blah" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" alt="your image" height="350px" width="350px" name="blah" />
		                  @else
		                      <img src="{{asset($profil_pic)}}" id="blah" name="blah" alt="your image" height="350px" width="350px">
		                  @endif
		                  <br><br>
		                  <input type='file' id="imgInp" name="pic" />
		                </div>
						<div class="form-group">
							<label>Nama <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') ? old('name') : $user->name }}" required>
						</div>
						<div class="form-group">
							<label>Kata Sandi</label>
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>
						<div class="form-group">
							<label>TTL <a class="text-red">*</a></label>
							<br>
							<input type="text" class="form-control" name="tempat" placeholder="Tempat Lahir" value="{{ old('tempat') ? old('tempat') : $user->place_of_birth }}" required> &nbsp;&nbsp;<input type="text" class="dateStart form-control" placeholder="Tanggal Lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
						</div>
						<div class="form-group">
							<label>Kota <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="domicile" placeholder="Kota" id="domicile" value="{{ old('domicile') ? old('domicile') : $user->domicile }}" required>
						</div>
						<div class="form-group">
							<label>Alamat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="address" placeholder="Alamat" value="{{ old('address') ? old('address') : $user->address }}" required>
						</div>
						<div class="form-group">
							<label>Email <a class="text-red">*</a></label>
							<input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') ? old('email') : $user->email }}">
						</div>
						<div class="form-group">
							<label>No. HP <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ old('phone') ? old('phone') : $user->phone }}" required>
						</div>
						<div class="form-group">
						<label>Tipe Pengiklan <a class="text-red">*</a></label>
						<select name="type_pengiklan" class="form-control" required>
							<option value="">-- Silahkan pilih tipe pengiklan --</option>
		          			@if($user->advertiser_type =='perorangan')
		          			<option value="perorangan" selected>Perorangan</option>
		          			<option value="yayasan">Yayasan</option>
			          		@else
			          			<option value="perorangan">Perorangan</option>
			          			<option value="yayasan" selected>Yayasan</option>
			          		@endif
		        		</select>
						</div>
						<div class="form-group">
							<label>No. KTP/Legalitas Yayasan <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="ktp_siup" placeholder="KTP / Legalitas yayasan" value="{{ old('ktp_siup') ? old('ktp_siup') : $user->ktp_siup }}" required>
						</div>
						<div class="form-group">
						<label>Upload KTP/Legalitas Yayasan (format image ex : .png, .jpg) <a class="text-red">*</a></label>
						<input type='file' id="legalitas" name="legalitas" />
		        		</select>
						</div>
				</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-9">
						<br>
						<button type="submit" class="btn btn-primary pull-right">Simpan</button>
					</form>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>


@endsection
