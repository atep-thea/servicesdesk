@section('link-home')class="active" @stop
@extends('layouts.footer')
@extends('layouts.header')

@section('content')
    <!-- Section: home -->
    <section id="home" class="divider bg-lighter">
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-md-push-3">
                <div class="text-center mb-60"><a href="{{url('/')}}" class=""><h1 style="font-family: 'Open Sans', sans-serif;">Peduli Negeri</h1></a></div>
                <h4 class="text-theme-colored mt-0 pt-5"> Login</h4>
                <div class="icon-box mb-0 p-0">
                  <a href="#" class="icon icon-bordered icon-rounded icon-sm pull-left mb-0 mr-10">
                    <i class="pe-7s-users"></i>
                  </a>
                  <h4 class="text-gray pt-10 mt-0 mb-30"><a href="{{asset('register')}}">Don't have an Account? Register Now.</a></h4>
                </div>
                @if(Session::has('failed'))
                              <div class="alert alert-danger alert-dismissable">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  {{ Session::get('failed') }}
                              </div>
              @endif
                
                <form name="login-form" class="clearfix" method="POST" action="{{ url('store-login') }}">
                    {!! csrf_field() !!}
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="form_username_email">Email</label>
                      <input id="email" name="email" class="form-control" type="email" required autofocus>
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="form_password">Password</label>
                      <input id="form_password" name="password" class="form-control" type="password" required>

                       @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                  <div class="checkbox pull-left mt-15">
                    <label for="form_checkbox">
                      <input id="form_checkbox" name="remember" type="checkbox">
                      Remember me </label>
                  </div>
                  <div class="form-group pull-right mt-10">
                  <a class="text-theme-colored font-weight-600 font-12" href="#">Forgot Your Password?</a>
                  <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                  </div>
                  <div class="clear text-center pt-10">
                  </div>
                  <br>
                  <div class="clear text-center pt-10">
                    <button type="submit" class="btn btn-dark btn-lg btn-block no-border mt-15 mb-15 btn btn-dark" href="#">Logins</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection