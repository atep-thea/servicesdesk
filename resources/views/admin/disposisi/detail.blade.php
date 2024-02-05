@section('disposisi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Detail Permintaan
@endsection

@section('contentheader_title')
Detail Permintaan
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
				<h3 class="box-title">Form Detail Permintaan</h3>
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
                    <div class="row text-right">
                    	<div class="col-md-12">														
							@if($pelayanan->status_tiket == 'Baru')                    		
								<a style="width: 9%" class='btn btn-info'  data-toggle='modal' data-target='#deleteForm'> Proses Tiket</a>  
							@else							
								<a style="width: 9%" href="{{route('disposisi.edit', $pelayanan->id_)}}" class='btn btn-info'>Edit</a>	
								<a style="width: 9%" href="{{url('sla',$pelayanan->id_)}}" class='btn btn-info'>SLA</a>							
							@endif							
							<a style="width: 9%" href="{{url('disposisi')}}" class="btn btn-danger">Cancel</a>
						</div>
                    </div>   					
                     <div class="modal fade" id="deleteForm" tabindex="-1" role="dialog" aria-hidden="true">
						<!--  -->
						<div class="modal-dialog" role="document" style="padding:0px;width: 750px;margin-top:118px;">
						    <div class="modal-content" >
						      
						      <div class="modal-body" align="center">
										<a data-dismiss="modal" data-remodal-action="close" class="remodal-close"></a>
									    <h2>Proses Tiket ini Sekarang?</h2>
									    <p>
									    </p>
									    <p></p><br>
									    <br>
									    <a data-dismiss="modal" data-remodal-action="cancel" class="remodal-cancel">Tidak</a>
									    <a href="{{url('proses_tiket',$pelayanan->id_)}}" class="remodal-confirm">Ya</a>
						      </div>
						    </div>
						</div>
					</div>  
					@if(Session::has('success'))
					<script> $(document).ready(function(){ $('#sukses-modal').modal('show'); }); </script>
			        <div class="modal fade" id="sukses-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			          <div class="modal-dialog modal-dialog-centered" role="document">
			            <div class="modal-content" style="margin-left: 37%;margin-top: 20%;width: 50%;">
			              <div class="modal-body">
			                <div class="row">
			                       <div class="col-md-12" style="text-align: center">
			                       <img src="{{asset('public/images/success-icon.png')}}" style="width: 50%;">
			                       <h4 class="modal-title" id="exampleModalLongTitle"><strong>Sukses!</strong> </h4>
			                       <h5>{{ Session::get('success') }}</h5>
			                       </div>
			                </div>
			              </div>
			              <div class="modal-footer bg-success" style="text-align: center">
			                <button type="button" class="btn btn-success" data-dismiss="modal" style="width:95%;">Ok</button>
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
																@if(!empty($pelapor))
																<a href="{{route('user.show',$pelapor->id)}}">{{$pelapor->user_nmdepan}} {{$pelapor->user_nmbelakang}} </a>
																@else
																-
																@endif
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Organisasi </label>
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
																<input type="text" readonly class="form-control" name="judul" value="{{ $pelayanan->judul }}">
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
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 78px;">User Info</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
								                    	<div class="row">
									                    	<div class="col-sm-4">
																	<label>Lampiran file User</label>
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
													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
																<label>Balasan User </label>
															</div>
															<div class="col-sm-8">
																{{$pelayanan->desk_balasan}}
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
																<label>Sub Jenis Pelayanan </label>
															</div>
															<div class="col-sm-8">
																<input type="text" readonly class="form-control" name="sub_jns_pelayanan" value="{{ $pelayanan->jenis_pelayanan }}">
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
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 75px;">Lain lain</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Agen </label>
												</div>
												<div class="col-sm-8">
													@if(empty($pelayanan->nama_agen))
														-
													@else
													<a href="{{url('user',$pelayanan->id_agen)}}">{{ $pelayanan->nama_agen }} {{ $pelayanan->nama_belakang }} </a>
													@endif
													
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Team </label>
												</div>
												<div class="col-sm-8">
													@if(empty($pelayanan->name_team))
														-
													@else
														{{ $pelayanan->name_team }}
													@endif
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
						                    	<div class="col-sm-4">
														<label>Lampiran File Helpdesk</label>
												</div>
												<div class="col-sm-8">
													@if(empty($pelayanan->lampiran_balasan))
														<i>Not Found</i>
													@else
														<a href="{{url('downloadBalasan')}}/{{$pelayanan->id_}}" type="button">{{$pelayanan->lampiran_balasan}}</a>
													@endif
												</div>			
											</div>		                       
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Catatan Tim Helpdesk </label>
												</div>
												<div class="col-sm-8">
													
							                        	{{$pelayanan->solusi}}
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
							@if($pelayanan->status_tiket == 'Baru')
							<a style="width: 9%" class='btn btn-info'  data-toggle='modal' 
                                data-target='#deleteForm'> Proses Tiket</a>
							@else
							<a style="width: 9%" href="{{route('disposisi.edit', $pelayanan->id_)}}" class='btn btn-info'>Edit</a>
							<a style="width: 9%" href="{{route('disposisi.edit', $pelayanan->id_)}}" class='btn btn-info'>SLA</a>
							@endif
							<a style="width: 9%" href="{{url('disposisi')}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
		       
			</div>
		</div>
	</div>
</div>
@endsection
