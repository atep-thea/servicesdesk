@section('organisasi-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
Software
@endsection

@section('contentheader_title')
Software
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
				<h3 class="box-title">Detail Software</h3>
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
		        <form role="form" method="POST" action="{{route('perangkat_lunak.update',$software->id_perangkat)}}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}                        
				<div class="row top-22">
					<div class="col-md-8">
						<div class="form-group">
							<label>Jenis Perangkat Keras</label>
							 <select class="form-control" name="id_jns_perangkat" readonly>
							   <option value="">- Pilih Perangkat Keras -</option>
							   @foreach($jnsPerangkat as $jnsPerangkatData)
				                @if ($jnsPerangkatData->id_jns_perangkat == $software->jns_perangkat )
									<option value='{{ $jnsPerangkatData->id_jns_perangkat }}' selected>{{ $jnsPerangkatData->nama_jns_perangkat }}</option>
								@else
									<option value="{{$jnsPerangkatData->id_jns_perangkat}}">{{$jnsPerangkatData->nama_jns_perangkat}}</option>
								@endif
				               @endforeach
	                        </select>
						</div>
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $software->nama_perangkat}}" readonly>
						</div>
						<div class="form-group">
							<label>Merek </label>
							<input type="text" class="form-control" name="merek" value="{{ $software->merek}}" placeholder="merek" readonly>
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ $software->model}}" placeholder="model" readonly>
						</div>
						<div class="form-group">
							<label>Perangkat Daerah</label>
							 <select class="form-control" name="id_organisasi" readonly>
							   <option value="">- Pilih Organisasi -</option>
							   @foreach($org as $orgdata)
				                @if ($orgdata->id_organisasi == $software->id_organisasi )
									<option value='{{ $orgdata->id_organisasi }}' selected>{{ $orgdata->nama_opd }}</option>
								@else
									<option value="{{$orgdata->id_organisasi}}">{{$orgdata->nama_opd}}</option>
								@endif
				               @endforeach
	                        </select>
						</div>
	                    <div class="form-group">
							<label>Phone</label>
							<input type="number" class="form-control" name="phone" placeholder="No HP" value="{{ $software->phone}}" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tanggal Pembelian</label>
							<input type="text" class="form-control datepicker dateStart" name="tgl_pembelian" value="{{ $software->tgl_pembelian}}" readonly>
						</div>
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="aset_number" value="{{ $software->aset_number}}" placeholder="aset nomer" readonly>
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="serial_number" value="{{ $software->serial_number}}" placeholder="serial number" readonly>
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                        <select class="form-control" name="id_status" readonly>
	                            <option value="">- Pilih Status -</option>
	                        	 @foreach($status as $statusData)
					                @if($statusData->id_status == $software->status )
										<option value='{{ $statusData->id_status }}' selected>{{ $statusData->status_name }}</option>
									@else
										<option value="{{$statusData->id_status}}">{{$statusData->status_name}}</option>
									@endif
				               	 @endforeach
	                        </select>
	                    </div>	
						<div class="form-group">
	                        <label>Keterangan </label>
	                        <textarea name="deskripsi" class="form-control" readonly>{{$software->deskripsi}}</textarea>
	                    </div>
	            </div>
				</div>
				<hr class="border-hr">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary">Save</button>&nbsp;
						<a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
					</div>
				</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection


<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 1000px;margin-left: -148px;">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
      		 <form role="form" method="POST" action="{{route('perangkat_lunak.update',$software->id_perangkat)}}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}                        
				<div class="row top-22">
					<div class="col-md-8">
						<div class="form-group">
							<label>Jenis Perangkat Keras</label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $software->jns_perangkat}}" required>
						</div>
						<div class="form-group">
							<label>Nama Perangkat <a class="text-red">*</a></label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $software->nama_perangkat}}" required>
						</div>
						<div class="form-group">
							<label>Merek </label>
							<input type="text" class="form-control" name="merek" value="{{ $software->merek}}" placeholder="merek">
						</div>
						<div class="form-group">
							<label>Model/Type</label>
							<input type="text" class="form-control" name="model" value="{{ $software->model}}" placeholder="model">
						</div>
						<div class="form-group">
							<label>Perangkat Daerah</label>
							<input type="text" class="form-control" name="nama_perangkat" value="{{ $software->id_organisasi}}" required>
						</div>
	                    <div class="form-group">
							<label>Phone</label>
							<input type="number" class="form-control" name="phone" placeholder="No HP" value="{{ $software->phone}}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tanggal Pembelian</label>
							<input type="text" class="form-control datepicker dateStart" name="tgl_pembelian" value="{{ $software->tgl_pembelian}}">
						</div>
						<div class="form-group">
							<label>Aset Nomer</label>
							<input type="text" class="form-control" name="aset_number" value="{{ $software->aset_number}}" placeholder="aset nomer">
						</div>
						<div class="form-group">
							<label>Serial Nomer</label>
							<input type="text" class="form-control" name="serial_number" value="{{ $software->serial_number}}" placeholder="serial number">
						</div>
						<div class="form-group">
	                        <label>Status <a class="text-red">*</a></label>
	                       <input type="text" class="form-control" name="status" value="{{ $software->status}}">
	                    </div>	
						<div class="form-group">
	                        <label>Keterangan </label>
	                        <textarea name="deskripsi" class="form-control">{{$software->deskripsi}}</textarea>
	                    </div>
					</div>
				</div>
				</div>
				<hr class="border-hr">
				<div class="row">
					<div class="col-md-12">
						<a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>
					</div>
				</div>
					
				</form>
      </div>
  </div>
</div>
</div>
 -->