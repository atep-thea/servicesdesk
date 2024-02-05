@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<div class="container">
    <div>
        <section id="home" class="divider">
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-md-push-3">
                <div class="text-center mb-60">
                    <h1>Peduli Negeri</h1>
                </div>
                <form name="reg-form" class="register-form" method="POST" action="{{ route('register') }}">
                  {{ csrf_field() }}
                  <hr>
                  <div class="row">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                      <label>Nama</label>
                      <input id="nama" name="nama" class="form-control" type="text" required autofocus placeholder="Nama Lengkap">
                      @if ($errors->has('name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
                      <label>Nomor HP</label>
                      <input id="phone" name="phone" class="form-control" type="text" placeholder="08xxxxxx" required>
                      @if ($errors->has('phone'))
                          <span class="help-block">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                      <label for="form_choose_email">Email</label>
                      <input id="email" name="email" class="form-control" type="email" placeholder="Alamat Email" required>
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="password">Password</label>
                      <input id="password" name="password" class="form-control" type="password" placeholder="Password" required>
                       @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="form-group col-md-6">
                      <label>Re-enter Password</label>
                      <input id="password_confirmation" name="password_confirmation"  class="form-control" type="password" placeholder="Ulangi Password" required>
                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-6">
                      <label>Daftar Sebagai</label>
                      <div class="radio" style="margin-bottom: -15px">
                          <label>
                            <input type="radio" name="role" value="donator" checked="true"> Donatur
                          </label>
                          &nbsp;&nbsp;
                          <label>
                            <input type="radio" name="role" value="relawan"> Relawan
                          </label>
                      </div>
                    </div>
                      
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-block mt-15" type="submit">DAFTAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>
    
</div>
@endsection
