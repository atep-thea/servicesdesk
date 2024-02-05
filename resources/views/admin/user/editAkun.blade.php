@section('user-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Pengguna
@endsection

@section('contentheader_title')
Pengguna
@endsection

@section('additional_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-6">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Ubah Akun Pengguna</h3>
			</div>
			<div class="box-body border-box">
				<form method="POST" action="{{url('update_akun')}}" enctype="multipart/form-data">
    			{!! csrf_field() !!}
    			<input type="hidden" value="{{$user->id}}" name="id_user">
				<div class="form-group">
						<span class="label label-success label-custom">User Login</span>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="username">
					</div>
					<div class="form-group">
						<label>Email </label>
						<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label>No HP</label>
						<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ $user->phone }}">
					</div>

					<div class="form-group">
						<label>Kata Sandi </label>
						<input type="text" class="form-control" name="password" value="{{$user->decrypt_pass}}">
					</div>
					<div class="form-group">
						<label>Status <a class="text-red">*</a></label> <br>
	                  	<select id="status" name="status" class="form-control" required>
	                  	  <option value="">- Pilih Status -</option>

	                  	  @if($user->status != 'Aktif')
					  		<option value="Aktif">Aktif</option>
					  		<option value="Tidak Aktif" selected>Tidak Aktif</option>
					  	  @else
					  	  	<option value="Aktif" selected>Aktif</option>
					  		<option value="Tidak Aktif">Tidak Aktif</option>
					  	  @endif
						 </select>

					</div>
					<div class="form-group">
						  <label>Notifikasi E-mail <a class="text-red">*</a></label> <br>
						  @if($user->notifikasi != 'Ya')
						  		<input type="radio" name="notifikasi" value="Ya"> Ya<br>
						  		<input type="radio" name="notifikasi" value="Tidak" checked> Tidak<br>
						  @else
							  <input type="radio" name="notifikasi" value="Ya" checked> Ya<br>
							  <input type="radio" name="notifikasi" value="Tidak"> Tidak<br>
						  @endif

					</div>
					<br>
					<div class="rows">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Save</button>&nbsp;
							<a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
			</div>	

			</form>
	</div>
</div>
@endsection
