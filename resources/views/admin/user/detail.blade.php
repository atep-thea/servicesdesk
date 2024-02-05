@section('organisasi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
User Data
@endsection

@section('contentheader_title')
User Data
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
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Data Detail User</h3>
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
			<div class="rows">
				<div class="col-md-8">
					<form role="form" method="POST" action="{{route('user.update', $user->id)}}">
						{!! csrf_field() !!}
                        {{ method_field('PUT') }}
                        <div class="form-group">
							<span class="label label-success label-custom">Data Diri</span>
						</div>
						<div class="form-group">
							<label>Nama Depan <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_depan" placeholder="Fulan" value="{{$user->nama_depan}}" readonly required>
						</div>
						<div class="form-group">
							<label>Nama Belakang</label>
							<input type="text" class="form-control" name="nama_belakang" value="{{$user->nama_belakang}}" readonly placeholder="Bin Fulan">
						</div>
						<div class="form-group">
							<label>Kewenangan <a class="text-red">*</a></label> <br>
		                  	<input type="text" class="form-control" name="" value="{{$user->role_user}}" readonly placeholder="Bin Fulan">
						</div>
						<div class="form-group">
							<label>Jabatan <a class="text-red">*</a></label> <br>
		                  	<input type="text" class="form-control" name="" value="{{$user->jabatan}}" readonly placeholder="Bin Fulan">
						</div>
						<div class="form-group">
							<label>Organisasi</label>
							<input type="text" class="form-control" name="" value="{{$user->opd}}" readonly placeholder="Bin Fulan">

						</div>

						@if(Auth::user()->role_user == 'Helpdesk')
						<div class="form-group">
							<label>Team</label>
							<input type="text" class="form-control" name="" value="{{$user->name_team}}" readonly>

						</div>
						@endif
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<span class="label label-success label-custom">User Login</span>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="name" value="{{ $user->name }}" readonly placeholder="username">
					</div>
					<div class="form-group">
						<label>Email </label>
						<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ $user->email }}" readonly>
					</div>
					<div class="form-group">
						<label>No HP</label>
						<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ $user->phone }}" readonly>
					</div>
					<div class="form-group">
						<label>Status <a class="text-red">*</a></label> <br>
	                  	<input type="text" class="form-control" name="status" value="{{$user->status}}" readonly>

					</div>
					<div class="form-group">
							  <label>Notifikasi E-mail <a class="text-red">*</a></label> <br>
							  <input type="text" class="form-control" name="" value="{{$user->notifikasi}}" readonly>

					</div>
				</div>
				
			</div>
			
			<div class="rows" style="margin-left: 0px;">
				<hr>
				<div class="col-md-12">
					<a href="{{url()->previous()}}" class="btn btn-danger">Kembali</a>
				</div>
			</div>

			</div>
			</form>
			</div>
		</div>
	</div>
</div>
@endsection
