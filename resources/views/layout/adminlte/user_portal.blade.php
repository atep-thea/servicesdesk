<!DOCTYPE html>

<!--

This is a starter template page. Use this page to start your new project from

scratch. This page gets rid of all links and provides the needed markup only.

-->

<html>



@include('layout.adminlte.partials.htmlheader')



<!--

BODY TAG OPTIONS:

=================

Apply one or more of the following classes to get the

desired effect

|---------------------------------------------------------|

| SKINS         | skin-blue                               |

|               | skin-black                              |

|               | skin-purple                             |

|               | skin-yellow                             |

|               | skin-red                                |

|               | skin-green                              |

|---------------------------------------------------------|

|LAYOUT OPTIONS | fixed                                   |

|               | layout-boxed                            |

|               | layout-top-nav                          |

|               | sidebar-collapse                        |

|               | sidebar-mini                            |

|---------------------------------------------------------|

-->

<body class="skin-red-light sidebar-mini">

<div class="wrapper">



    @include('layout.adminlte.user.mainheader')



   <!--  -->

   @include('layout.adminlte.user.sidebar')

    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper" style="background: #edecec">



       



        <!-- Main content -->

        <section class="content" >

            <!-- Your Page Content Here -->

            @yield('main-content')

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->



    @include('layout.adminlte.partials.footer')



</div><!-- ./wrapper -->



@include('layout.adminlte.partials.scripts')



</body>

</html>

