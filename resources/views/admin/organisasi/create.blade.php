@section('organisasi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Input Organisasi
@endsection

@section('contentheader_title')
Input Organisasi
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
				<h3 class="box-title">Formulir Tambah Organisasi</h3>
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
		        <form role="form" method="POST" action="{{route('organisasi.store')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="row top-22">
					<div class="col-md-12">
						<div class="form-group">
							<label>Nama Perangkat Daerah <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_opd" value="{{ old('nama_opd') }}" required>
						</div>
						<div class="form-group">
							<label>Induk Perangkat Daerah</label>
							<select class="form-control js-example-basic-single" name="induk_organisasi">
							   <option value="">- Pilih Induk Organisasi -</option>
							   @foreach($parent_org as $dataparent)
				                <option value="{{$dataparent->nama_opd}}">{{$dataparent->nama_opd}}</option>
				               @endforeach
	                        </select>

						</div>
						<div class="form-group">
							<label>Nama Pengelola</label>
							<input type="text" class="form-control" name="nama_pengelola" value="{{ old('nama_pengelola') }}">
						</div>
	                    <div class="form-group">
	                        <label>Nomer HP Pengelola</label>
	                        <input type="text" maxlength="13" class="form-control" name="no_hp_pengelola" value="{{ old('no_hp_pengelola') }}" placeholder="max 13 angka">
	                    </div>
						<div class="form-group">
							<label>Email <a class="text-red">*</a></label>
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="status">
	                            <option value="">- Pilih Status -</option>
	                            <option value="Aktif">Aktif</option>
	                            <option value="Non Aktif">Non Aktif</option>
	                        </select>
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
