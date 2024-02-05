@section('disposisi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Edit Pelayanan
@endsection

@section('contentheader_title')
Edit Pelayanan
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />
<style type="text/css">
.radio-toolbar {
  margin: 10px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #ddd;
    padding: 6px 24px;
    font-family: sans-serif, Arial;
    font-size: 13px;
    border: 2px solid #999;
    border-radius: 4px;
}

.radio-toolbar label:hover {
  background-color: #dfd;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #bfb;
    border-color: #4c4;
}
</style>
@endsection

@section('additional_scripts')
<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script type="text/javascript">
	function klikDisposisi() {
	  var x = document.getElementById("formDispo");
	  var y = document.getElementById("btnDisposisi");
	  var z = document.getElementById("pending");
	  var o = document.getElementById("selesai");
	  var p = document.getElementById("close");
	  var q = document.getElementById("cancelx");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	    y.style.display = "none";
	    z.style.display = "none";
	    o.style.display = "none";
	    p.style.display = "none";
	    q.style.display = "none";
	  } else {
	    x.style.display = "none";
	  }
	}
	function cancelForm() {
	  var x = document.getElementById("formDispo");
	  var y = document.getElementById("btnDisposisi");
	  var z = document.getElementById("pending");
	  var o = document.getElementById("selesai");
	  var p = document.getElementById("close");
	  var a = document.getElementById("cancel");
	  var q = document.getElementById("cancelx");
	  if (x.style.display === "none") {
	    x.style.display = "block";
	    y.style.display = "none";
	    z.style.display = "none";
	    o.style.display = "none";
	    p.style.display = "none";
	    q.style.display = "none";
	  } else {
	    x.style.display = "none";
	    y.style.display = "block";
	    z.style.display = "block";
	    o.style.display = "block";
	    p.style.display = "block";
	    q.style.display = "block";
	  }
	}

	$(document).ready(function() {
		$('select[name="id_team"]').on('change', function(){
	        var idTeam = $(this).val();
	        if(idTeam) {
	            $.ajax({
	                url: '/servicedesk_2.0/disposisi/getAgen/'+idTeam,
	                type:"GET",
	                dataType:"json",

	                success:function(data) {
	                    
	                    $('select[name="agen_id"]').empty();
						console.log(data);
	                    $.each(data, function(key, value){
	                        key
	                        $('select[name="agen_id"]').append('<option value="'+ key +'">' + value + '</option>');

	                    });
	                },

	            });
	        } else {
	            $('select[name="agen_id"]').empty();
	        }

	    });
	});
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Edit Pelayanan</h3>
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
		        
		        <form role="form" method="POST" action="{{route('disposisi.update', $pelayanan->id_)}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT')}}
                                       		
                   <!--  <div class="row" style="display: none;margin-bottom: 10px;padding: 5px;" id="formDispo">
                    	<div style="background-color: #b7d9ef; border:3px solid #1b94c4;padding:10px;" class="col-md-12">
                    		<div class="row" style="margin-bottom:10px">
                    			<div class="form-group">
	                    			<div class="col-md-1">
	                    				<label>Team </label>
	                    			</div>
	                    			<div class="col-md-3">
	                    				<select class="form-control js-example-basic-single" style="width: 100% !important;" name="id_team">
				                            <option value="">- Pilih Team -</option>
				                            @foreach($Team as $dataTeam)
												<option value='{{$dataTeam->id_team}}'>{{$dataTeam->name_team}}</option>
											@endforeach
				                        </select>
	                    			</div>
			                    </div>
                    		</div>
                    		<div class="row" style="margin-bottom:10px">
                    			<div class="form-group">
	                    			<div class="col-md-1">
	                    				<label>Agen</label>
	                    			</div>
	                    			<div class="col-md-3">
	                    				<select class="form-control js-example-basic-single" style="width: 100% !important;" name="agen_id">
				                            <option>- Pilih Agen -</option>
				                        </select>
	                    			</div>
			                    </div>
                    		</div>
                    		
							<div class="row">
								<div class="col-md-12">
									<button name="dispo" value="disposisi" type="submit" class="btn btn-primary">Save</button>&nbsp;
									<a id="cancel" onclick="cancelForm()" class="btn btn-danger">Cancel</a>
								</div>
							</div>
                    	</div>
                    </div> -->
                    <div class="row" style="text-align: left;">
                    	<div class="col-md-6">
                    		<div class="radio-toolbar">
                    			@if($pelayanan->status == 'Pending')
							    <input type="radio" id="radioApple" name="statustiket" value="Pending" checked>
							    <label for="radioApple">Pending</label>
							    <input type="radio" id="radioBanana" name="statustiket" value="Selesai">
							    <label for="radioBanana">Selesai</label>
							    <input type="radio" id="radioOrange" name="statustiket" value="Close">
							    <label for="radioOrange">Close Tiket</label>
							    @elseif($pelayanan->status == 'Selesai')
							    <input type="radio" id="radioOrange" name="statustiket" value="Close">
							    <label for="radioOrange">Close Tiket</label>
							    @elseif($pelayanan->status == 'Close')
							    <input type="radio" id="radioOrange" name="statustiket" value="Re-open">
							    <label for="radioOrange">Re-Open</label>
							    @else
							    <input type="radio" id="radioApple" name="statustiket" value="Pending">
							    <label for="radioApple">Pending</label>
							    <input type="radio" id="radioBanana" name="statustiket" value="Selesai">
							    <label for="radioBanana">Selesai</label>
							    <input type="radio" id="radioOrange" name="statustiket" value="Close">
							    <label for="radioOrange">Close Tiket</label>
							    @endif
							    
							</div>
                    	</div>
                    	<div class="col-md-6" style="text-align: right;">
                    		<button name="update" value="update" type="submit" class="btn btn-primary" style="width: 100px">Save</button>&nbsp;
								<a href="{{url()->previous()}}" class="btn btn-danger" style="width: 100px">Cancel</a>
                    	</div>
                    </div>
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
																<label>Kode Tiket </label>
															
																<b><input type="text" readonly="" name="" class="form-control" value="{{$pelayanan->kd_tiket}}"></b>
													</div>
													<div class="form-group">
														<label>Perangkat Daerah <a class="text-red">*</a></label>
														<select name="id_opd" class="form-control js-example-basic-single" required>
									                  	  <option value="">- Pilih Perangkat Daerah -</option>
												  		  @foreach($org as $dataorg)
															@if ($pelayanan->id_opd == $dataorg->id_organisasi )
																<option value='{{ $dataorg->id_organisasi }}' selected>{{ $dataorg->nama_opd }}</option>
															@else
																<option value="{{$dataorg->id_organisasi}}">{{$dataorg->nama_opd}}</option>
															@endif
														  @endforeach
														 </select>
													</div>
													
													<div class="form-group">
														<label>Judul</label>
														<input type="text" class="form-control" name="judul" value="{{ $pelayanan->judul }}" required>
													</div>
													<div class="form-group">
								                        <label>Status  <a class="text-red">*</a></label>
								                        <input style="background-color:#ece9bd !important;color:red !important;" class="form-control" type="text" name="status" value="{{ $pelayanan->status }}" readonly>
								                    </div>
								                    <div class="form-group">
								                        <label>Deskripsi</label>
								                        <textarea style="height: 220px;" class="form-control" name="deskripsi" required><?php echo trim($pelayanan->deskripsi);?></textarea>
								                    </div>
													
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;margin-top: 20px;">    	
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
								                    <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Lampiran file User</label>
															</div>
															<div class="col-sm-8">
																@if(empty($pelayanan->lampiran))
																	 <input class="form-control" type="file" name="lampiran">
																@else
																	<a href="{{url('downloadLampiran')}}/{{$pelayanan->id_}}" type="button">{{$pelayanan->lampiran}}</a>
																@endif
															</div>
														</div>								                        
								                    </div>
								                     <div class="form-group">
								                    	<div class="row">
															<div class="col-sm-4">
																<label>Balasan User</label>
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
			        		<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 140px;">Urgensi & Disposisi</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
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
					                        <label>Team  <a class="text-red">*</a></label>
					                        <select class="form-control js-example-basic-single" style="width: 100% !important;" name="id_team" required>
					                            <option value="">- Pilih Team -</option>
					                            @foreach($Team as $dataTeam)
													@if($pelayanan->id_team == $dataTeam->id_team)
														<option value='{{$dataTeam->id_team}}' selected>{{$dataTeam->name_team}}</option>
													@else
														<option value='{{$dataTeam->id_team}}'>{{$dataTeam->name_team}}</option>
													@endif
												@endforeach
					                        </select>
					                    </div>
										<div class="form-group">
			                    			<label>Agen  <a class="text-red">*</a></label>
		                    				<select class="form-control js-example-basic-single" style="width: 100% !important;" name="agen_id" required>
					                           
					                            	@if(!empty($pelayanan->id_agen))
														<option value='{{$pelayanan->id_agen}}' selected>{{$pelayanan->nmdepan}}</option>
													@else
														 <option value="">- Pilih Agen -</option>
													@endif
					                        </select>
					                    </div>
					                    
					                    
									</div>
								</div>
							</fieldset>
			        		<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 120px;">Jenis Pelayanan</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
											<div class="row top-22">
												<div class="col-md-12">
													<div class="form-group">
								                        <label>Tipe Permintaan <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="tipe_permintaan" required>
								                            <option value="">- Pilih Tipe Permintaan -</option>
								                            @foreach($TipePermin as $dataTipe)
																@if ($pelayanan->tipe_permintaan == $dataTipe->id_tipe )
																	<option value='{{$dataTipe->id_tipe}}' selected>{{$dataTipe->tp_permintaan}}</option>
																@else
																	<option value="{{$dataTipe->id_tipe}}">{{$dataTipe->tp_permintaan}}</option>
																@endif
															@endforeach
								                        </select>
								                    </div>
													<div class="form-group">
								                        <label>Jenis Pelayanan <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="jns_pelayanan" required>
								                            <option value="">- Pilih Jenis Pelayanan -</option>
								                            @foreach($JnsPlynn as $dataJns)
															  	@if ($pelayanan->jns_pelayanan == $dataJns->id_pelayanan )
																	<option value='{{$dataJns->id_pelayanan}}' selected>{{$dataJns->pelayanan}}</option>
																@else
																	<option value="{{$dataJns->id_pelayanan}}">{{$dataJns->pelayanan}}</option>
																@endif
															@endforeach
								                        </select>
								                    </div>
								                    <div class="form-group">
								                        <label>Sub Jenis Pelayanan  <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="sub_jns_pelayanan">
								                            <option value="">- Pilih Sub Jenis Pelayanan -</option>
								                             @foreach($SjnsPlynn as $dataSjns)
															  	@if ($pelayanan->sub_jns_pelayanan == $dataSjns->id_sjns_pelayanan )
																	<option value='{{$dataSjns->id_sjns_pelayanan}}' selected>{{$dataSjns->jenis_pelayanan}}</option>
																@else
																	<option value="{{$dataSjns->id_sjns_pelayanan}}">{{$dataSjns->jenis_pelayanan}}</option>
																@endif
															@endforeach
								                        </select>
								                    </div>
								                    <div class="form-group">
								                        <label>Sub Sub Jenis Pelayanan  <a class="text-red">*</a></label>
								                        <select class="form-control js-example-basic-single" name="ssjns">
								                            <option value="">- Pilih Sub Sub Jenis Pelayanan -</option>
								                             @foreach($Ssjns as $dataSsjns)
															  	@if ($pelayanan->ssub_jns_pelayanan == $dataSsjns->id_ssjns )
																	<option value='{{$dataSsjns->id_ssjns}}' selected>{{$dataSsjns->ssjns}}</option>
																@else
																	<option value="{{$dataSsjns->id_ssjns}}">{{$dataSsjns->ssjns}}</option>
																@endif
															@endforeach
								                        </select>
								                    </div>
								                    
								                </div>
											</div>
									</div>
								</div>
								
							</fieldset>
							
							<fieldset class="fieldset-style" style="margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">    	
								<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;width: 80px;">Lainnya</legend>
								<div class="panel panel-default" style="border-color: #fff !important;">
									<div class="panel-body" style="padding: 0px;">
										<div class="form-group">
					                    	<label>File Extend</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					                    	@if(empty($pelayanan->lampiran_balasan))
												 <i>Not Found </i>
											@else
												<a href="{{url('downloadInsisden')}}/{{$pelayanan->id_}}" type="button">{{$pelayanan->lampiran_balasan}}</a>
											@endif
					                    </div>		
										<div class="form-group">
					                    	<label>Lampiran</label>
					                    	 <input class="form-control" type="file" name="lampiran_balasan">
					                    </div>																	
					                    <div class="form-group">
					                    	<label>Catatan Helpdesk</label>
					                    	<textarea style="height: 180px;" class="form-control" name="solusi">{{$pelayanan->solusi}}</textarea>
					                    </div>
					                    
									</div>
								</div>
							</fieldset>
			        	</div>
			        	
			        	
			        </div>
			        <hr class="border-hr">
					<div class="row text-right">
						<div class="col-md-12">
							<button name="update" value="update" type="submit" class="btn btn-primary" style="width: 100px">Save</button>&nbsp;
							<a href="{{url()->previous()}}" class="btn btn-danger" style="width: 100px">Cancel</a>
						</div>
					</div>
				</form>
		       
			</div>
		</div>
	</div>
</div>
@endsection
