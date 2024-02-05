@section('user-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Pengguna
@endsection

@section('contentheader_title')
Pengguna
@endsection

@section('additional_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('.js-example-basic-single').select2();

	   
	});
	
	function teamCheck(that) {
	    if (that.value == "3") {
	        document.getElementById("selectTeam").style.display = "block";
	    } else {
	        document.getElementById("selectTeam").style.display = "none";
	    }
	}
</script>
@endsection

@section('main-content')
 <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Tambah Baru</h3>

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
		       <form role="form" method="POST" action="{{route('user.store')}}">
		       {!! csrf_field() !!}
		       	<!-- <nav style="margin-top:10px;">
					  <div class="nav nav-tabs" id="nav-tab" role="tablist">
					    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><span class="label label-success label-custom">Data Diri</span></a>
					    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><span class="label label-success label-custom">User Login</span></a>
					  </div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
				  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">A</div>
				  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">B</div>
				</div> -->
				
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<span class="label label-success label-custom">Data Diri</span>
						</div>
						<div class="form-group">
							<label>Nama Depan <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_depan" placeholder="Fulan" required>
						</div>
						<div class="form-group">
							<label>Nama Belakang</label>
							<input type="text" class="form-control" name="nama_belakang" placeholder="Bin Fulan">
						</div>
						<div class="form-group">
							<label>Jabatan</label> <br>
		                  	<select id="id_jabatan" name="id_jabatan" class="form-control js-example-basic-single">

		                  	  <option value="">- Pilih Jabatan -</option>
		                  	  @foreach($jabatan as $datajab)
							  	<option value='{{$datajab->id_jabatan}}'>{{$datajab->jabatan}}</option>
							  @endforeach
							 </select>
						</div>
						<div class="form-group">
							<label>Kewenangan <a class="text-red">*</a></label> <br>
		                  	<select id="role_user" onchange="teamCheck(this);" name="role_user" class="form-control" required>
		                  	  <option value="">- Pilih Kewenangan -</option>
					  		  @foreach($roles as $role)
							  <option value='{{$role->display_name}}'>{{$role->name}}</option>
							  @endforeach  
							 </select>
						</div>
						{{-- <div class="form-group">
							<label>Team <br>
		                  	<select name="id_team" class="form-control">
		                  	  <option value="">- Pilih Team -</option>
					  		  @foreach($team as $datateam)
							  	<option value='{{$datateam->id_team}}'>{{$datateam->name_team}}</option>
							  @endforeach
							 </select>
						</div> --}}
						<div class="form-group">
							<label>Organisasi <a class="text-red">*</a> <br>
		                  	<select name="id_organisasi" class="form-control js-example-basic-single" required>
		                  	  <option value="">- Pilih Organisasi -</option>
					  		  @foreach($org as $dataorg)
							  	<option value='{{$dataorg->id_organisasi}}'>{{$dataorg->nama_opd}}</option>
							  @endforeach
							 </select>
						</div>						
						{{-- <div class="form-group">
							<label>Golongan <a class="text-red">*</a> <br>
		                  	<select name="golongan_id" class="form-control" required>
		                  	  <option value="">- Pilih -</option>
					  		  @foreach($golongan as $golongan)
							  	<option value='{{$golongan->id}}'>{{$golongan->name}}</option>
							  @endforeach
							 </select>
						</div>	 --}}
						<!-- <div class="form-group">
							<label>Photo</label> <br>
		                  	<input type="file" name="photo">
						</div> -->
						{{-- <div class="form-group">
							  <label>Notifikasi E-mail <a class="text-red">*</a></label> <br>
							  <input type="radio" name="notifikasi" value="Ya"> Ya<br>
							  <input type="radio" name="notifikasi" value="Tidak"> Tidak<br>
						</div> --}}

					</div>
					<div class="col-md-4">
						<div class="form-group">
							<span class="label label-success label-custom">User Login</span>
						</div>
						
							
							<div class="form-group">
								<label>Username</label>
								<input type="text" class="form-control" name="name" placeholder="username">
							</div>
							<div class="form-group">
								<label>Email </label>
								<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
							</div>
							<div class="form-group">
								<label>No HP</label>
								<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ old('phone') }}">
							</div>

							<div class="form-group">
								<label>Kata Sandi </label>
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
							<div class="form-group">
							<label>Status <a class="text-red">*</a></label> <br>
		                  	<select id="status" name="status" class="form-control" required>
		                  	  <option value="">- Pilih Status -</option>
					  		  <option value="Aktif">Aktif</option>
					  		  <option value="Tidak Aktif">Tidak Aktif</option>
							 </select>
					</div>
					</div>
				</div>
				<hr class="border-hr">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
						<a href="{{url()->previous()}}" class="btn btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
