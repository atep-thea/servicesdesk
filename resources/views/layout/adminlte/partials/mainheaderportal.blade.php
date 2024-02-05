<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>D</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img width="50%" src="{{asset('public/images/itop-logo.png')}}"/></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: #367fa9; color: #fff; ">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
    <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="view-profile" class="dropdown-toggle">
              <?php
                  $profil_pic = $user->profpic_url;
                  if (substr($profil_pic,0,5)!='https')
                  {
                      $profil_pic = "photos/profile/".$profil_pic;
                  }

                ?>
                  <img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" class="user-image" alt="User Image">
                
              <span class="hidden-xs">{{Auth::user()->nama_depan}} {{Auth::user()->nama_belakang}}</span>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>

    </nav>

  </header>