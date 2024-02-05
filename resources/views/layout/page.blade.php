<!DOCTYPE html>
<html dir="ltr" lang="en">

@include('layout.partials.htmlheader')

<body class="">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=162697517545627";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="wrapper" class="clearfix">
  <!-- preloader -->

  @include('layout.partials.mainheader')

  <!-- Start main-content -->
  <div class="main-content">
    <!-- Section: inner-header image size : 1920x1280 -->
    @if(!in_array(Route::currentRouteName(), ['public.blog.show']))
      <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="@yield('header-image-url')">
        <div class="container pt-100 pb-50">
          <!-- Section Content -->
          <div class="section-content pt-100">
            <div class="row">
              <div class="col-md-12">
                <h3 class="title text-white">@yield('title')</h3>
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif
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
