@section('slaba-link')class="active" @stop
@extends('layout.adminlte.user_portal')
@section('contentheader_title')
@endsection
@section('main-content')

<div class="row">

	<div class="col-md-12">

		<div class="">

			<div class="box-header" style="background-color: #4f715a; text-align: center; color: #fff;">

				<h3 class="box-title">Detail Pelayanan</h3>

			</div>
			<div class="box-body ">

				<div class="box box-info" style="border-color: #4f715a !important">
		            <div class="box-header with-border">
		              <h3 class="box-title">Detail Informasi Tiket</h3>

		              <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
		                </button>
		                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		              </div>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body" style="">
		            <!-- test -->
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

																	<b><span>{{$slaba->kode_tiket}}</span></b>

																</div>

															</div>

														</div>

														<div class="form-group">

															<div class="row">

																<div class="col-sm-4">

																	<label>Perangkat Daerah </label>

																</div>

																<div class="col-sm-8">	

																<a href="" class="" data-toggle="modal" data-target="#orgDetail"><span>{{$slaba->nama_opd}}</span></a>

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

																	<span>{{$slaba->judul}}</span>

																</div>

															</div>

														</div>

														<div class="form-group">

									                    	<div class="row">

																<div class="col-sm-4">

																	<label>Status Tiket </label>

																</div>

																<div class="col-sm-8">

																	<!-- <input style="background-color:#ece9bd !important;color:red !important;" type="text" readonly class="form-control" name="id_agen" id="sts" value=""> -->

																	<span>{{$slaba->status_tiket}}</span>

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

											                        <span>{{$slaba->desk}}</span>

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

																	<span>{{$slaba->tgl_pelaporan}}</span>

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

																	<span>{{$slaba->tgl_update}}</span>

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

														{{-- <div class="form-group">

															<div class="row">

																<div class="col-sm-4">

																	<label>Tipe Permintaan </label>

																</div>

																<div class="col-sm-8">

																	<!-- <input type="text" readonly class="form-control" name="tipe_permintaan" id="tp" value="" required> -->

																	<span>{{$slaba->tp}}</span>

																</div>

															</div>

									                    </div> --}}

														<div class="form-group">

															<div class="row">

																<div class="col-sm-4">

																	<label>Jenis Pelayanan </label>

																</div>

																<div class="col-sm-8">

																	<!-- <input type="text" readonly class="form-control" name="jns_pelayanan" id="plynn" value=""> -->

																	<span>{{$slaba->plynn}}</span>

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

														<span id="nm_dpn2"></span>&nbsp;<span>{{$slaba->nama_agen}}</span>

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

								                        <span>{{$slaba->solusi}}</span>

													</div>

												</div>

						                    </div>

						                    <div class="form-group">
						                    	<div class="row">
													<div class="col-sm-4">
														<label>Lampiran </label>
													</div>
													<div class="col-sm-8">
														@if(empty($slaba->lampiran_balasan))
															<i>Not Found</i>
														@else
															<a href="{{url('downloadBalasan')}}/{{$slaba->id_}}" type="button">{{$slaba->lampiran_balasan}}</a>
														@endif
													</div>
												</div>

						                    </div>

						                    

										</div>

									</div>

								</fieldset>


				        	</div>
				        	<form role="form" method="POST" action="{{route('slaba.update', $slaba->id_)}}" enctype="multipart/form-data">
								{!! csrf_field() !!}
								{{ method_field('PUT') }}
								<div class="col-md-12">
									<fieldset class="fieldset-style" style="background: #f9f9f9;">    	
										<legend class="legend-style" style="width:11%;background-color:#e87c1e;color: #fff;border:none;">Berita Acara</legend>
										<div class="panel panel-default" style="background: #f9f9f9;border-color: #fff !important;margin-top: -9px;">
											<div class="panel-body" style="padding: 0px;padding-top: 15px;">
												<div class="form-group">
							                    	{{-- <div class="row" style="margin-bottom: 15px;">
							                    		<div class="col-md-12">
							                    			<div class="row">
							                    				<div class="col-md-2">
																	<b>Service Level Agreement</b>
																</div>
																<div class="col-md-10">
																	@if(!empty($slaba->file_sla))
																		{{$slaba->file_sla}}&nbsp;&nbsp;
																		<button class="btn btn-success"><i class="fa fa-download"></i> <a style="color:#fff !important" href="{{url('downloadSla')}}/{{$slaba->id_}}"" type="button">Download</a></button>
																	@else
																		<i style="color:red">SLA Belum Ada</i>
																	@endif
																	
																</div>		
							                    			</div>	                    			
							                    		</div>
							                    	</div> --}}
							                    	<div class="row" style="margin-bottom: 15px;">
							                    		<div class="col-md-12">
							                    			<div class="row">
							                    				<div class="col-md-2">
																	<b>Berita Acara & Survey Kepuasan</b>
																</div>
																<div class="col-md-10">
																	@if(!empty($slaba->file_ba))
																		{{$slaba->file_ba}}&nbsp;&nbsp;
																		<button class="btn btn-success"><i class="fa fa-download"></i> <a style="color:#fff !important" href="{{url('downloadBA')}}/{{$slaba->id_}}" type="button">Download</a></button>
																	@else
																		<i style="color:red">BA Belum Ada</i>
																	@endif
																</div>		
							                    			</div>	   
							                    		</div>
													</div>
													{{-- <div class="row"  style="margin-bottom: 10px;">
							                    		<div class="col-md-12">
							                    			<div class="row">
							                    				<div class="col-md-2">
																	<b>Balas SLA </b>
																</div>
																<div class="col-md-10">
																	@if(!empty($slaba->sla_bls))
																		{{$slaba->sla_bls}}&nbsp;&nbsp;
																		<button class="btn btn-success"><i class="fa fa-download"></i> <a style="color:#fff !important" href="{{url('downloadSLAReply')}}/{{$slaba->id_}}" type="button">Download</a></button>
																	@else
																		<i style="color:red">Belum ditindak lanjuti</i>
																	@endif
																	<input style="margin-top:5px;" class="form-control" type="file" name="sla_bls">
																</div>		
							                    			</div>	                    			
							                    		</div>
							                    	</div> --}}
							                    	<div class="row">
							                    		<div class="col-md-12">
							                    			<div class="row">
							                    				<div class="col-md-2">
																	<b>Balas BA</b>
																</div>
																<div class="col-md-10">
																	@if(!empty($slaba->ba_bls))
																		{{$slaba->ba_bls}}&nbsp;&nbsp;
																		<button class="btn btn-success"><i class="fa fa-download"></i> <a style="color:#fff !important" href="{{url('downloadBAReply')}}/{{$slaba->id_}}" type="button">Download</a></button>
																	@else
																		<i style="color:red">Belum ditindak lanjuti</i>
																	@endif
																	<input style="margin-top:5px;" class="form-control" type="file" name="ba_bls">
																</div>		
							                    			</div>	   
							                    		</div>
													</div>
							                    </div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-2">
															<label>Rating </label>
														</div>
														@if ($slaba->status_tiket == 'Selesai' )
														<div class="col-md-4">
															@if ($slaba->survey_rate != null)
																@for ($i = 0; $i < $slaba->survey_rate; $i++)
																<span class="fa fa-star checked"></span>
																@endfor
																({{$slaba->survey_rate}} dari 5)
															@else
																<input type="hidden" name="pelayanan_id"
																value="{{ $slaba->id_ }}">
															<select name="rating" id="rating" required>
																<option value="1">
																	&#11088;
																</option>
																<option value="2">&#11088;&#11088;</span>
																</option>
																<option value="3">&#11088;&#11088;&#11088;
																</option>
																<option value="4">
																	&#11088;&#11088;&#11088;&#11088;</option>
																<option value="5" selected>
																	&#11088;&#11088;&#11088;&#11088;&#11088;
																</option>
															</select>
															@endif
														</div>
														@endif
													</div>
												</div>
							                    <div class="form-group">
													<div class="row">
														<div class="col-sm-12">
															<label>Comment Admin : </label>
														</div>
														<div class="col-sm-12">
															@if(!empty($slaba->komen_slaba))
															<textarea style="height:75px" class="form-control" readonly>{{$slaba->komen_slaba}}</textarea>
															@else
															-
															@endif
														</div>
													</div>
												</div>
							                    @if(!empty($slaba->jwb_komen_slaba))
							                    	<div class="form-group">
														<div class="row">
															<div class="col-sm-12">
																<label>Comment Anda : </label>
															</div>
															<div class="col-sm-12">
																<textarea readonly style="height:75px" class="form-control">{{$slaba->jwb_komen_slaba}}</textarea>
															</div>
														</div>
													</div>
							                    @endif
							                    <div class="form-group">
													<div class="row">
														<div class="col-sm-12">
															<label>Balas Comment</label>
														</div>
														<div class="col-sm-12">
															<textarea style="height:70px" name="jwb_komen_slaba" class="form-control"></textarea>
														</div>
													</div>
												</div>
												<div class="row" style="float: right;">

													<div class="col-md-12" style="margin-bottom: -20px;margin-top: -4px;">
														<button type="submit" class="btn btn-primary">Update</button>&nbsp;
														<a href="{{url()->previous()}}" class="btn btn-danger">Kembali</a>
													</div>

												</div>

											</div>
										</div>
									</fieldset>
								</div>
							</form>
				        </div>

				        
		        	</div>
		         </div>
		       

			</div>

		</div>

	</div>

</div>

@endsection

