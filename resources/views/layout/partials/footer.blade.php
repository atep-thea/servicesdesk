</div>
  <!-- end main-content -->
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
            &nbsp;
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Useful Links</h5>
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
            <h5 class="widget-title mb-10">Connect With Us</h5>
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
    <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
  </footer>
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