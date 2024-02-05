<div class="modal fade" id="closeDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="padding:0px;width: 995px;">
    <div class="modal-content" >
      <div class="modal-header" style="background:#4f715a;color:#fff;font-size: 15px;">
        <h5 class="modal-title" id="exampleModalLabel">Detail Close Tiket</h5>
        <button style="margin-top:-20px !important;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span style="color:#fff" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-md-6">
        		<fieldset class="fieldset-style" style="background: #f9f9f9;">    	
					<legend class="legend-style" style="width:30%;background-color:#e87c1e;color: #fff;border:none;">Informasi Umum</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;margin-top: -9px;">
						<div class="panel-body" style="padding: 0px;">
								<div class="row top-22">
									<div class="col-md-12">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Kode Tiket </label>
												</div>
												<div class="col-sm-8">	
													<b><span id="kode2"></span></b>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Perangkat Daerah </label>
												</div>
												<div class="col-sm-8">	
												<a href="" class="" data-toggle="modal" data-target="#orgDetail"><span id="opd2"></span></a>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Judul </label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" readonly class="form-control" name="judul" id="jdl" value=""> -->
													<span id="jdl2"></span>
												</div>
											</div>
										</div>
										<div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Status </label>
												</div>
												<div class="col-sm-8">
													<!-- <input style="background-color:#ece9bd !important;color:red !important;" type="text" readonly class="form-control" name="id_agen" id="sts" value=""> -->
													<span id="sts2"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Deskripsi </label>
												</div>
												<div class="col-sm-8">
													<!-- <textarea readonly style="height: 220px;" class="form-control" name="deskripsi" id="desk"> -->
							                        	<!-- <span id="desk"></span> -->
							                        <!-- </textarea> -->
							                        <span id="desk2"></span>
												</div>
											</div>
					                    </div>
					                </div>
								</div>
						</div>
					</div>
					
				</fieldset>
				<br>
				<fieldset class="fieldset-style" style="background: #f9f9f9;margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
					<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;">Tanggal</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;">
						<div class="panel-body" style="padding: 0px;">
								<div class="row top-22">
									<div class="col-md-12">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Tanggal Laporan </label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" readonly class="form-control" name="" value="" id="tgl_dft"> -->
													<span id="tgl_dft2"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Tanggal Update</label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" readonly class="form-control" name="tgl_update" value="" id="tgl_upd"> -->
													<span id="tgl_upd2"></span>
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
        		
        		<fieldset class="fieldset-style" style="background: #f9f9f9;margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
					<legend class="legend-style" style="width:35%;background-color:#e87c1e;color: #fff;border:none;">Jenis Pelayanan</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;">
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
													<!-- <input type="text" readonly class="form-control" name="tipe_permintaan" id="tp" value="" required> -->
													<span id="tp2"></span>
												</div>
											</div>
					                    </div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Jenis Pelayanan </label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" readonly class="form-control" name="jns_pelayanan" id="plynn" value=""> -->
													<span id="plynn2"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Sub Jenis Pelayanan </label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" readonly class="form-control" name="sub_jns_pelayanan" id="sjns" value=""> -->
													<span id="sjns2"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-4">
													<label>Urgensi </label>
												</div>
												<div class="col-sm-8">
													<!-- <input type="text" id="urgen" readonly class="form-control" name="urgensi" value=""> -->
													<span id="urgen2"></span>
												</div>
											</div>
					                    </div>
					                </div>
								</div>
						</div>
					</div>
					
				</fieldset>
				<fieldset class="fieldset-style" style="background: #f9f9f9;margin-bottom: 15px;padding-top: 9px;padding-bottom: 0px;">    	
					<legend class="legend-style" style="background-color:#e87c1e;color: #fff;border:none;">Lain lain</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;">
						<div class="panel-body" style="padding: 0px;">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-4">
										<label>Agen </label>
									</div>
									<div class="col-sm-8">
										<span id="nm_dpn2"></span>&nbsp;<span id="nm_blkg2"></span>
									</div>
								</div>
		                    </div>
		                    
		                    <div class="form-group">
		                    	<div class="row">
									<div class="col-sm-4">
										<label>Solusi </label>
									</div>
									<div class="col-sm-8">
										<!-- <textarea readonly style="height: 180px;" class="form-control" name="solusi" id="solusi">
				                        	
				                        </textarea> -->
				                        <span id="solusi2"></span>
									</div>
								</div>
		                    </div>
		                    
						</div>
					</div>
				</fieldset>

        	</div>
        </div>
      </div>
      <div class="modal-footer">
      	<form method="POST" action="{{url('reopen_tiket')}}" enctype="multipart/form-data">
      		{!! csrf_field() !!}
      		<input type="hidden" id="idTiket" name="idtiket" value="">
      		<!-- @if(Auth::user()->role_user != 2)
      		<button type="submit" name="close" value="Close" class="btn btn-success"><span aria-hidden="true">Re-Open Tiket</span></button>
      		@endif -->
        	<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;<span aria-hidden="true">Cancel</span></button>
      	</form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

