<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>ACG | Dashboard</title>
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
          <!-- Ionicons -->
          <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
          <!-- fullCalendar -->
          <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar/main.min.css') }}">
          <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar-daygrid/main.min.css') }}">
          <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar-timegrid/main.min.css') }}">
          <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar-bootstrap/main.min.css') }}">
          <!-- Theme style -->
          <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
          <!-- Google Font: Source Sans Pro -->
          <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    /*--------------------------------------------------------------
        # Preloader
        --------------------------------------------------------------*/
        #preloader {
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          z-index: 9999;
          overflow: hidden;
          background: #fff;
        }

        #preloader:before {
          content: "";
          position: fixed;
          top: calc(50% - 30px);
          left: calc(50% - 30px);
          border: 6px solid #2487ce;
          border-top-color: #fff;
          border-bottom-color: #fff;
          border-radius: 50%;
          width: 60px;
          height: 60px;
          -webkit-animation: animate-preloader 1s linear infinite;
          animation: animate-preloader 1s linear infinite;
        }

        @-webkit-keyframes animate-preloader {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }

        @keyframes animate-preloader {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
  </style>
        <style type="text/css">
        .right{
            font-weight: 900;
        }
            .invalids-feedback{
                color: red;
            }

            [class*=sidebar-dark-] {
    background-color: #e9ecef;
}
[class*=sidebar-dark-] .nav-sidebar>.nav-item.menu-open>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus {
    color: black;
}
.sidebar-mini .nav-sidebar, .sidebar-mini .nav-sidebar .nav-link, .sidebar-mini .nav-sidebar>.nav-header {
    white-space: nowrap;
    overflow: hidden;
    color: black;
}
.nav-sidebar .nav-treeview>.nav-item>.nav-link>.nav-icon {
    width: 1.6rem;
    color: black;
}
.nav-sidebar .nav-link p {
    display: inline-block;
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    margin: 0;
    color: black;
}

[class*=sidebar-dark-] .sidebar a {
    /* color: #c2c7d0; */
    color: black;
}

.layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
    background-color: #e9ecef;
}

.main-sidebar .brand-text, .main-sidebar .logo-xl, .main-sidebar .logo-xs, .sidebar .nav-link p, .sidebar .user-panel .info {
    transition: margin-left .3s linear,opacity .3s ease,visibility .3s ease;
    color: black;
}
.navbar-white {
    background-color: #e9ecef;
}
            
        </style>
      
        <!-- css -->
        @yield('css')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div id="loading" style="display:block;"></div>

        <div class="wrapper" id="wrapper-div" /*id="reactApp"*/ >
            @include('backend.includes.navbar')
            @include('backend.includes.sidebar')
            <div class="content-wrapper">
{{--                @include('backend.includes.top-message')--}}
                @include('backend.includes.content-header')
                <div class="container-fluid status-block">
                <div class="card-body">
                    @if ($errors->any())
                        <!-- <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div> -->
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session('message') }}</li>
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ session('error') }}</li>
                            </ul>
                        </div>
                    @endif
                    
                </div>
                </div>
                @yield('content.wrapper')
            </div>
            {{-- @include('backend.includes.control-sidebar') --}}
            @include('backend.includes.footer')

        </div>
        <div id="preloader"></div>
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('backend/dist/js/demo.js') }}"></script>
        <!-- fullCalendar 2.2.5 -->
        <script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar/main.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar-interaction/main.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
         @yield('js')
        <script type="text/javascript">
         $(document).ready(function () {
            // Preloader
            $('#preloader').hide();
              $(window).on('load', function() {
                if ($('#preloader').length) {
                  // $('#preloader').delay(100).fadeOut('slow', function() {
                  //   $(this).remove();
                  // });
                  $('#preloader').hide();
                }
              });
           
         });
        </script>
       
    </body>

</html>
