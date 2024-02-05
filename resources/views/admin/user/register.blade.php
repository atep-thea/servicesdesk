<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Service Desk </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('public/adminlte/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('public/adminlte/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/adminlte/css/skins/skin-red-light.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset('public/adminlte/plugins/iCheck/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/remodal/dist/remodal.css')}}">
    <link rel="stylesheet" href="{{asset('public/remodal/dist/remodal-default-theme.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/user.css')}}">
    <link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <link rel="stylesheet" href="{{asset('public/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery 2.1.4 -->
	
	<!-- Bootstrap 3.3.2 JS -->
	

	@section('additional_styles')
	<link rel="stylesheet" href="{{asset('public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
	<link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
	<link href="{{asset('public/adminlte/css/select22.min.css')}}" rel="stylesheet" />
	@endsection

	@section('additional_scripts')
	<script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
	<script src="{{asset('public/adminlte/js/select2.full.min.js')}}"></script>
	<script src="{{ asset('public/adminlte/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){ 
			$('#sukses-modal').modal('show');
			$('#warning-modal').modal('show'); 
		}); 
	</script>
	@endsection
</head>


<body>
	<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo" style="position: fixed;background: #009788">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- <span class="logo-mini"><b>S</b>D</span> -->
        <!-- logo for regular state and mobile devices -->
        <!-- <span class="logo-lg" align="center"><img width="50%" src="{{asset('public/images/sd.png')}}"/></span> -->
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #009788; color: #000; border-bottom: 1.5px solid #666;margin-bottom: 22px;padding-right: 35%;
    padding-top: 6px;">
        <!-- Sidebar toggle button-->
    	<!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <img width="50%" src="{{asset('public/images/sd.png')}}"/>
      </div>

    </nav>

    </header>
	
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
    @if(Session::has('warning'))
        <div class="modal fade" id="warning-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="margin-left: 25%;margin-top: 20%;border-radius: 8px">
            <button data-remodal-action="close" class="remodal-close"></button>
              <div class="modal-body" style="text-align: center;padding-top:30px;">
                <div class="row">
                		<p style="margin-bottom: 21px;">
                			<image style="width: 30%" src="{{asset('public/images/warningg.gif')}}"></image>
                		</p>
                		<h2 class="success-alert">
                			Warning!!
                		</h2>
                       <div class="session-alert">
                       		{{ Session::get('warning') }}
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
	<div class="container">
		
		<div class="row">

			<div class="col-md-12">
				<div class="">
					<div class="box-header bg-title-form" style="text-align: left !important;">
						<h3 class="box-title">FORM REGISTRASI</h3>

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
				       <form role="form" method="POST" action="{{route('register_user.store')}}">
				       {!! csrf_field() !!}

						<p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<span class="label label-success label-custom">Data Diri</span>
								</div>
								<div class="form-group">
									<label>Organisasi <a class="text-red">*</a> <br>
				                  	<select name="id_organisasi" class="form-control js-example-basic-single" required>
				                  	  <option value="">- Pilih Organisasi -</option>
							  		  @foreach($org as $dataorg)
									  	<option value='{{$dataorg->id_organisasi}}'>{{$dataorg->nama_opd}}</option>
									  @endforeach
									 </select>
								</div>			
								<div class="form-group">
									<label>Nama Depan <a class="text-red">*</a></label>
									<input type="text" class="form-control" name="nama_depan" placeholder="Fulan" required>
								</div>
								<div class="form-group">
									<label>Nama Belakang</label>
									<input type="text" class="form-control" name="nama_belakang" placeholder="Bin Fulan">
								</div>
								<div class="form-group">
									<label>Jenis Kelamin</label> <br>
				                  	<select name="jns_kelamin" class="form-control js-example-basic-single">
				                  	  <option value="">- Pilih Jenis Kelamin -</option>
				                  	  <option value="1">Laki-laki</option>
				                  	  <option value="2">Perempuan</option>
									 </select>
								</div>
								<div class="form-group">
									<label>Jabatan</label> <br>
				                  	<select id="id_jabatan" name="id_jabatan" class="form-control js-example-basic-single">

				                  	  <option value="">- Pilih Jabatan -</option>
				                  	  @foreach($jabatan as $datajab)
									  	<option value='{{$datajab->id_jabatan}}'>{{$datajab->jabatan}}</option>
									  @endforeach
									 </select>
								</div>
								
								<div class="form-group">
									<label>No HP</label>
									<input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ old('phone') }}">
								</div>	
								<!-- <div class="form-group">
									<label>Photo</label> <br>
				                  	<input type="file" name="photo">
								</div> -->
								

							</div>
							<div class="col-md-4">
								<div class="form-group">
									<span class="label label-success label-custom">User Login</span>
								</div>
									<div class="form-group">
										<label>Email </label>
										<input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
									</div>
									
									<div class="form-group">
										<label>Username</label>
										<input type="text" class="form-control" name="name" placeholder="username">
									</div>
									
									

									<div class="form-group">
										<label>Kata Sandi </label>
										<input type="password" class="form-control" name="password" placeholder="Password">
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
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
	
</body>


</html>


