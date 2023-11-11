<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>ACG | Dashboard</title>
        <link rel="icon" href="{{ asset('backend/dist/img/favicon.png') }}" sizes="16x16">
        <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/custom-css.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/sweetalert.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/sweetalert.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/_miscellaneous.scss') }}">
        <link rel="stylesheet" href="{{{ URL::asset('bootstrap4.3\css\font-awesome.min.css')}}}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
         <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"> --}}
        <!-- css swal -->
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w==" crossorigin="anonymous"></script> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" integrity="sha512-f8gN/IhfI+0E9Fc/LKtjVq4ywfhYAVeMGKsECzDUHcFJ5teVwvKTqizm+5a84FINhfrgdvjX8hEJbem2io1iTA==" crossorigin="anonymous" /> --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js" integrity="sha512-XVz1P4Cymt04puwm5OITPm5gylyyj5vkahvf64T8xlt/ybeTpz4oHqJVIeDtDoF5kSrXMOUmdYewE4JS/4RWAA==" crossorigin="anonymous"></script> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" integrity="sha512-hwwdtOTYkQwW2sedIsbuP1h0mWeJe/hFOfsvNKpRB3CkRxq8EW7QMheec1Sgd8prYxGm1OM9OZcGW7/GUud5Fw==" crossorigin="anonymous" /> --}}
        {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css.map"> --}}
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
        <!-- jQuery -->
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- DataTables -->
        <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>    
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script> 
        <script src="{{ asset('backend/js/custom-script.js') }}"></script>
        <script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('backend/js/sweetalert.js') }}"></script>
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
            // $('#wrapper-div').show();
            $("#name").keypress(function (event) {
                var inputValue = event.which;
                //Allow letters, white space, backspace and tab.
                //Backspace ASCII = 8
                //Tab ASCII = 9
                if (!(inputValue >= 65 && inputValue <= 123)
                    && (inputValue != 32 && inputValue != 0)
                    && (inputValue != 48 && inputValue != 8)
                    && (inputValue != 9)){
                        event.preventDefault();
                }
                // console.log(inputValue);
            });
         });
        </script>
        <script>
          $(function () {
            $('.select2').select2()
            $('#admin-datatable').DataTable({
                order:false,
                "initComplete": function (settings, json) {  
                $("#admin-datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
              },
            });
          });
        </script>
        @yield('js')
    </body>

</html>
