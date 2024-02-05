@section('userhome-link')class="active" @stop
@extends(Auth::user()->role_user == 'User'? 'layout.adminlte.user_portal': 'layout.adminlte.app')


@section('contentheader_title')
@endsection


@section('additional_scripts')
<script src="{{asset('adminlte/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{asset('/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src='{{asset('/plugins/tinymce/tinymce.min.js')}}'></script>
<script src="{{asset('js/autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
<script type="text/javascript">
  $('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Password Cocok').css('color', 'green');
  }else if ($('#confirm_password').val() == ''){
    $('#message').html('Konfirmasi Password').css('color', 'red');
  } else 
    $('#message').html('Password Tidak Cocok').css('color', 'red');
});


foto.onchange = evt => {
  const [file] = foto.files
  if (file) {
    profile_pic.src = URL.createObjectURL(file)
  }
}
</script>
@endsection

@section('main-content')
<div class="row">
	<div class="col-md-11" style="margin-left: 45px;">
		<div class="box box-primary">
      <form role="form" method="POST" action="{{route('view-profile.update',$user->IdUser)}}" enctype="multipart/form-data">
            {!! csrf_field() !!} {{ method_field('PUT') }}
			<div class="box-body">
        <div>
          
        </div>
        <hr>
				<div class="rows">
  				<div class="col-md-12" style="padding-left: 35px;"><br>
            <!--  -->
            <div class="col-md-3">
              <div class="form-group">
                <?php 
                    $fotoProfil = 'public/photos/profile/'.Auth::user()->id.'/'.Auth::user()->foto;
                ?>
                @if(empty($user->foto))
                  <img id="profile_pic" style="width: 100%" src="{{asset('public/images/laki.jpg')}}" alt="">
                @else
                  <img id="profile_pic" style="width: 100%" src="{{asset($fotoProfil)}}" alt="">
                @endif
                <div style="background: #fec12b;padding:10px;color:#000;text-align: center;">
                    <b style="font-size: 14px;">{{ $user->namaDepan }} {{ $user->namaBelakang }}<br> <i>{{ $user->display_name }}</i></b>
                </div>
                <div class="form-group">
                  <label for="foto">Upload Foto</label>
                  <input type="file" id="foto" name="foto">
                </div>
                        <br><br>
              </div>
            </div>
            <div class="col-md-9">
              <div class="panel panel-default">
                <div class="panel-heading"><i class="zmdi zmdi-account m-r-5"></i><b>Basic Information</b></div>
                <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Nama Depan</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" type="text" name="nama_depan" value="{{$user->namaDepan}}">
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Nama Belakang</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" type="text" name="nama_belakang" value="{{$user->namaBelakang}}">
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>No HP</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" type="text" name="phone" value="{{$user->phone}}">
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Email</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" type="text" name="email" value="{{$user->emailUser}}">
                      </div>
                    </div>  
                  </div>
                  {{-- <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Organisasi</i></label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-control js-example-basic-single" name="org">
                          <option value="">- Pilih Organisasi -</option>
                          @foreach($org as $dataorg)
                              @if ($dataorg->id_organisasi == $user->idOrg )
                                <option value="{{ $dataorg->id_organisasi }}" selected>{{ $dataorg->nama_opd }}</option>
                              @else
                                <option value="{{ $dataorg->id_organisasi}}">{{$dataorg->nama_opd}}</option>
                              @endif
                         @endforeach
                        </select>
                       
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Jabatan</i></label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-control js-example-basic-single" name="jbt">
                          <option value="">- Pilih Jabatan -</option>
                          @foreach($jabatan as $dataJbt)
                              @if ($dataJbt->id_jabatan == $user->idJbt )
                                <option value="{{ $dataJbt->id_jabatan }}" selected>{{ $dataJbt->jabatan }}</option>
                              @else
                                <option value="{{ $dataJbt->id_jabatan}}">{{$dataJbt->jabatan}}</option>
                              @endif
                         @endforeach
                        </select>
                      </div>
                    </div>  
                  </div> --}}
                </div>
              </div>
              <!--  -->

              <div class="panel panel-default">
                <div class="panel-heading"><i class="zmdi zmdi-account m-r-5"></i><b>User Login</b></div>
                <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Username</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" type="text" name="name" value="{{$user->userName}}">
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Password</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" id="password" type="password" name="password" value="">
                      </div>
                    </div>  
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label><i>Confirm Password</i></label>
                      </div>
                      <div class="col-md-8">
                        <input class="form-control" id="confirm_password" type="password" value="">
                        <span id='message'></span>
                      </div>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
  				</div>
				</div>
				<br>
        <hr class="border-hr">
        <div class="row" style="text-align: right">

          <div class="col-md-12">

            <button type="submit" class="btn btn-primary">Update</button>&nbsp;

            <a href="{{url()->previous()}}" class="btn btn-danger">Cancel</a>

          </div>

        </div>
			</div>
		</div>
	</div>
</div>
</form>
@endsection
