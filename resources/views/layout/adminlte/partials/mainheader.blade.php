<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo" style="position: fixed">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <b>S</b>D </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img width="50%" src="{{ asset('public/images/itop-logo.png') }}" />
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #009788; color: #fff; ">
        <!-- Sidebar toggle button-->
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        @if (Auth::user()->role_user != 'User')
            <div class="portal">
                <a href="{{ url('/user_portal') }}" >Portal User &nbsp; <i class="fa fa-desktop"
                        aria-hidden="true"></i>&nbsp; </a>
            </div>
        @endif
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> 
                        <?php
                        $fotoProfil = 'public/photos/profile/'.Auth::user()->id.'/' . Auth::user()->foto;
                        ?>
                        @if (empty($user->foto))
                            <img class="user-image"
                                src="{{ asset('public/images/laki.jpg') }}" alt="">
                        @else
                            <img class="user-image" src="{{ asset($fotoProfil) }}" alt="">
                        @endif
                        <span class="hidden-xs">{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }} ({{Auth::user()->role_user}})</span>
                    </a>
                    <ul class="dropdown-menu" style="border: 1px solid #ccc;padding-top:10px;padding-bottom:10px;">
                        <li>
                            <ul class="menu" style="padding-left: 23px;">
                                <li style="margin-bottom:10px">
                                    <a href="{{ url('view_profile') }}">
                                        <i class="fa fa-users text-aqua"></i>&nbsp;&nbsp;&nbsp;&nbsp;View Detail Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('logout') }}">
                                        <i class="fas fa-sign-out-alt"
                                            style="color:red;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Logout </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
            </ul>
        </div>
    </nav>
</header>
