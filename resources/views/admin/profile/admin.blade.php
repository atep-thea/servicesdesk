@section('ganti-profile')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Ubah Profil
@endsection

@section('contentheader_title')
Ubah Profil
@endsection

@section('additional_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
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

 $('#domicile').autocomplete({
                  serviceUrl: '{{url('api/cari-kota-public')}}',
                  showNoSuggestionNotice: true,
                  noSuggestionNotice: 'Mohon maaf, kota tidak tersedia'
                });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Ubah Profil Admin</h3>

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
					<p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
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
							<label>Email <a class="text-red">*</a></label>
							<input type="email" class="form-control" name="email" placeholder="Username" value="{{ old('email') ? old('email') : $user->email }}" required>
						</div>
						<div class="form-group">
							<label>No. Telepon <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="phone" placeholder="Name" value="{{ old('phone') ? old('phone') : $user->phone }}" required>
						</div>
						<div class="form-group">
							<label>Kata Sandi <a class="text-red">*</a></label>
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>


				</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<button type="submit" class="btn btn-primary pull-right">Simpan</button>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
