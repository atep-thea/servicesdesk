<!DOCTYPE html>
<html dir="ltr" lang="en">

@include('layout.partials.htmlheader')

<body class="">
<div id="wrapper" class="clearfix">
  <!-- preloader -->
  
  
  <!-- Start main-content -->
  <div class="main-content">
    @yield('main-content')
  </div>
  <!-- end main-content -->
  
  <!-- Footer -->
  @include('layout.partials.footer')
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper -->

@include('layout.partials.script')
</body>
</html>