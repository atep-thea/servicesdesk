@section('report_insiden-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Detail Insiden 
@endsection

@section('contentheader_title')
Detail Insiden
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
<script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Form Detail Insiden</h3>
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
		        <form role="form" method="POST" action="" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT')}}
                  <!--   <div class="row text-right">
                    	<div class="col-md-12">
                    		@if($pelayanan->status_tiket == 'Baru')
                    		<a style="width: 9%" class='btn btn-info'  data-toggle='modal' 
                                data-target='#deleteForm'> Proses Tiket</a>
                            @else
							<a style="width: 9%" href="{{route('pelayanan.edit', $pelayanan->id_)}}" class='btn btn-info'>Edit</a>
							<a style="width: 9%" href="{{url('sla',$pelayanan->id_)}}" class='btn btn-info'>SLA</a>
							@endif
							<a style="width: 9%" href="{{url('pelayanan')}}" class="btn btn-danger">Cancel</a>
						</div>
                    </div>  -->

                    
					@if(Session::has('success'))
				        <div class="modal fade" id="sukses-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				          <div class="modal-dialog modal-dialog-centered" role="document">
				            <div class="modal-content" style="margin-left: 25%;margin-top: 20%;border-radius: 8px">
				            <button data-remodal-action="close" class="remodal-close"></button>
				              <div class="modal-body" style="text-align: center;padding-top:30px;">
				                <div class="row">
				                		<p style="margin-bottom: 21px;">
				                			<image style="width: 30%" src="{{asset('public/images/check-circle.gif')}}"></image>
				                		</p>
				                		<h2 class="success-alert">
				                			Berhasil!!
				                		</h2>
				                       <div class="session-alert">
				                       		{{ Session::get('success') }}
				                       </div>
				                </div>
				              </div>
				              <div class="modal-footer" style="text-align: center">
				                <button type="button" class="btn btn-primary" data-dismiss="modal" style="padding: 9px;width: 95px;font-size: 1.0625em;">OK</button>
				              </div>
				            </div>
				          </div>
				        </div>
				    @endif   
			        <div class="row">
			        	<div class="col-md-6">
			        		<fieldset class="fieldset-style">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 125px;">Informasi Umum</legend>
								<p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
								<div class="panel panel-default" style="border-color: #fff !important;margin-top: -9px;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Kode Tiket </label>
															</div>
															<div class="col-sm-8" style="font-size: 16px;">
																<b>{{$pelayanan->kd_tiket}}</b>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Pelapor </label>
															</div>
															<div class="col-sm-8">
																<a href="{{route('user.show',$pelapor->id)}}">
																	{{Auth::user()->nama_depan}}&nbsp; {{Auth::user()->nama_belakang}}  </a>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Instansi Yang Dituju </label>
															</div>
															<div class="col-sm-8">
																<a href="{{url('organisasi',$pelayanan->id_opd)}}">{{$pelayanan->nama_opd}} </a>
															</div>
														</div>
													</div>
													
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Judul </label>
															</div>
															<div class="col-sm-8">
																{{ $pelayanan->judul }}
																
															</div>
														</div>
													</div>
													<div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Status </label>
															</div>
															<div class="col-sm-8">
																<input style="background-color:#ece9bd !important;color:red !important;" type="text" readonly class="form-control" name="id_agen" value="{{ $pelayanan->status_tiket }}">
															</div>
														</div>
								                    </div>
								                    <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Deskripsi </label>
															</div>
															<div class="col-sm-8">
																
										                        	{{$pelayanan->deskripsi}}
										                        
															</div>
														</div>
								                    </div>
								                    <div class="form-group">
								                    	<div class="row">
									                    	<div class="col-sm-4">
																	<label>Lampiran File Helpdesk</label>
															</div>
															<div class="col-sm-8">
																@if(empty($pelayanan->lampiran))
																	<i>Not Found</i>
																@else
																	<a href="{{url('downloadLampiran')}}/{{$pelayanan->id_}}" type="button">{{$pelayanan->lampiran}}</a>
																@endif
															</div>			
														</div>		                       
								                    </div>
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
							<br>
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 70px;">Tanggal</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Tanggal Laporan </label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="" value="{{ $pelayanan->tgl_pelaporan }}">
															</div>
														</div>
								                    </div>
								                    <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Tanggal Update</label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="tgl_update" value="{{ $pelayanan->tgl_update }}">
															</div>
														</div>
								                    </div>
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
			        	</div>
			        	<div class="col-md-6">
			        		
			        		<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 120px;">Jenis Pelayanan</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										
												{!! csrf_field() !!}
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Tipe Permintaan </label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="tipe_permintaan" value="{{ $pelayanan->tp_permintaan }}" required>
															</div>
														</div>
								                    </div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Jenis Pelayanan </label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="jns_pelayanan" value="{{ $pelayanan->pelayanan }}">
															</div>
														</div>
								                    </div>
								                    <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Jenis Insiden </label>
															</div>
															<div class="col-sm-8">
																@if($pelayanan->jns_insiden == 1)
																	<input type="text" readonly class="form-control" name="jns_insiden" value="Assesment">
																@elseif($pelayanan->jns_insiden == 2)
																	<input type="text" readonly class="form-control" name="jns_insiden" value="Insiden Report">
																@elseif($pelayanan->jns_insiden == 3)
																	<input type="text" readonly class="form-control" name="jns_insiden" value="Laporan Vurnability">
																@endif
															</div>
														</div>
								                    </div>
								                    <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Urgensi </label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="urgensi" value="{{ $pelayanan->def_urgensi }}">
															</div>
														</div>
								                    </div>
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 95px;">Respon User</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										<div class="form-group" style="margin-bottom: 25px">
											<div class="row">
												<div class="col-sm-4">
													<label>Deskripsi Balasan User </label>
												</div>
												<div class="col-sm-8">
													@if(empty($pelayanan->desk_balasan))
														<i>Tidak ada balasan</i>
													@else
													{{$pelayanan->desk_balasan}}
													@endif
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Lampiran Balasan User</label>
												</div>
												<div class="col-sm-8">
													@if(empty($pelayanan->lampiran_balasan))
														<i>Tidak ada file</i>
													@else
														 <a href="{{url('downloadInsiden')}}/{{$pelayanan->id_}}">{{$pelayanan->lampiran_balasan}}</a>
													@endif
												</div>
											</div>
					                    </div>
									</div>
								</div>
							</fieldset>

			        	</div>
			        	
			        	
			        </div>
			        <hr class="border-hr">
					<div class="row text-right">
						<div class="col-md-12">
							
							<a style="width: 9%" href="{{route('report_insiden.edit', $pelayanan->id_)}}" class='btn btn-info'>Edit</a>
							<a style="width: 9%" href="{{url('report_insiden')}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
		       
			</div>
		</div>
	</div>
</div>
@endsection
