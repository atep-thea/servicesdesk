@section('pelayanan-link')class="active" @stop
@extends('layout.adminlte.user_portal')

@section('htmlheader_title')
Tiket Baru
@endsection

@section('contentheader_title')
Tiket Baru
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />

@section('additional_scripts')
<script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script>
	function validateSize(input) {
	  const fileSize = input.files[0].size / 1024 / 1024; // in MiB
	  if (fileSize > 8) {
		alert('File yang anda upload lebih dari 8 MB');
		// $(file).val(''); //for clearing with Jquery
	  }
	}
	
	$(document).on('submit', '#form', function(event){
		var surat_dinas = document.getElementById("surat_dinas");
		  var lampiran = document.getElementById('lampiran');
	
		  let surat_dinas_file = surat_dinas.files[0].size; 
		  let lampiran_file = lampiran.files[0].size;
		  
		  if (surat_dinas_file > 8000000) {
			  alert("Ukuran File Surat Dinas Lebih dari 8 MB");
			  event.preventDefault();
		  }
	
		  if (lampiran_file > 8000000) {
			  alert("Ukuran File Lampiran Lebih dari 8 MB");
			  event.preventDefault();
		  }
		});
	</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-12">
		<div class="">
			<div class="box-header bg-title-form">
				<h3 class="box-title">Formulir Tiket Baru</h3>
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
		        
                <form id="form" style="padding:15px;" action="{{route('new_tiket.store')}}" role="form" method="POST" enctype="multipart/form-data">
					{!! csrf_field() !!}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>Layanan</label>
							</div>
							<div class="col-sm-12">
                                <input type="hidden" name="jns_pelayanan" id="jns_pelayanan" value="{{$jns_pelayanan->id_pelayanan}}">
							<select class="form-control" disabled >
                                <option value='{{$jns_pelayanan->id_pelayanan}}'>{{$jns_pelayanan->pelayanan}}</option>
                            </select>
		                    </div>
						</div>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>Perihal </label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="judul" required>
							</div>
						</div>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>PIC dan Nomor Hp. PIC</label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="contact_person" required>
							</div>
						</div>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>Deskripsi </label>
							</div>
							<div class="col-sm-12">
								<textarea name="deskripsi" class="form-control" style="height: 220px" required></textarea>
							</div>
						</div>
                    </div>
					<div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>Surat Dinas </label>
							</div>
							<div class="col-sm-12">
								<input accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*, pdf, .doc, .docx, .xls" onchange="validateSize(this)" style="background: #f9f9f9;padding: 20px;width: 100%;" type="file" name="surat_dinas" id="surat_dinas"><span style="color:#dd4b39;font-size:11px;" >(Maximum File size: 8 MB)</span>
							</div>
						</div>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
						<div class="row">
							<div class="col-sm-12">
								<label>Lampiran </label>
							</div>
							<div class="col-sm-12">
								<input accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*, pdf, .doc, .docx, .xls" onchange="validateSize(this)" style="background: #f9f9f9;padding: 20px;width: 100%;" type="file" name="lampiran" id="lampiran"><span style="color:#dd4b39;font-size:11px;">(Maximum File size: 8 MB)</span>
							</div>
						</div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submitFormBtn" class="btn btn-primary">Kirim</button>
                      </div>
                </div>
            </div>	
      </div>
      
      </form>
    </div>
		       
			</div>
		</div>
	</div>
</div>
@endsection
