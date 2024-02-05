<div class="modal fade" id="orgDetail" tabindex="-1" role="dialog" aria-labelledby="orgDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="padding:0px;width: 995px;">
    <div class="modal-content" >
      <div class="modal-header" style="background:#585653;color:#fff;font-size: 15px;">
        <h5 class="modal-title" id="orgDetailLabel">Detail Organisasi</h5>
        <button style="margin-top:-20px !important;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#fff">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form style="padding:15px;" id="" role="form" method="POST" action="#" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    {{ method_field('PUT')}}
			<div class="row">
				<div class="col-md-6">
					<fieldset class="fieldset-style" style="background: #f9f9f9;margin-bottom: 15px;padding-top: 0px;padding-bottom: 0px;">    	
						<legend class="legend-style" style="width:25%;background-color:#e87c1e;color: #fff;border:none;">Identitas</legend>
						<div class="panel panel-default" style="border-color: #fff !important;background:#f9f9f9;">
							<div class="panel-body" style="padding: 0px;">
								{!! csrf_field() !!}
								<div class="row top-22">
									<div class="col-md-12">
										<div class="form-group" style="margin-bottom:10px;">
											<div class="row">
												<div class="col-sm-4">
													<label>Organisasi </label>
												</div>
												<div class="col-sm-7">
													<span id="nm_org"></span>
												</div>
											</div>
					                    </div>
										<div class="form-group" style="margin-bottom:10px;">
											<div class="row">
												<div class="col-sm-4">
													<label>Induk Organisasi</label>
												</div>
												<div class="col-sm-7">
													<span id="induk_org"></span>
												</div>
											</div>
					                    </div>
					                    <div class="form-group" style="margin-bottom:10px;">
											<div class="row">
												<div class="col-sm-4">
													<label>Email </label>
												</div>
												<div class="col-sm-7">
													<span id="email_org"></span>
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
						<legend class="legend-style" style="width:25%;background-color:#e87c1e;color: #fff;border:none;">Identitas</legend>
						<div class="panel panel-default" style="border-color: #fff !important;background:#f9f9f9;">
							<div class="panel-body" style="padding: 0px;">
								{!! csrf_field() !!}
								<div class="row top-22">
									<div class="col-md-12">
										<div class="form-group" style="margin-bottom:10px;">
											<div class="row">
												<div class="col-sm-4">
													<label>Nama Pengelola</label>
												</div>
												<div class="col-sm-7">
													<span id="nm_peng"></span>
												</div>
											</div>
					                    </div>
										<div class="form-group" style="margin-bottom:10px;">
											<div class="row">
												<div class="col-sm-4">
													<label>No HP Pengelola</label>
												</div>
												<div class="col-sm-7">
													<span id="hp_peng"></span>
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
		</form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">Close</span>
        </button>
       <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

