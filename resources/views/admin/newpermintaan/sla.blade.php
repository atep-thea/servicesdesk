@section('pelayanan-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Detail Permintaan
@endsection

@section('contentheader_title')
Detail Permintaan
@endsection

@section('additional_styles')
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection

@section('additional_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript">
$(".dateStart").daterangepicker({
	"locale" : {
	"format" : 'YYYY-MM-DD',
	"daysOfWeek": [
		            "Mg",
		            "Sn",
		            "Sl",
		            "Rb",
		            "Km",
		            "Jm",
		            "Sb"
		        ],
	"monthNames": [
		            "Januari",
		            "Februari",
		            "Maret",
		            "April",
		            "Mei",
		            "Juni",
		            "Juli",
		            "Agustus",
		            "September",
		            "Oktober",
		            "November",
		            "Desember"
		        ],
	"firstDay": 1
},
"startDate": moment(),
"singleDatePicker" : true
});
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">SLA (Service Lavel Agreement) </h3>
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
		        <form role="form" method="POST" action="{{url('update_slanew')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                   	<input type="hidden" name="id_" value="{{$pelayanan->id_}}">
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
									    <a href="" class="remodal-confirm">Ya</a>
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
			        	<div class="col-md-12" style="padding-left:45px;padding-right: 45px;">
			        		<fieldset class="fieldset-style">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 125px;">Detail SLA</legend>
								<div class="panel panel-default" style="border-color: #fff !important;margin-top: -9px;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>Kode Tiket </label>
															</div>
															<div class="col-sm-9" style="font-size: 16px;">
																<b>{{$pelayanan->kd_tiket}}</b>
															</div>
														</div>
													</div>
													
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>Judul </label>
															</div>
															<div class="col-sm-9">
																{{ $pelayanan->judul }}
																
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>Organisasi </label>
															</div>
															<div class="col-sm-9">
																<a href="{{url('organisasi.show',$pelayanan->id_opd)}}">{{$pelayanan->opd}} </a>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>Tgl Kirim SLA </label>
															</div>
															<div class="col-sm-9">
																@if(empty($pelayanan->tgl_kirim_sla))
																	<input type="text" class="form-control dateStart" name="tgl_kirim_sla">
																@else
																	<input type="text" class="form-control dateStart" name="tgl_kirim_sla" value="{{$pelayanan->tgl_kirim_sla}}">
																@endif

															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-3">
																<label>File SLA </label>
															</div>
															<div class="col-sm-9">
																@if(!empty($pelayanan->file_sla))
																	Download file SLA : <a href="{{url('downloadSlaNew')}}/{{$pelayanan->id_}}" type="button">{{$pelayanan->file_sla}}</a>
																@endif
																<p></p>
																<input type="file" class="form-control" name="file_sla">

															</div>
														</div>
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
							<button type="submit" style="width: 9%" class="btn btn-primary">Save</button>
							<a style="width: 9%" href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
		       
			</div>
		</div>
	</div>
</div>
@endsection
