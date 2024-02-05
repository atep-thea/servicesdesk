@section('organisasi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Organisasi
@endsection

@section('contentheader_title')
Organisasi
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
				<h3 class="box-title">Data Detail Organisasi</h3>
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
		       <form role="form" method="POST" action="#" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT')}}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Perangkat Daerah</label>
							<input type="text" class="form-control" value="{{ $organisasi->nama_opd }}" readonly>
						</div>
						<div class="form-group">
							<label>Induk Perangkat Daerah</label>
							<input type="text" class="form-control" value="{{ $organisasi->induk_organisasi }}" readonly>

						</div>
						<div class="form-group">
							<label>Nama Pengelola</label>
							<input type="text" class="form-control" value="{{ $organisasi->nama_pengelola }}" readonly>
						</div>
	                </div>
	                <div class="col-md-6">
	                	<div class="form-group">
	                        <label>Nomer HP Pengelola</label>
	                        <input type="text" maxlength="13" class="form-control" value="{{ $organisasi->no_hp_pengelola}}" readonly>
	                    </div>
						<div class="form-group">
							<label>Email</label>
							<input width="200px" type="email" class="form-control" value="{{ $organisasi->email}}" readonly>
						</div>
						<div class="form-group">
	                        <label>Status</label>
	                        <input type="text" class="form-control" value="{{ $organisasi->status}}" readonly>
	                    </div>
	                </div>
				</div>
				<hr class="border-hr">
				<div class="row">
					<div class="col-md-12">
						<a href="{{url()->previous()}}" class="btn btn-danger">Back</a>
					</div>
				</div>
			</div>
				
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
