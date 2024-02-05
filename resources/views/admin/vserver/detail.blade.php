@section('organisasi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Virtual Server
@endsection

@section('contentheader_title')
Virtual Server
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
				<h3 class="box-title">Data Detail Virtual Server</h3>
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
							<div class="row">
								<div class="col-md-3">
									<label>Id Infrastruktur</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->id_infrastruktur }}" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Nama Perangkat</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->nama_perangkat }}" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Model</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->model }}" readonly>
								</div>
							</div>							
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>IP Manajemen</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->ip_manajemen }}" readonly>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Status</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->status}}" readonly>
								</div>
							</div>	
	                    </div>
	                </div>
	                <div class="col-md-6">
	                	<div class="form-group">
	                		<div class="row">
								<div class="col-md-3">
									<label>Merek</label>
								</div>
								<div class="col-md-9">
									<input type="text" maxlength="13" class="form-control" value="{{ $server->no_hp_pengelola}}" readonly>
								</div>
							</div>	
	                    </div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Lisensi</label>
								</div>
								<div class="col-md-9">
									<input width="200px" type="text" class="form-control" value="{{ $server->lisensi}}" readonly>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label>Serial Nomer</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->nomer_serial}}" readonly>
								</div>
							</div>	
	                    </div>
	                    <div class="form-group">
	                    	<div class="row">
								<div class="col-md-3">
									<label>No Rak</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" value="{{ $server->nomer_serial}}" readonly>
								</div>
							</div>	
	                        
	                        
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
