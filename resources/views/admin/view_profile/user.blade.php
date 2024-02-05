@section('userhome-link')class="active" @stop

@extends(Auth::user()->role_user == 'User'? 'layout.adminlte.user_portal': 'layout.adminlte.app')

@section('contentheader_title')
@endsection


@section('additional_scripts')
    <script src="{{ asset('adminlte/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src='{{ asset('/plugins/tinymce/tinymce.min.js') }}'></script>
    <script src="{{ asset('js/autocomplete/dist/jquery.autocomplete.min.js') }}"></script>

@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-11" style="margin-left: 45px;">
            <div class="box box-primary">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i>
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form role="form" method="POST" action="" enctype="multipart/form-data">
                    {!! csrf_field() !!} {{ method_field('PUT') }}
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('view-profile.show', $user->IdUser) }}" class="btn btn-success"
                                    style="float:right;margin-right: 31px;width: 150px;">Edit Profile</a>
                            </div>
                        </div>
                        <div class="rows">
                            <div class="col-md-12" style="padding-left: 35px;"><br>
                                <!--  -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php
                                        $fotoProfil = 'public/photos/profile/'.Auth::user()->id.'/' . Auth::user()->foto;
                                        ?>
                                        @if (empty($user->foto))
                                            <img style="width: 100%"
                                                src="{{ asset('public/images/laki.jpg') }}" alt="">
                                        @else
                                            <img style="width: 100%" src="{{ asset($fotoProfil) }}" alt="">
                                        @endif
                                        <div style="background: #fec12b;padding:10px;color:#000;text-align: center;">
                                            <b style="font-size: 14px;">{{ $user->namaDepan }}
                                                {{ $user->namaBelakang }}<br> <i>{{ $user->name }}</i></b>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><i class="zmdi zmdi-account m-r-5"></i><b>Basic
                                                Information</b></div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Nama Depan</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->namaDepan }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Nama Belakang</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->namaBelakang }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>No HP</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->phone }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Email</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->emailUser }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->

                                    {{-- <div class="panel panel-default">
                                        <div class="panel-heading"><i class="zmdi zmdi-account m-r-5"></i><b>Relation
                                                Information</b></div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Jabatan</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->jbt }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Organisasi</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->nama_opd }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><i>Status</i></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        :&nbsp;&nbsp;&nbsp;{{ $user->status }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>


                            </div>
                        </div>
                        <br>
                    </div>
            </div>
        </div>
    </div>
    </form>
@endsection
