@section('link-home')class="active" @stop
@extends('layouts.header')
@section('content')
    <!-- Section: home -->
    <style type="text/css">
    @media only screen and (max-width: 600px) {
     #event > #prog_utama{
       padding-top: 0px !important;
      }

      .rev_slider_wrapper .rev_slider ul{
       
        height: 320px !important;
      }

      .rev_slider_wrapper .rev_slider ul li .tp-parallax-wrap div div div {
       
        font-size: 14px !important;
        height: 20% !important;
        padding-top: 9px !important;
        /*display: none;*/
      }

       .rev_slider_wrapper .rev_slider ul li .tp-parallax-wrap div div div a {
       
        margin-top: 60px !important;
        margin: 45px -11px 0px !important;
        padding: 8px 13px !important;
        font-size: 9px !important;
        /*display: none;*/
      }

      .rev_slider_wrapper .rev_slider ul li .tp-parallax-wrap div div div span {
        display: none;
      }


      .rev_slider_wrapper .rev_slider ul li .tp-parallax-wrap{
        top: 100px !important;
      }

      .statistik{
        height: 100% !important;
      }

      /*.rev_slider_wrapper .rev_slider ul li div div{
        background-size: 95% !important;

      }*/

      section .container-fluid div{
        height: 210px !important; 
      }
    }
    </style>
    <section id="home">
      <div class="container-fluid p-0">
        <!--  Revolution slider scriopt -->
        @include('layout.partials.slider')
      </div>
    </section>
    

    <!-- Section: Our Mission & Upcoming Events -->
    <section id="event">
      <div class="container" id="prog_utama">
        <div class="section-content">
          <div class="row">
            <div class="col-md-12">
              <div class="section-title text-center">
                <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                    <h3 class="text-uppercase title  mt-0 mb-30 mt-sm-40" ><i class="fa fa-thumb-tack text-gray-darkgray mr-10"></i>PROGRAM <span class="text-theme-colored line-bottom">UTAMA</span></h3>
                  </div>
                </div>
              </div>
              
              <div class="row">
                @foreach($latest_campaigns2 as $last_program)
                <div class="col-md-3">
                  <div class="causes bg-white maxwidth500 mb-sm-30">
                    <div class="thumb">
                       <a href="{{ route('donation.form', $last_program->slug) }}"><img width="100%" height="240" src="{{asset('photos/campaign/'.$last_program->feature_image_url)}}" alt="">
                       </a>
                      <div class="overlay-donate-now">
                        <a href="{{ route('donation.form', $last_program->slug) }}" class="btn btn-dark btn-theme-colored btn-flat btn-sm pull-left mt-10">Beri Donasi <i class="flaticon-charity-make-a-donation font-16 ml-5"></i></a>
                      </div>
                    </div>
                    <div class="progress-item mt-0">
                      <div class="progress mb-0">
                        <div data-percent="{{ $last_program->progress}}" class="progress-bar"><span class="percent">{{ $last_program->progress}}%</span></div>
                      </div>
                    </div>
                    <div class="causes-details clearfix border-bottom p-15 pt-10 pb-10">
                  <h5 class="font-weight-600 font-16" style="min-height: 57px"><a href="{{ route('public.program.show', $last_program->slug) }}">{{$last_program->title}}</a></h5>
                  <!-- <p>{!! str_limit($last_program->banner_description, 150, "...") !!}</p> -->
                  <div style="display: flex;flex-direction:row;align-items: center;justify-content: flex-start;">
                      @if ( $last_program->advertiser)
                      <p >{{ $last_program->advertiser }}</p>
                        @if ( $last_program->advertiser_type=="yayasan")
                          <img src="{{asset('public/images/DT_ORG.png')}}" style="height: 15px;width:50px;margin-left:10px;margin-top: -8px">
                        @else
                          <img src="{{asset('public/images/DT_PERSON.png')}}" style="height: 15px;width:70px;margin-left:10px;margin-top: -8px">
                        @endif
                      @else
                        <p>Relawan Peduli</p>
                      @endif
                    </div>
                    <?php 
                    	$ulasan = substr($last_program->post, 0, 120) . '...';
                    	$summary = strip_tags($ulasan);
                     ?>
                    <p>{{ $summary }}</p>
                   <div style="width: 100%;height: 5px;background-color: #8080803d;border-radius: 3px;"></div>
                  <ul class="list-inline font-weight-600 clearfix pt-10">
                    <li class="pull-left pr-0">Sisa Hari: {{$last_program->remaining}}</li><br>
                    <li class="text-theme-colored pull-left pr-0">Terkumpul: Rp.{{ number_format($last_program->total_donation, 2, ",", ".")}}</li>
                  </ul>
                  </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- gwq -->
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Causes -->
    <section id="event" class="bg-lighter" style="margin-bottom: -20px">
      <div class="container">
        <div class="section-content">
          <div class="row">
            <div class="col-md-12">
              <div class="section-title text-center">
                <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                    <h2 class="text-uppercase title  mt-0 mb-30 mt-sm-40" ><i class="fa fa-globe text-gray-darkgray mr-10"></i>PROGRAM <span class="text-theme-colored line-bottom">PILIHAN</span></h2>
                  </div>
                </div>
              </div>
              <div class="row">
                @foreach($campaigns as $campaign)
                <div class="col-md-3 mb-30">
                  <div class="causes bg-white maxwidth500 mb-sm-30">
                    <div class="thumb">
                       <a href="{{ route('donation.form', $campaign->slug) }}"><img width="320" height="240" src="{{asset('photos/campaign/'.$campaign->feature_image_url)}}" alt="" class="img-fullwidth">
                       </a>
                      <div class="overlay-donate-now">
                        <a href="{{ route('donation.form', $campaign->slug) }}" class="btn btn-dark btn-theme-colored btn-flat btn-sm pull-left mt-10">Beri Donasi <i class="flaticon-charity-make-a-donation font-16 ml-5"></i></a>
                      </div>
                    </div>
                    <div class="progress-item mt-0">
                      <div class="progress mb-0">
                        <div data-percent="{{ $campaign->progress}}" class="progress-bar"><span class="percent">{{ $campaign->progress}}%</span></div>
                      </div>
                    </div>
                    <div class="causes-details clearfix border-bottom p-15 pt-10 pb-30">
                  <h5 class="font-weight-600 font-16" style="min-height: 60px"><a href="{{ route('public.program.show', $campaign->slug) }}">
                  	{{$campaign->title}}</a></h5>
                  <!-- <p>{!! str_limit($campaign->banner_description, 150, "...") !!}</p> -->
                  
                  <div style="display: flex;flex-direction:row;align-items: center;justify-content: flex-start;">
                      @if ( $campaign->advertiser)
                      <p >{{ $campaign->advertiser }}</p>
                        @if ( $campaign->advertiser_type=="yayasan")
                          <img src="{{asset('public/images/DT_ORG.png')}}" style="height: 15px;width:50px;margin-left:10px;margin-top: -8px">
                        @else
                          <img src="{{asset('public/images/DT_PERSON.png')}}" style="height: 15px;width:70px;margin-left:10px;margin-top: -8px">
                        @endif
                      @else
                        <p>Relawan Peduli</p>
                      @endif
                    </div>
                    <div style="width: 100%;height: 5px;background-color: #8080803d;border-radius: 3px;"></div>
                  <ul class="list-inline font-weight-600 clearfix pt-10">
                    <li class="pr-0">Sisa Hari: {{$campaign->remaining}}</li><br>
                    <li class="text-theme-colored pr-0">Terkumpul: Rp.{{ number_format($campaign->total_donation, 0, ",", ".")}}</li>
                  </ul>
                </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- gwq -->
          </div>
        </div>
      </div>
    </section>

 

    <!-- Section: DonetForm & Testimonials -->
     

    <!-- Divider: Funfact -->
    <section id="statistik" class="divider layer-overlay overlay-theme-colored-9" data-parallax-ratio="0.7">
      <div class="container pt-40 pb-40">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-4 mb-md-50">
            <div class="funfact text-center">
              <i class="pe-7s-smile mt-5 text-white"></i>
              <!-- <h2 data-animation-duration="2000" data-value="{{ $total_campaigns }}" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2> -->
              <h2 data-animation-duration="2000" data-value="126" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
              <h5 class="text-white text-uppercase font-weight-600">Jumlah Program</h5>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-4 mb-md-50">
            <div class="funfact text-center">
              <i class="pe-7s-rocket mt-5 text-white"></i>
              <!-- <h2 data-animation-duration="2000" data-value="{{ $total_donations }}" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2> -->
              <h2 data-animation-duration="2000" data-value="5068576000" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
              <h5 class="text-white text-uppercase font-weight-600">Donasi Terkumpul</h5>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-4 mb-md-50">
            <div class="funfact text-center">
              <i class="pe-7s-add-user mt-5 text-white"></i>
              <h2 data-animation-duration="2000" data-value="1980" class="animate-number text-white font-42 font-weight-500 mt-0 mb-0">0</h2>
              <h5 class="text-white text-uppercase font-weight-600">Donatur</h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="layer-overlay overlay-white-9" data-bg-img="http://placehold.it/1920x1280">
      <div class="container pb-10">
        <div class="section-content">
          <div class="row">
            {{-- <div class="col-xs-12 col-sm-6 col-md-6">
              <h3 class="text-uppercase title line-bottom mt-0 mb-30"><i class="fa fa-cc-mastercard text-theme-colored mr-10"></i>BUAT DONASI  <span class="text-theme-colored">SEKARANG!</span></h3>

              <!-- ===== START: Paypal Both Onetime/Recurring Form ===== -->
              <form id="paypal_donate_form_onetime_recurring">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group mb-20">
                      <label><strong>Payment Type</strong></label> <br>
                      <label class="radio-inline">
                        <input type="radio" checked="" value="one_time" name="payment_type"> 
                        One Time
                      </label>
                      <label class="radio-inline">
                        <input type="radio" value="recurring" name="payment_type"> 
                        Recurring
                      </label>
                    </div>
                  </div>

                  <div class="col-sm-12" id="donation_type_choice">
                    <div class="form-group mb-20">
                      <label><strong>Donation Type</strong></label>
                      <div class="radio mt-5">
                        <label class="radio-inline">
                          <input type="radio" value="D" name="t3" checked="">
                          Daily</label>
                        <label class="radio-inline">
                          <input type="radio" value="W" name="t3">
                          Weekly</label>
                        <label class="radio-inline">
                          <input type="radio" value="M" name="t3">
                          Monthly</label>
                        <label class="radio-inline">
                          <input type="radio" value="Y" name="t3">
                          Yearly</label>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group mb-20">
                      <label><strong>I Want to Donate for</strong></label>
                      <select name="item_name" class="form-control">
                        <option value="Educate Children">Educate Children</option>
                        <option value="Child Camps">Child Camps</option>
                        <option value="Clean Water for Life">Clean Water for Life</option>
                        <option value="Campaign for Child Poverty">Campaign for Child Poverty</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group mb-20">
                      <label><strong>Currency</strong></label>
                      <select name="currency_code" class="form-control">
                        <option value="">Select Currency</option>
                        <option value="USD" selected="selected">USD - U.S. Dollars</option>
                        <option value="AUD">AUD - Australian Dollars</option>
                        <option value="BRL">BRL - Brazilian Reais</option>
                        <option value="GBP">GBP - British Pounds</option>
                        <option value="HKD">HKD - Hong Kong Dollars</option>
                        <option value="HUF">HUF - Hungarian Forints</option>
                        <option value="INR">INR - Indian Rupee</option>
                        <option value="ILS">ILS - Israeli New Shekels</option>
                        <option value="JPY">JPY - Japanese Yen</option>
                        <option value="MYR">MYR - Malaysian Ringgit</option>
                        <option value="MXN">MXN - Mexican Pesos</option>
                        <option value="TWD">TWD - New Taiwan Dollars</option>
                        <option value="NZD">NZD - New Zealand Dollars</option>
                        <option value="NOK">NOK - Norwegian Kroner</option>
                        <option value="PHP">PHP - Philippine Pesos</option>
                        <option value="PLN">PLN - Polish Zlotys</option>
                        <option value="RUB">RUB - Russian Rubles</option>
                        <option value="SGD">SGD - Singapore Dollars</option>
                        <option value="SEK">SEK - Swedish Kronor</option>
                        <option value="CHF">CHF - Swiss Francs</option>
                        <option value="THB">THB - Thai Baht</option>
                        <option value="TRY">TRY - Turkish Liras</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group mb-20">
                      <label><strong>How much do you want to donate?</strong></label>
                      <select name="amount" class="form-control">
                          <option value="20">20</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                          <option value="200">200</option>
                          <option value="500">500</option>
                          <option value="other">Other Amount</option>
                      </select>
                      <div id="custom_other_amount">
                        <label><strong>Custom Amount:</strong></label>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-flat btn-dark btn-theme-colored mt-10 pl-30 pr-30" data-loading-text="Please wait...">Donate Now</button>
                    </div>
                  </div>
                </div>
              </form>
              
              <!-- Script for Donation Form Custom Amount -->
              <script type="text/javascript">
                $(document).ready(function(e) {
                  var $donation_form = $("#paypal_donate_form_onetime_recurring");
                  //toggle custom amount
                  var $custom_other_amount = $donation_form.find("#custom_other_amount");
                  $custom_other_amount.hide();
                  $donation_form.find("select[name='amount']").change(function() {
                      var $this = $(this);
                      if ($this.val() == 'other') {
                        $custom_other_amount.show().append('<div class="input-group"><span class="input-group-addon">$</span> <input id="input_other_amount" type="text" name="amount" class="form-control" value="100"/></div>');
                      }
                      else{
                        $custom_other_amount.children( ".input-group" ).remove();
                        $custom_other_amount.hide();
                      }
                  });

                  //toggle donation_type_choice
                  var $donation_type_choice = $donation_form.find("#donation_type_choice");
                  $donation_type_choice.hide();
                  $("input[name='payment_type']").change(function() {
                      if (this.value == 'recurring') {
                          $donation_type_choice.show();
                      }
                      else {
                          $donation_type_choice.hide();
                      }
                  });


                  // submit form on click
                  $donation_form.on('submit', function(e){
                          $( "#paypal_donate_form-onetime" ).submit();
                      var item_name = $donation_form.find("select[name='item_name'] option:selected").val();
                      var currency_code = $donation_form.find("select[name='currency_code'] option:selected").val();
                      var amount = $donation_form.find("select[name='amount'] option:selected").val();
                      var t3 = $donation_form.find("input[name='t3']:checked").val();

                      if ( amount == 'other') {
                        amount = $donation_form.find("#input_other_amount").val();
                      }

                      // submit proper form now
                      if ( $("input[name='payment_type']:checked", $donation_form).val() == 'recurring' ) {
                          var recurring_form = $('#paypal_donate_form-recurring');

                          recurring_form.find("input[name='item_name']").val(item_name);
                          recurring_form.find("input[name='currency_code']").val(currency_code);
                          recurring_form.find("input[name='a3']").val(amount);
                          recurring_form.find("input[name='t3']").val(t3);

                          recurring_form.find("input[type='submit']").trigger('click');

                      } else if ( $("input[name='payment_type']:checked", $donation_form).val() == 'one_time' ) {
                          var onetime_form = $('#paypal_donate_form-onetime');

                          onetime_form.find("input[name='item_name']").val(item_name);
                          onetime_form.find("input[name='currency_code']").val(currency_code);
                          onetime_form.find("input[name='amount']").val(amount);

                          onetime_form.find("input[type='submit']").trigger('click');
                      }
                      return false;
                  });

                });
              </script>

              <!-- Paypal Onetime Form -->
              <form id="paypal_donate_form-onetime" class="hidden" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_donations">
                <input type="hidden" name="business" value="accounts@thememascot.com">

                <input type="hidden" name="item_name" value="Educate Children"> <!-- updated dynamically -->
                <input type="hidden" name="currency_code" value="USD"> <!-- updated dynamically -->
                <input type="hidden" name="amount" value="20"> <!-- updated dynamically -->

                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="cn" value="Comments...">
                <input type="hidden" name="tax" value="0">
                <input type="hidden" name="lc" value="US">
                <input type="hidden" name="bn" value="PP-DonationsBF">
                <input type="hidden" name="return" value="http://www.yoursite.com/thankyou.html">
                <input type="hidden" name="cancel_return" value="http://www.yoursite.com/paymentcancel.html">
                <input type="hidden" name="notify_url" value="http://www.yoursite.com/notifypayment.php">
                <input type="submit" name="submit">
              </form>
              
              <!-- Paypal Recurring Form -->
              <form id="paypal_donate_form-recurring" class="hidden" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="business" value="accounts@thememascot.com">

                <input type="hidden" name="item_name" value="Educate Children"> <!-- updated dynamically -->
                <input type="hidden" name="currency_code" value="USD"> <!-- updated dynamically -->
                <input type="hidden" name="a3" value="20"> <!-- updated dynamically -->
                <input type="hidden" name="t3" value="D"> <!-- updated dynamically -->


                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <input type="hidden" name="no_shipping" value="0">
                <input type="hidden" name="no_note" value="1">                     
                <input type="hidden" name="lc" value="US">
                <input type="hidden" name="bn" value="PP-DonationsBF">
                <input type="hidden" name="return" value="http://www.yoursite.com/thankyou.html">
                <input type="hidden" name="cancel_return" value="http://www.yoursite.com/paymentcancel.html">
                <input type="hidden" name="notify_url" value="http://www.yoursite.com/notifypayment.php">
                <input type="submit" name="submit">
              </form>
              <!-- ===== END: Paypal Both Onetime/Recurring Form ===== -->              
            </div>--}}
            <div class="col-xs-12 col-sm-12 col-md-12 pb-60">
              <h3 class="text-uppercase title line-bottom mt-0 mb-30"><i class="fa fa-comments-o text-theme-colored mr-10"></i>TESTIMONI <span class="text-theme-colored">DONATUR</span></h3>
              <div class="testimonial style1 owl-carousel-1col owl-nav-top">
                @foreach($testimoni as $datatesti)
                <div class="item">
                  <div class="comment bg-theme-colored" style="padding-top:35px !important;padding-bottom:35px !important;">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                          <img class="img-circle" alt="" width="75" height="75" src="http://placehold.it/75x75" style="margin-top:10px;float:left">
                        <h5 class="author " style="color: #fff;margin-top:20px;">{{$datatesti->responden}}</h5>
                          <h6 class="title">{{$datatesti->lembaga}}</h6></div>
                        <div class="col-md-8 pt-30"><p>"{{$datatesti->testimoni}}"</p></div>
                    </div>
                    
                  </div>
                </div>
                @endforeach
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> 

    <!-- Section: Gallery -->
    <section id="gallery" class="bg-lighter">
      <div class="container pb-10 pt-15">
        <div class="section-content">
          <div class="row">
            <!-- <div class="col-md-12"> -->
            <div class="col-md-8">
              <h3 class="text-uppercase title line-bottom mt-0 mb-30"><i class="fas fa-images text-gray-darkgray mr-10"></i>Photo <span class="text-theme-colored">Gallery</span></h3>
              <!-- Portfolio Gallery Grid -->
              
              
              <div class="gallery-isotope grid-3 grid-sm-3 gutter-small clearfix" data-lightbox="gallery">
                @foreach($gallery_campaign as $campaign)
                  <!-- Portfolio Item Start -->
                  <div class="gallery-item">
                    <div class="thumb">
                      <img alt="project" width="285" height="195" src="{{asset('photos/campaign/'.$campaign->feature_image_url)}}" class="img-fullwidth">
                      <div class="overlay-shade"></div>
                      <div class="icons-holder">
                        <div class="icons-holder-inner">
                          <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                            <a href="{{asset('photos/campaign/'.$campaign->feature_image_url)}}"  data-lightbox-gallery="gallery"><i class="fa fa-picture-o"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Portfolio Item End -->
                @endforeach
                
              </div>
            </div>
            <div class="col-md-4">
                <h3 class="text-uppercase title line-bottom mt-0 mb-30"><i class="fa fa-film text-gray-darkgray mr-10"></i> <span class="text-theme-colored">VIDEO</span></h3>
              
                 <iframe width="390" height="290" src="https://www.youtube.com/embed/u3-Oxe_qsVQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

              
              <!-- End Portfolio Gallery Grid -->
           <!--  </div> -->
          </div>
        </div>
      </div>
    </section>

    <!-- Section: blog -->
    <section id="blog">
      <div class="container">
        <div class="section-title">
          <div class="row">
            <div class="col-md-6">
              <!-- <h5 class="font-weight-300 m-0">What we can do?</h5> -->
              <h2 class="mt-0 text-uppercase font-28">BERITA <span class="text-theme-colored font-weight-400"></span> <span class="font-30 text-theme-colored">.</span></h2>
              <div class="icon">
                <i class="fa fa-hospital-o"></i>
              </div>
            </div>
            @if($latest_blogs->count() == 0)
            <div class="col-md-6"> <p>Belum ada entri News.</p></div>
            @endif
          </div>
        </div>
        <div class="section-content">
          <div class="row">
            @foreach ($latest_blogs as $blog)
            <div class="col-xs-12 col-sm-6 col-md-4">
              <article class="post clearfix mb-sm-30 bg-silver-light">
                <div class="entry-header">
                  <div class="post-thumb thumb">
                    <img src="{{asset('public/photos/blog/'.$blog->feature_image_url)}}" alt="" class="img-responsive img-fullwidth">
                  </div>
                </div>
                <div class="entry-content p-20 pr-10">
                  <div class="entry-meta media mt-0 no-bg no-border">
                    <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                      <ul>
                        <li class="font-16 text-white font-weight-600 border-bottom">{{ date('d', strtotime($blog->updated_at)) }}</li>
                        <li class="font-12 text-white text-uppercase">{{ date('M', strtotime($blog->updated_at)) }}</li>
                      </ul>
                    </div>
                    <div class="media-body pl-15">
                      <div class="event-content pull-left flip">
                        <h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></h4>
                      </div>
                    </div>
                  </div>
                  <p class="mt-10">{!! str_limit($blog->post, 150, "...") !!}</p>
                  <a href="{{ route('blog.show', $blog->id) }}" class="btn-read-more">Selengkapnya</a>
                  <div class="clearfix"></div>
                </div>
              </article>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>


    @if($quote)
    <!-- Divider: Call To Action -->
    <section class="bg-theme-colored">
      <div class="container pt-0 pb-0">
        <div class="row">
          <div class="col-md-12">
            <div class="call-to-action pt-30 pb-30">
              <div class="col-md-9">
                <h3 class="text-white">{{$quote->quote}}</h3>
              </div>
              <div class="col-md-3 text-right sm-text-center">
                <a class="btn btn-transparent btn-border btn-circled btn-lg mt-15" href="{{ $quote->button_url }}" target="_blank">{{$quote->button_text}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
<!-- end wrapper -->

<!-- FOOTER CONTENT -->
</div>
  <!-- end main-content -->
  <!-- Footer -->
  <footer id="footer" class="footer" data-bg-img="{{asset('public/images/footer-bg.png')}}" data-bg-color="#25272e">
    <div class="container pt-70 pb-40">
      <div class="row border-bottom-black">
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <img class="mt-10 mb-20" width="70%" alt="" src="{{asset('public/images/logopedulinegeri.png')}}">
            <p>Jl. Gegerkalong Girang No. 32 Bandung</p>
            <ul class="list-inline mt-5">
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-theme-colored mr-5"></i> <a class="text-gray" href="#">085 10001 7002</a> </li>
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope-o text-theme-colored mr-5"></i> <a class="text-gray" href="#">info@pedulinegeri.com</a> </li>
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-globe text-theme-colored mr-5"></i> <a class="text-gray" href="#">www.pedulinegeri.com</a> </li>
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-copyright text-theme-colored mr-5"></i> <a class="text-gray" href="#">Powered by : DT Peduli</a> </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Berita Terbaru</h5>
            <div class="latest-posts">
              @if($latest_blogs->count() == 0)
                <article class="post media-post clearfix pb-0 mb-10">
                  <div class="post-right"> <p>Belum ada entri News.</p></div>
                </article>
              @endif

              @foreach($latest_blogs as $footer_blog)
              <article class="post media-post clearfix pb-0 mb-10">
                <a href="#" class="post-thumb"><img alt="" width="80" height="55" src="{{asset('public/photos/blog/'.$footer_blog->feature_image_url)}}"></a>
                <div class="post-right">
                  <h5 class="post-title mt-0 mb-5"><a href="#">{{$footer_blog->title}}</a></h5>
                  <p class="post-date mb-0 font-12">{{ date('d-m-Y', strtotime($footer_blog->updated_at)) }}</p>
                </div>
              </article>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Pintas Links</h5>
            <ul class="list angle-double-right list-border">
              <li><a href="{{url('tentang-kami')}}">Tentang</a></li>
              <li><a href="{{url('program')}}">Program</a></li>
              <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Zakat</a></li>
              <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Infaq</a></li>
              <li><a href="https://dpu-daaruttauhiid.org/web/donasi_online">Sodaqoh</a></li>             
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Jam Kerja</h5>
            <div class="opening-hours">
              <ul class="list-border">
                <li class="clearfix"> <span> Senin - Rabu :  </span>
                  <div class="value pull-right"> 07.30 - 17.00 WIB </div>
                </li>
                <li class="clearfix"> <span> Kamis - Jum'at :</span>
                  <div class="value pull-right"> 08.30 - 17.00 WIB </div>
                </li>
                <li class="clearfix"> <span> Sabtu - Minggu : </span>
                  <div class="value pull-right"> Libur </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-10">
        <div class="col-md-5">
          <div class="widget dark">
            <h5 class="widget-title mb-10">Sosmed</h5>
            <ul class="styled-icons icon-dark icon-theme-colored icon-circled icon-sm">
              @foreach($social_medias as $media)
              <?php $type = strtolower($media->type) ?>
              <li><a href="{{ $media->url }}"><i class="fa fa-{{ $type }}"></i></a></li>
              @endforeach
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 col-md-offset-1">
          &nbsp;
        </div>
        <div class="col-md-3">
          <div class="widget dark">
            
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom bg-black-333">
      <div class="container pt-15 pb-10">
        <div class="row">
          <div class="col-md-6">
            <p class="font-11 text-black-777 m-0">Copyright &copy; Peduli Negeri 2018.</p>
          </div>
          <div class="col-md-6 text-right">
            <div class="widget no-border m-0">
              &nbsp;
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- external javascripts -->
<!-- Revolution Slider 5.x SCRIPTS -->
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('public/js/revolution-slider/js/jquery.themepunch.revolution.min.js')}}"></script>


<!-- JS | Custom script for all pages -->
<script src="{{asset('public/js/custom.js')}}"></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
      (Load Extensions only on Local File Systems ! 
       The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/revolution-slider/js/extensions/revolution.extension.video.min.js')}}"></script>

</body>
</html>
@endsection