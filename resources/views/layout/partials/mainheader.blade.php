  <header id="header" class="header">

    <div class="header-nav navbar-fixed-top header-dark navbar-white navbar-transparent bg-transparent-1 navbar-sticky-animated animated-active">

      <div class="header-nav-wrapper" >

        <div class="container" id="pd-container">

          <nav id="menuzord-right" class="menuzord default no-bg" id="pd-nav-bar">

            <a class="menuzord-brand pull-left flip" href="{{url('/')}}" >

              <img src="{{asset('public/images/logopedulinegeri.png')}}" alt=""></a>

            <ul class="menuzord-menu">

              <li @yield('link-home')>

                <a href="{{url('/')}}">Beranda</a>

              </li>

              <li @yield('link-about')><a href="{{ url('tentang-kami') }}">Tentang</a>

              </li>

              <li @yield('link-program')><a href="{{ url('program') }}">Program</a>

              </li>

              <li>

                <a>Donasi</a>

                <ul class="dropdown">

                  <li><a target="_blank" href="https://dpu-daaruttauhiid.org/web/donasi_online">Zakat</a></li>

                  <li><a target="_blank" href="https://dpu-daaruttauhiid.org/web/donasi_online">Infaq</a></li>

                  <li><a target="_blank" href="https://dpu-daaruttauhiid.org/web/donasi_online">Fidyah</a></li>

                  <li><a target="_blank" href="https://dpu-daaruttauhiid.org/web/donasi_online">Wakaf</a></li>

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

              <!-- <li @yield('link-galang-dana')>

                <a href="{{url('public/register')}}">Galang Dana</a>

              </li> -->

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

<!--End of Tawk.to Script