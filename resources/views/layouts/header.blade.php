<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="charity,crowdfunding,nonprofit,orphan,Poor,funding,fundrising,ngo,children,pedulinegeri,peduli,negeri,banjir,tsunami,gempa,bantuan,sumbangan" />
<meta name="author" content="ThemeMascot" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Page Title -->

@if(in_array(Route::currentRouteName(), ['blog.show']))
<meta name="title" content="{{ $blog->title }}">
<meta name="description" content="{{ implode(' ', array_slice(explode(' ', strip_tags($blog->post)), 0, 30)) }}" />
<meta name="author" content="{{ $blog->author->name }}" />
@else
<meta name="description" content="Peduli Negeri - Semakin peduli, semakin melayani">
@endif

<title>Peduli Negeri</title>

<!-- Favicon and Touch Icons -->
<link href="{{asset('public/images/favicon.png')}}" rel="shortcut icon" type="image/png">
<link href="{{asset('public/images/apple-touch-icon.png')}}" rel="apple-touch-icon">
<link href="{{asset('public/images/apple-touch-icon-72x72.png')}}" rel="apple-touch-icon" sizes="72x72">
<link href="{{asset('public/images/apple-touch-icon-114x114.png')}}" rel="apple-touch-icon" sizes="114x114">
<link href="{{asset('public/images/apple-touch-icon-144x144.png')}}" rel="apple-touch-icon" sizes="144x144">

<!-- Stylesheet -->
<link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/wizard_form.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/animate.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/css-plugin-collections.css')}}" rel="stylesheet"/>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!-- CSS | menuzord megamenu skins -->
<link id="menuzord-menu-skins" href="{{asset('public/css/menuzord-skins/menuzord-rounded-boxed.css')}}" rel="stylesheet"/>
<!-- CSS | Main style file -->
<link href="{{asset('public/css/style-main.css')}}" rel="stylesheet" type="text/css">
<!-- CSS | Preloader Styles -->
<link href="{{asset('public/css/preloader.css')}}" rel="stylesheet" type="text/css">
<!-- CSS | Custom Margin Padding Collection -->
<link href="{{asset('public/css/custom-bootstrap-margin-padding.css')}}" rel="stylesheet" type="text/css">
<!-- CSS | Responsive media queries -->
<link href="{{asset('public/css/responsive.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/style.css')}}" rel="stylesheet" type="text/css">

<link  href="{{asset('public/js/revolution-slider/css/settings.css')}}" rel="stylesheet" type="text/css"/>
<link  href="{{asset('public/js/revolution-slider/css/layers.css')}}" rel="stylesheet" type="text/css"/>
<link  href="{{asset('public/js/revolution-slider/css/navigation.css')}}" rel="stylesheet" type="text/css"/>

<!-- CSS | Theme Color -->
<link href="{{asset('public/css/colors/theme-skin-red.css')}}" rel="stylesheet" type="text/css">

<!-- external javascripts -->
<script type="text/javascript">
  function pdSearch() {
    $('#pd-search-box').show('slow');
    $('#menuzord-right').hide('slow');
  }
  $('html').click(function() {
    $('#pd-search-box').hide('slow');
    $('#menuzord-right').show('slow');
  })
 $('#pd-container').click(function(e){
    e.stopPropagation();
 });
</script>
<script src="{{asset('public/js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('public/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/wizard_form.js')}}"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="{{asset('public/js/jquery-plugin-collection.js')}}"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.revolution.min.js')}}"></script>

</head>
<body class="">
<div id="wrapper" class="clearfix">
  <!-- preloader -->
  <div id="preloader">
    <div id="spinner">
      <img class="floating" width="300" src="{{asset('public/images/logopedulinegeri.png')}}" alt="">
      <h5 class="line-height-50 font-18 ml-15">Loading...</h5>
    </div>
    <div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>
  </div>
  
  <!-- Header -->
  <header id="header" class="header">
    <div class="header-nav navbar-fixed-top header-dark navbar-white navbar-transparent bg-transparent-1 navbar-sticky-animated animated-active">
      <div class="header-nav-wrapper">
        <div class="container">
          <nav id="menuzord-right" class="menuzord default no-bg">
            <a class="menuzord-brand pull-left flip" href="/"><img src="{{asset('public/images/logopedulinegeri.png')}}" alt=""></a>
            <ul class="menuzord-menu">
              <li @yield('link-home')><a href="{{ url('/') }}">Beranda</a>
              </li>
              <li @yield('link-about')><a href="{{ url('tentang-kami') }}">Tentang</a>
              </li>
              <li @yield('link-program')><a href="{{ url('program') }}">Program</a>
              </li>
              <li @yield('link-donasi')><a href="#">Donasi</a>
                <ul class="dropdown">
                  <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Zakat</a>
                  </li>
                  <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Infaq</a>
                  </li>
                  <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Fidyah</a>
                  </li>
                  <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Wakaf</a>
                  </li>
                </ul>
              </li>
              @if(!Auth::user())
              <li @yield('link-login')>
                <a href="#">Masuk</a>
                <ul class="dropdown">
                  <li><a href="{{ url('login-donatur') }}">Donatur</a></li>
                  <li><a href="{{ url('login') }}">Galang Dana</a></li>
                </ul>
              </li>
              <li @yield('link-register')>
                <a href="{{url('register')}}">Daftar</a>
              </li>
              @else
              @if (Auth::check())
              <li @yield('link-profile')>
                <a href="{{url('profile')}}">{{Auth::user()->firstName()}}</a>
              </li>
              @endif
              <li @yield('link-logout')>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="icon-key"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </li>
              @endif
              <li>
                <a href="#" onclick="pdSearch()"><i class="fa fa-search fa-2x"></i></a>
              </li>
            </ul>
          </nav>
          <div class="pd-search" id="pd-search-box" style="display: none;">
            <div class="pd-label"> <b>Cari Program </b></div>
            <form action="{{ url('program') }}" method="GET">
                <input type="text" placeholder="Click to Search" name="q" class="form-control search-input">
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>
   <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b85f74bf31d0f771d843b67/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();

</script>
<!--End of Tawk.to Script-->
  <!-- Start main-content -->
  <div class="main-content">
  @yield('content')