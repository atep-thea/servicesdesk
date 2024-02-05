@extends('layout.adminlte.auth')



@section('htmlheader_title')

    Log in

@endsection



@section('content')

<script src="{{ asset('public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

<body class="login-page">

    <div class="login-box shadow_login">



    @if (count($errors) > 0)

        <script> $(document).ready(function(){ $('#error-modal').modal('show'); }); </script>

        <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content" style="margin-left: 25%;margin-top: 20%;width: 50%;">

              <div class="modal-header" style="background-color:red;color:#fff;">

                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;&nbsp;<strong>Whoops!</strong> Ada kesalahan..</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="row">

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                </div>

                

                

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>

    @endif



    <div class="login-box-body bg-formlogin" style="">

        <center style="margin-bottom: 20px;">

            <img src="{{asset('public/images/itop-logo-external.png')}}"/>

        </center>

        <center style="margin-bottom: 12px;">

            <p></p><p>&nbsp;</p>

        </center>

        <br><br>

        <form action="{{ url('login') }}" method="post" autocomplete="off">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group has-feedback">

                <input style="border: 1.5px solid #24a958;" type="text" class="form-control" placeholder="Username" name="name"/>

                <span class="glyphicon glyphicon-user form-control-feedback"></span>

            </div>

            <div class="form-group has-feedback">

                <input style="border: 1.5px solid #24a958;" type="password" class="form-control" placeholder="Password" name="password"/>

                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            </div>

            <div class="row">

                <div class="col-xs-12">

                    <button type="submit" class="btn btn-block btn-flat" style="background-color:#46b06b;font-size:17px;color:#fff !important;">Login</button>

                </div>

            </div>

        </form>



    </div><!-- /.login-box-body -->



</div><!-- /.login-box -->



    @include('layout.adminlte.auth.scripts')



    <script>

        $(function () {

            $('input').iCheck({

                checkboxClass: 'icheckbox_square-blue',

                radioClass: 'iradio_square-blue',

                increaseArea: '20%' // optional

            });

        });

    </script>

</body>



@endsection

