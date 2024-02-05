<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="position: fixed;">
    <section class="">
        <div class="head_profile">
            <div align="center">
                <a href="{{ url('view_profile_user') }}">
                    <?php
                    $fotoProfil = 'public/photos/profile/' . Auth::user()->id . '/' . Auth::user()->foto;
                    ?>
                    @if (empty($user->foto))
                        <img style="margin: 0px auto 10px auto;width: 100px;height: 100px;border-radius: 100%;border: 3px solid #fff;"
                            src="{{ asset('public/images/laki.jpg') }}" alt="">
                    @else
                        <img style="margin: 0px auto 10px auto;width: 100px;height: 100px;border-radius: 100%;border: 3px solid #fff;"
                            src="{{ asset($fotoProfil) }}" alt="">
                    @endif


                </a>
            </div>
            <div style="color:#fff;text-align: center;">
                {{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}
            </div>
        </div>
    </section>
    <section class="sidebar">
        <ul class="sidebar-menu" style="font-size:15px;">
            <li @yield('home-link')>
                <a href="{{ url('/home') }}">
                    <i class="fa fa-home" style="font-size:20px;color:#ffcc2d;margin-right: 10px;color:#20c997"></i>
                    <span>Beranda</span>
                </a>
            </li>
            @if (Auth::user()->role_user == 'Agen')
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.agen', ['status' => 'Diproses']) }}">
                        <i class="fa fa-sync"
                            style="font-size:23px;color:#33f06c;margin-right: 10px;"></i><span>Pemenuhan Layanan</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Close']) }}">
                        <i class="fa fa-history"
                            style="font-size:23px;color:#f03333;margin-right: 10px;"></i><span>History</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_user == 'Koordinator Agen')
                {{-- <li @yield('pelayanan-list')>
                <a href="{{ route('pelayanan.index') }}">
                    <i class="fas fa-clipboard-list"
                        style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Pemenuhan Layanan</span>
                </a>
            </li> --}}
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Open']) }}">
                        <i class="fas fa-clipboard-list"
                            style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Verifikasi
                            Permintaan</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayananDataUnverifiedPage', ['status_task' => 0]) }}">
                        <i class="fas fa-check-square"
                            style="font-size:23px;color:#333ff0;margin-right: 10px;"></i><span>Verifikasi
                            Pemenuhan</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Diproses']) }}">
                        <i class="fa fa-sync"
                            style="font-size:23px;color:#33f06c;margin-right: 10px;"></i><span>Permintaan
                            Diproses</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Ditutup']) }}">
                        <i class="fas fa-clipboard-list"
                            style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Tutup Tiket</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.koordinatorAgen', ['status' => 'Close']) }}">
                        <i class="fa fa-history"
                            style="font-size:23px;color:#f03333;margin-right: 10px;"></i><span>History</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_user == 'Admin')
                <li @yield('helpdesk-list') @yield('donasi-list-pending') class="treeview">
                    <a href="#">
                        <i class='fa fa-headset' style="font-size:20px;color:#9c55b8;margin-right: 10px;"></i>
                        <span>Pelayanan</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @yield('pelayanan-list')>
                            <a href="{{ route('superAdminPelayananPage', ['status' => 'Open']) }}">
                                <i class="fa fa-clipboard-list"
                                    style="font-size:23px;color:#33f06c;margin-right: 10px;"></i><span>Permintaan
                                    Masuk</span>
                            </a>
                        </li>
                        <li @yield('pelayanan-list')>
                            <a href="{{ route('superAdminPelayananPage', ['status' => 'Diproses']) }}">
                                <i class="fa fa-sync"
                                    style="font-size:23px;color:#4633f0;margin-right: 10px;"></i><span>Permintaan
                                    Diproses</span>
                            </a>
                        </li>
                        <li @yield('pelayanan-list')>
                            <a href="{{ route('superAdminPelayananPage', ['status' => 'Close']) }}">
                                <i class="fa fa-history"
                                    style="font-size:23px;color:#f03333;margin-right: 10px;"></i><span>Kelola
                                    History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li @yield('organisation-link')>
                    <a href="{{ route('organisasi.index') }}">
                        <i class="fa fa-sitemap" style="font-size:20px;color:#9c55b8;margin-right: 10px;"></i>
                        <span>Lembaga/Organisasi</span>
                    </a>
                </li>
                <li @yield('infrastuktur-list') @yield('asset-list') class="treeview">
                    <a href="#">
                        <i class='fa fa-building' style="font-size:20px;color:#237fbb;margin-right: 10px;"></i>
                        <span>Infrastruktur</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @yield('server-list')>
                            <a href="{{ route('server.index') }}">
                                <span>Server nya</span>
                            </a>
                        </li>
                        <li @yield('accespoint-list')>
                            <a href="{{ route('accesspoint.index') }}">
                                <span>AccessPoint</span>
                            </a>
                        </li>
                        <li @yield('vserver-list')>
                            <a href="{{ route('vserver.index') }}">
                                <span>Virtual Server</span>
                            </a>
                        </li>
                        <li @yield('rak-list')>
                            <a href="{{ route('rak.index') }}">
                                <span>Rak</span>
                            </a>
                        </li>
                        <li @yield('router-list')>
                            <a href="{{ route('router.index') }}">
                                <span>Router</span>
                            </a>
                        </li>
                        <li @yield('jaringan-list')>
                            <a href="{{ route('jaringan.index') }}">
                                <span>Perangkat Jaringan</span>
                            </a>
                        </li>
                        <li @yield('penyimpanan-list')>
                            <a href="{{ route('penyimpanan.index') }}">
                                <span>Perangkat Penyimpanan</span>
                            </a>
                        </li>
                        <li @yield('switch-list')>
                            <a href="{{ route('switch.index') }}">
                                <span>Switch</span>
                            </a>
                        </li>
                        <li @yield('nas-list')>
                            <a href="{{ route('nas.index') }}">
                                <span>NAS</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li @yield('hardsoftware-list') class="treeview">
                    <a href="#">
                        <i class='fa fa-desktop' style="font-size:20px;color:#237fbb;margin-right: 10px;"></i>
                        <span>Hardware</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @yield('perangkatkeras-list')>
                            <a href="{{ route('perangkat-keras.index') }}">
                                <span>Hardware</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li @yield('referensi-list') class="treeview">
                    <a href="#">
                        <i class='fa fa-clone' style="font-size:20px;color:#237fbb;margin-right: 10px;"></i>
                        <span>Referensi</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @yield('jabatan-list')>
                            <a href="{{ route('jabatan.index') }}">
                                <span>Jabatan</span>
                            </a>
                        </li>
                        <li @yield('jns_pelayanan-list')>
                            <a href="{{ route('jns_pelayanan.index') }}">
                                <span>Jenis Pelayanan</span>
                            </a>
                        </li>
                        <li @yield('jns_perangkat-list')>
                            <a href="{{ route('jns_perangkat.index') }}">
                                <span>Jenis Perangkat</span>
                            </a>
                        </li>
                        <li @yield('golongan-list')>
                            <a href="{{ route('golongan.index') }}">
                                <span>Golongan</span>
                            </a>
                        </li>
                        <li @yield('status-list')>
                            <a href="{{ route('status.index') }}">
                                <span>Status</span>
                            </a>
                        </li>
                        <li @yield('team-list')>
                            <a href="{{ route('team.index') }}">
                                <span>Team</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li @yield('user-link')>
                    <a href="{{ route('user.index') }}">
                        <i class="fa fa-users"
                            style="font-size:20px;color:#ffcc2d;margin-right: 10px;color:#df4c3f"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
            @elseif(Auth::user()->role_user == 'Helpdesk')
                <li @yield('organisation-link')>
                    <a href="{{ route('pelayanan.create') }}">
                        <i class="fa fa-headset" style="font-size:20px;color:#9c55b8;margin-right: 10px;"></i>
                        <span>Pengajuan Permintaan</span>
                    </a>
                </li>
                {{-- <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.index') }}">
                        <i class="fas fa-clipboard-list"
                            style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Pelayanan</span>
                    </a>
                </li> --}}
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.helpdesk', ['status' => 'Open']) }}">
                        <i class="fa fa-arrow-right"
                            style="font-size:23px;color:#c7ca04b9;margin-right: 10px;"></i><span>Permintaan Baru</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.helpdesk', ['status' => 'Diproses']) }}">
                        <i class="fa fa-sync"
                            style="font-size:23px;color:#33f06c;margin-right: 10px;"></i><span>Pelayanan Diproses</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.helpdesk', ['status' => 'Close']) }}">
                        <i class="fa fa-history"
                            style="font-size:23px;color:#f03333;margin-right: 10px;"></i><span>History</span>
                    </a>
                </li>
            @elseif(Auth::user()->role_user == 'Verifikator PD')
                {{-- <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.index') }}">
                        <i class="fas fa-clipboard-list"
                            style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Validasi Permintaan</span>
                    </a>
                </li> --}}
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.validatorpd', ['status' => 'Open']) }}">
                        <i class="fa fa-sync"
                            style="font-size:23px;color:#33f06c;margin-right: 10px;"></i><span>Validasi
                            Permintaan</span>
                    </a>
                </li>
                <li @yield('pelayanan-list')>
                    <a href="{{ route('pelayanan.validatorpd', ['status' => 'Close']) }}">
                        <i class="fa fa-history"
                            style="font-size:23px;color:#f03333;margin-right: 10px;"></i><span>History</span>
                    </a>
                </li>
            @elseif(Auth::user()->role_user == 'Admin')
                <li @yield('organisation-link')>
                    <a href="{{ route('disposisi.index') }}">
                        <i class="fa fa-headset" style="font-size:20px;color:#9c55b8;margin-right: 10px;"></i>
                        <span>Request User</span>
                    </a>
                </li>
                <li @yield('organisation-link')>
                    <a href="{{ route('report_insiden.index') }}">
                        <i class="fa fa-file" style="font-size:20px;color:#3f4d71;margin-right: 10px;"></i>
                        <span>Laporan Insiden</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_user == 'Admin SOP')
                <li @yield('jns_pelayanan-list')>
                    <a href="{{ route('jns_pelayanan.index') }}">
                        <i class="fa fa-stream" style="font-size:20px;color:#3f4d71;margin-right: 10px;"></i>
                        <span>Jenis Pelayanan</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role_user == 'Eselon 3')
                <li @yield('history-pelayanan-eselon3-list')>
                    <a href="{{ route('eselon3PelayananPage', ['status' => 'Open']) }}">
                        <i class="fas fa-folder-open"
                            style="font-size:23px;color:#339af0;margin-right: 10px;"></i><span>Layanan Masuk</span>
                    </a>
                </li>
                <li @yield('history-pelayanan-eselon3-list')>
                    <a href="{{ route('eselon3PelayananPage', ['status' => 'Diproses']) }}">
                        <i class="fas fa-clipboard-list"
                            style="font-size:23px;color:#33f062;margin-right: 10px;"></i><span>Layanan Diproses</span>
                    </a>
                </li>
                <li @yield('history-pelayanan-eselon3-list')>
                    <a href="{{ route('eselon3PelayananPage', ['status' => 'Close']) }}">
                        <i class="fas fa-history"
                            style="font-size:23px;color:#f03343;margin-right: 10px;"></i><span>History</span>
                    </a>
                </li>
            @endif
            <!-- <li @yield('ganti-profile')><a href="{{ url('change-profile') }}"><i class='fa fa-pencil-square-o'></i><span>Ubah Profil</span></a></li> -->
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <div class="row" style="padding:20px;bottom:0px;position: fixed;">
        <div align="center">
            <img width="85%" src="{{ asset('public/images/logo-jabarprov.png') }}" />
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
