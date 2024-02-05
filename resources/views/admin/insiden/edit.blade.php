@section('report_insiden-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Edit Report Insiden
@endsection

@section('contentheader_title')
Edit Report Insiden
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
<script src="{{asset('public/js/select_team.js')}}"></script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Report Insiden</h3>
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
		        <form role="form" method="POST" action="{{route('report_insiden.update', $pelayanan->id_)}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT')}}
			        <div class="row">
			        	<div class="col-md-12">
			        		<fieldset class="fieldset-style">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 125px;">Informasi Umum</legend>
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
															@if ($pelayanan->id_opd == $dataorg->id_organisasi )
																<option value='{{ $dataorg->id_organisasi }}' selected>{{ $dataorg->nama_opd }}</option>
															@else
																<option value="{{$dataorg->id_organisasi}}">{{$dataorg->nama_opd}}</option>
															@endif
														  @endforeach
														 </select>
													</div>
													
													<div class="form-group">
														<label>Judul Insiden</label>
														<input type="text" class="form-control" name="judul" value="{{$pelayanan->judul}}" required>
													</div>
								                    <div class="form-group">
								                        <label>Deskripsi</label>
								                        <textarea style="height: 220px;" class="form-control" name="deskripsi" required>{{$pelayanan->deskripsi}}</textarea>
								                    </div>
													<div class="form-group">
								                        <label>Jenis Insiden <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="jns_insiden" required>
								                            <option value="">- Pilih Jenis Laporan -</option>
								                            @if($pelayanan->jns_insiden == 1)
								                            	<option value="1" selected>Assesment</option>
									                            <option value="2">Insiden Report Form</option>
									                            <option value="3">Laporan Vurnability</option>
								                            @elseif($pelayanan->jns_insiden == 2)
								                            	<option value="1">Assesment</option>
									                            <option value="2" selected>Insiden Report Form</option>
									                            <option value="3">Laporan Vurnability</option>
								                            @elseif($pelayanan->jns_insiden == 3)
								                            	<option value="1">Assesment</option>
									                            <option value="2">Insiden Report Form</option>
									                            <option value="3" selected>Laporan Vurnability</option>
								                            @else
								                            	<option value="1">Assesment</option>
									                            <option value="2">Insiden Report Form</option>
									                            <option value="3">Laporan Vurnability</option>
								                            @endif 
								                        </select>
								                    </div>
								                    <div class="form-group">
								                        <label>Urgensi  <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="urgensi" required>
								                            <option value="">- Pilih Urgensi -</option>
								                             @foreach($Urgensi as $dataUrgent)
															  	@if ($pelayanan->urgensi == $dataUrgent->id_urgensi )
																	<option value='{{$dataUrgent->id_urgensi}}' selected>{{$dataUrgent->def_urgensi}}</option>
																@else
																	<option value="{{$dataUrgent->id_urgensi}}">{{$dataUrgent->def_urgensi}}</option>
																@endif
															@endforeach
								                        </select>
								                    </div>
								                    <div class="form-group">
								                        <label>Lampiran Insiden</label>
								                        <input class="form-control" type="file" name="lampiran">
								                    </div>
								                   
								                </div>
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
