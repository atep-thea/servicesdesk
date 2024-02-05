@section('disposisi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Input Pelayanan
@endsection

@section('contentheader_title')
Input Pelayanan
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
<script src="{{asset('public/js/select_dependent.js')}}"></script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Input Pelayanan</h3>
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
		        <form role="form" method="POST" action="{{route('disposisi.store')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
			        <div class="row">
			        	<div class="col-md-6">
			        		<fieldset class="fieldset-style">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;">Informasi Umum</legend>
								<p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
								<div class="panel panel-default" style="border-color: #fff !important;margin-top: -9px;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
														<label>Perangkat Daerah <a class="text-red">*</a></label>
														<select name="id_opd" class="form-control js-example-basic-single" required>
									                  	  <option value="">- Pilih Perangkat Daerah -</option>
												  		  @foreach($org as $dataorg)
														  	<option value='{{$dataorg->id_organisasi}}'>{{$dataorg->nama_opd}}</option>
														  @endforeach
														 </select>
													</div>
													
													<div class="form-group">
														<label>Judul</label>
														<input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required>
													</div>
								                    <div class="form-group">
								                        <label>Deskripsi</label>
								                        <textarea style="height: 220px;" class="form-control" name="deskripsi" required></textarea>
								                    </div>
													<div class="form-group">
								                        <label>Tipe Permintaan <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="tipe_permintaan" required>
								                            <option value="">- Pilih Tipe Permintaan -</option>
								                            @foreach($TipePermin as $dataTipe)
															  	<option value='{{$dataTipe->id_tipe}}'>{{$dataTipe->tp_permintaan}}</option>
															@endforeach
								                        </select>
								                    </div>
								                   
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
			        	</div>
			        	<div class="col-md-6">
			        		
			        		<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;">Jenis Pelayanan</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										
												{!! csrf_field() !!}
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
								                        <label>Jenis Pelayanan <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="jns_pelayanan" required>
								                            <option value="">- Pilih Jenis Pelayanan -</option>
								                             @foreach($JnsPlynn as $dataJns)
															  	<option value='{{$dataJns->id_pelayanan}}'>{{$dataJns->pelayanan}}</option>
															@endforeach
								                        </select>
								                    </div>
								                    <div class="form-group">
								                        <label>Sub Jenis Pelayanan  <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="sub_jns_pelayanan">
						                                     <option>-- Sub Jenis Pelayanan --</option>
						                                </select>
								                        <!--  -->
								                    </div>
								                   
								                    <div class="form-group">
								                        <label>Urgensi  <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="urgensi" required>
								                            <option value="">- Pilih Urgensi -</option>
								                             @foreach($Urgensi as $dataUrgent)
															  	<option value='{{$dataUrgent->id_urgensi}}'>{{$dataUrgent->def_urgensi}}</option>
															@endforeach
								                        </select>
								                    </div>
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;">Lain lain</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										<div class="form-group">
					                        <label>Agen  <a class="text-red">*</a></label>
					                        <select class="form-control js-example-basic-single" name="id_agen">
					                            <option value="">- Pilih Agen -</option>
					                            @foreach($Agen as $dataAgen)
												  	<option value='{{$dataAgen->id}}'>{{$dataAgen->nama_depan }} {{ $dataAgen->nama_belakang}}</option>
												@endforeach
					                        </select>
					                    </div>
					                    <div class="form-group">
					                        <label>Status  <a class="text-red">*</a></label>
					                        <input class="form-control" type="text" name="status" value="Diajukan" readonly>
					                    </div>
					                    <div class="form-group">
					                        <label>Lampiran file</label>
					                        <input class="form-control" type="file" name="lampiran">
					                    </div>
									</div>
								</div>
							</fieldset>

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
