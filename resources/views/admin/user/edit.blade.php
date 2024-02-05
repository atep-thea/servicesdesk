@section('user-link')class="active" @stop
@extends('layout.adminlte.app')

@section('htmlheader_title')
    Pengguna
@endsection

@section('contentheader_title')
    Pengguna
@endsection

@section('additional_styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('additional_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
@endsection

@section('main-content')
    <p class="text-red"> <b>Keterangan: (*) Harus diisi</b></p>
    <div class="row">
        <div class="col-md-12">
            <div class="box-header bg-title-form">
                <h3 class="box-title">Ubah Data User</h3>
            </div>

            <div class="box-body border-box">
                @if ($errors)
                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <i class="icon fa fa-warning"></i>
                            {{ $message }}
                        </div>
                    @endforeach
                @endif
                <div class="rows">
                    <div class="col-md-12">
                        <form role="form" method="POST" action="{{ route('user.update', $user->id) }}">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <span class="label label-success label-custom">Data Diri</span>
                            </div>
                            <div class="form-group">
                                <label>Nama Depan <a class="text-red">*</a></label>
                                <input type="text" class="form-control" name="nama_depan" placeholder="Fulan"
                                    value="{{ $user->nama_depan }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Belakang</label>
                                <input type="text" class="form-control" name="nama_belakang"
                                    value="{{ $user->nama_belakang }}" placeholder="Bin Fulan">
                            </div>
                            <div class="form-group">
                                <label>Jabatan <a class="text-red">*</a></label> <br>
                                <select id="id_jabatan" name="id_jabatan" class="form-control js-example-basic-single"
                                    required>
                                    <option value="">- Pilih Jabatan -</option>
                                    @foreach ($jabatan as $datajab)
                                        @if ($datajab->id_jabatan == $user->id_jabatan)
                                            <option value='{{ $datajab->id_jabatan }}' selected>{{ $datajab->jabatan }}
                                            </option>
                                        @else
                                            <option value='{{ $datajab->id_jabatan }}'>{{ $datajab->jabatan }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kewenangan <a class="text-red">*</a></label> <br>
                                <select id="role_user" onchange="teamCheck(this);" name="role_user" class="form-control"
                                    required>
                                    <option value="">- Pilih Kewenangan -</option>
                                    @foreach ($roles as $role)
                                        @if ($role->display_name == $user->role_user)
                                            <option value='{{ $role->display_name }}' selected>
                                                {{ $role->name }}</option>
                                        @else
                                            <option value='{{ $role->display_name }}'>{{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Team <br>
                                    <select name="id_team" class="form-control" required>
                                        <option value="">- Pilih Team -</option>
                                        @foreach ($Team as $datateam)
                                            @if ($datateam->id_team == $user->id_team)
                                                <option value='{{ $datateam->id_team }}' selected>
                                                    {{ $datateam->name_team }}</option>
                                            @else
                                                <option value='{{ $datateam->id_team }}'>{{ $datateam->name_team }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Organisasi</label>
                                <select class="form-control js-example-basic-single" name="id_organisasi">
                                    <option value="">- Pilih Organisasi -</option>
                                    @foreach ($org as $orgdata)
                                        @if ($orgdata->id_organisasi == $user->id_organisasi)
                                            <option value='{{ $orgdata->id_organisasi }}' selected>
                                                {{ $orgdata->nama_opd }}</option>
                                        @else
                                            <option value="{{ $orgdata->id_organisasi }}">{{ $orgdata->nama_opd }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label>Golongan <a class="text-red">*</a> <br>
                                    <select name="golongan_id" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        @foreach ($golongan as $golongan)
                                            @if ($golongan->id == $user->golongan_id)
                                                <option value='{{ $golongan->id }}' selected>
                                                    {{ $golongan->name }}</option>
                                            @else
                                                <option value='{{ $golongan->id }}'>{{ $golongan->name }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                            </div> --}}
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="username">
                            </div>
                            <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" class="form-control" name="phone" placeholder="No HP" value="{{ $user->phone }}">
                            </div>
        
                            <div class="form-group">
                                <label>Kata Sandi </label>
                                <input type="text" class="form-control" name="password" value="{{$user->decrypt_pass}}">
                            </div>
                            <div class="form-group">
                                <label>Status <a class="text-red">*</a></label> <br>
                                  <select id="status" name="status" class="form-control" required>
                                    <option value="">- Pilih Status -</option>
        
                                    @if($user->status != 'Aktif')
                                      <option value="Aktif">Aktif</option>
                                      <option value="Tidak Aktif" selected>Tidak Aktif</option>
                                    @else
                                        <option value="Aktif" selected>Aktif</option>
                                      <option value="Tidak Aktif">Tidak Aktif</option>
                                    @endif
                                 </select>
        
                            </div>
                            {{-- <div class="form-group">
                                  <label>Notifikasi E-mail <a class="text-red">*</a></label> <br>
                                  @if($user->notifikasi != 'Ya')
                                          <input type="radio" name="notifikasi" value="Ya"> Ya<br>
                                          <input type="radio" name="notifikasi" value="Tidak" checked> Tidak<br>
                                  @else
                                      <input type="radio" name="notifikasi" value="Ya" checked> Ya<br>
                                      <input type="radio" name="notifikasi" value="Tidak"> Tidak<br>
                                  @endif
        
                            </div> --}}


                    </div>

                    <br>
                    <div class="rows">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
