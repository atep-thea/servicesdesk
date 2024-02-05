<!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="charity,crowdfunding,nonprofit,orphan,Poor,funding,fundrising,ngo,children,pedulinegeri,peduli,negeri,banjir,tsunami,gempa,bantuan,sumbangan" />
<meta property="fb:app_id" content="711144399052252" />

@if(in_array(Route::currentRouteName(), ['public.blog.show']))
<meta name="title" content="{{ $blog->title }}">
<meta name="description" content="{{ implode(' ', array_slice(explode(' ', strip_tags($blog->post)), 0, 30)) }}" />
<meta name="author" content="{{ $blog->author->name }}" />
@else
<meta name="description" content="Peduli Negeri - Semakin peduli, semakin melayani">
@endif

<!-- Page Title -->
<title>Peduli Negeri - @yield('htmlheader_title')</title>
@yield('additional_styles')
 <style type="text/css">
  .progress{
    height: 24px !important;
  }
  .percent{
    line-height: 15px !important;
    font-size: 15px !important;
    right: -24px !important;
  }
</style>
<!-- Favicon and Touch Icons -->
<link href="{{asset('public/images/favicon.png')}}" rel="shortcut icon" type="image/png">
<link href="{{asset('public/images/apple-touch-icon.png')}}" rel="apple-touch-icon">
<link href="{{asset('public/images/apple-touch-icon-72x72.png')}}" rel="apple-touch-icon" sizes="72x72">
<link href="{{asset('public/images/apple-touch-icon-114x114.png')}}" rel="apple-touch-icon" sizes="114x114">
<link href="{{asset('public/images/apple-touch-icon-144x144.png')}}" rel="apple-touch-icon" sizes="144x144">

<!-- Stylesheet -->
<link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/animate.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('public/css/css-plugin-collections.css')}}" rel="stylesheet"/>
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
<!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
<link href="{{asset('public/css/style.css')}}" rel="stylesheet" type="text/css">

<!-- Revolution Slider 5.x CSS settings -->
<link  href="{{asset('public/js/revolution-slider/css/settings.css')}}" rel="stylesheet" type="text/css"/>
<link  href="{{asset('public/js/revolution-slider/css/layers.css')}}" rel="stylesheet" type="text/css"/>
<link  href="{{asset('public/js/revolution-slider/css/navigation.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('remodal/dist/remodal.css')}}">
<link rel="stylesheet" href="{{asset('remodal/dist/remodal-default-theme.css')}}">

<!-- CSS | Theme Color -->
<link href="{{asset('public/css/colors/theme-skin-rose.css')}}" rel="stylesheet" type="text/css">

 <style>
      @import "{{asset('public/css/elegant-icons.css')}}";
    </style>

<!-- external javascripts -->
<script src="{{asset('public/js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('public/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="{{asset('public/js/jquery-plugin-collection.js')}}"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.revolution.min.js')}}"></script>



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
