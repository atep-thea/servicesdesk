<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="padding-top: 50px !important;background: #fff !important">
    <section class="">
        <div class="head_profile">
            <div align="center">
                <a href="{{url('view_profile_user')}}">
                    <?php 
                    $fotoProfil = 'public/photos/profile/'.Auth::user()->id.'/'.Auth::user()->foto;
                ?>
                @if(empty($user->foto))
                  <img id="profile_pic" style="margin: 0px auto 10px auto;width: 100px;height: 100px;border-radius: 100%;border: 3px solid #fff; src="{{asset('public/images/laki.jpg')}}" alt="">
                @else
                  <img id="profile_pic" style="margin: 0px auto 10px auto;width: 100px;height: 100px;border-radius: 100%;border: 3px solid #fff;"  src="{{asset($fotoProfil)}}" alt="">
                @endif                   
                </a>
            </div>
            <div style="color:#fff;text-align: center;">
                {{Auth::user()->nama_depan}} {{Auth::user()->nama_belakang}}
            </div>  
        </div>
    </section>
    <section class="sidebar " style="padding-top: 0px !important">       
        <ul class="sidebar-menu" style="font-size:15px;border:0px !important">
            <li @yield('campaign-link')>
                <a href="{{url('/user_portal')}}"><i class="fa fa-home" style="font-size:20px;color:#ffcc2d;margin-right: 10px;color:#384052"></i>
                     <span>Beranda</span>
                </a>
            </li>
            <li @yield('new_tiket-link')><a href="{{route('new_tiket.index')}}"><i class="fas fa-clipboard-list" style="font-size:23px;color:#339af0;margin-right: 10px;"></i> <span>Pengajuan Permintaan</span></a></li>
            <li @yield('request_progress-link')><a href="{{route('request_progress.index', ['status' => 'Open'])}}"><i class="fa fa-indent" style="font-size:20px;color:#ff0e17;margin-right: 10px;"></i> <span>Permintaan Baru</span></a></li>
            <li @yield('request_progress-link')><a href="{{route('request_progress.index', ['status' => 'Diproses'])}}"><i class="fa fa-indent" style="font-size:20px;color:#420eff;margin-right: 10px;"></i> <span>Permintaan Diproses</span></a></li>
            <li @yield('insiden-link')><a href="{{route('slaba.index')}}"><i class="fas fa-clipboard-check" style="font-size:23px;color:#02a65a;margin-right: 10px;" style="font-size: 18px;color: #000;margin-right: 10px;"></i> <span>Hasil Pemenuhan & BA</span></a></li>
            <li @yield('request_done-link')><a href="{{route('closeTiketView')}}"><i class="fas fa-history" style="font-size:23px;color:#02a65a;margin-right: 10px;"></i> <span>History</span></a></li>
            <!-- <li @yield('insiden_user-link')><a href="{{route('insiden_user.index')}}"><i class="fas fa-clipboard-check" style="font-size:23px;color:#02a65a;margin-right: 10px;"></i> <span>Laporan Insiden</span></a></li> -->
            <!--  <li><a href=""><i class="fa fa-lightbulb" style="font-size:23px;color:#ffa500;margin-right: 10px;"></i> <span>Panduan</span></a></li>
 -->        </ul><!-- /.sidebar-menu -->
        
    </section>

    <!-- /.sidebar -->
</aside>
