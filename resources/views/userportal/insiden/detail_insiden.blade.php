<div class="modal fade" id="detailInsiden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="padding:0px;width: 995px;">
    <div class="modal-content" >
      <div class="modal-header" style="background: #4f715a;color: #fff;font-size: 15px;">
        <h5 class="modal-title" id="exampleModalLabel">Detail Informasi Insiden</h5>
        <button style="margin-top:-20px !important;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span style="color:#fff" aria-hidden="true">&times;</span>
        </button>
      </div>

    <form method="POST" action="{{url('update_insiden')}}" enctype="multipart/form-data">
    	{!! csrf_field() !!}
      <div class="modal-body">
        <div class="row">
        	<div class="col-md-7">
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
													<b><span id="kode"></span></b>
													<input type="hidden" id="kode3" name="kode_tiket">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Perangkat Daerah </label>
												</div>
												<div class="col-sm-8">	
												<a href="" class="" data-toggle="modal" data-target="#orgDetail"><span id="opd"></span></a>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4">
													<label>Judul </label>
												</div>
												<div class="col-sm-8">
													<input type="hidden" readonly class="form-control" name="judul" id="jdl3" value="">
													<span id="jdl"></span>
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
													<span id="sts"></span>
												</div>
											</div>
					                    </div>
					                </div>
								</div>
						</div>
					</div>
					
				</fieldset>
        	</div>
        	<div class="col-md-5">
        		
        		<fieldset class="fieldset-style" style="background: #f9f9f9;margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
					<legend class="legend-style" style="width:35%;background-color:#e87c1e;color: #fff;border:none;">Jenis Pelayanan</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;">
						<div class="panel-body" style="padding: 0px;">
							
									
								<div class="row top-22">
									<div class="col-md-12">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-5">
													<label>Jenis Insiden </label>
												</div>
												<div class="col-sm-7">
													<!-- <input type="text" readonly class="form-control" name="tipe_permintaan" id="jnsInsiden"> -->
													<span id="jnsInsiden"></span>
												</div>
											</div>
					                    </div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-5">
													<label>Jenis Pelayanan </label>
												</div>
												<div class="col-sm-7">
													<!-- <input type="text" readonly class="form-control" name="jns_pelayanan" id="plynn" value=""> -->
													<span>Laporan Insiden</span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-5">
													<label>Urgensi </label>
												</div>
												<div class="col-sm-7">
													<!-- <input type="text" id="urgen" readonly class="form-control" name="urgensi" value=""> -->
													<span id="urgen"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
											<div class="row">
												<div class="col-sm-5">
													<label>Tanggal Laporan </label>
												</div>
												<div class="col-sm-7">
													<!-- <input type="text" readonly class="form-control" name="" value="" id="tgl_dft"> -->
													<span id="tgl_dft"></span>
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
        <br>
        <div class="row">
        	<div class="col-md-12">
        		<fieldset class="fieldset-style" style="background: #f9f9f9;">    	
					<legend class="legend-style" style="width:14%;background-color:#e87c1e;color: #fff;border:none;">Deskripsi Insiden</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;margin-top: -9px;margin-bottom:5px !important;">
						<div class="panel-body" style="padding: 0px;">
								<div class="row top-22">
									<div class="col-md-12">
					                    <div class="form-group">
					                    	<div class="row">
					                    		<div class="col-sm-3">
													<img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" style="width:40px;height:40px;margin-left:11px;border-radius: 90%;">
													&nbsp;
													<span style="color:#3a6d99;font-weight:bold;">Keterangan Pelapor</span>
												</div>
												<div class="col-sm-9">
													<span id="desk"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-3">
													<img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" style="width:40px;height:40px;margin-left:11px;border-radius: 90%;">
													&nbsp;
													<span style="color:#3a6d99;font-weight:bold;">{{Auth::user()->nama_depan}}&nbsp;{{Auth::user()->nama_belakang}}</span>
												</div>
												<div class="col-sm-9">
													<span id="balasan"></span>
												</div>
											</div>
					                    </div>
					                </div>
								</div>

						</div>
					</div>
        	</div>
        </div>
        <br>
        <!-- t -->

        <div class="row">
        	<div class="col-md-12">
        		<fieldset class="fieldset-style" style="background: #f9f9f9;">    	
					<legend class="legend-style" style="width:8%;background-color:#e87c1e;color: #fff;border:none;">Balasan</legend>
					<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;margin-top: -9px;">
						<div class="panel-body" style="padding: 0px;">
								<div class="row top-22">
									<div class="col-md-12">
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-12">
													<label>Uraian Balasan</label>
												</div>
												<div class="col-sm-12">
							                        <textarea name="balasan" class="form-control" style="height: 130px"></textarea>
												</div>
											</div>
					                    </div>
					                    <div class="form-group">
					                    	<div class="row">
												<div class="col-sm-3">
													<label>Lampirkan File Balasan</label>
												</div>
												<div class="col-sm-9">
							                        <input type="file" name="surat_blsn" class="form-control">
												</div>
											</div>
					                    </div>
					                </div>
								</div>
						</div>
					</div>
        	</div>
        </div>
        <!-- <div class="row">
        	<div class="col-md-12">
        		<div class="form-group" style="margin-bottom:10px;">
					<div class="row">
						<div class="col-sm-12">
							<label>Lampiran </label>
						</div>
						<div class="col-sm-12">
							<input style="background: #f9f9f9;padding: 20px;width: 100%;" type="file" name="lampiran"><span style="color:#dd4b39;font-size:11px;">(Maximum File size: 20MB)</span>
						</div>
					</div>
                </div>
            </div>
        </div>
		 -->
      </div>
      <div class="modal-footer">
      	<input type="hidden" id="idTiket" name="id_tiket">
        <button type="submit" class="btn" style="background: #4f715a;color: #fff;">Balas</button>
        <a id="cancel" data-dismiss="modal" aria-label="Close" onclick="cancelForm()" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cancel</a>
      </div>
  </form>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

