<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}" >
  <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}" >
  <title>
    {{$title}}
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" />
  <link href="{{asset('css/icon.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
  @include('inc.admin.css.items')
  @include('inc.admin.css.clients')
  @include('inc.admin.css.company')
  @include('inc.admin.css.devices')
  <style>
      #sidenav-collapse-main{
          height: 80% !important;
          
      }

      .navbar-nav{
          padding-top: 20px !important;
      }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
  @include('inc.admin.sidenav')
  @yield('content')
  @include('inc.admin.plugin')
  <!--   Core JS Files   -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script src="{{asset('js/core/popper.min.js')}}"></script>
  <script src="{{asset('js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('js/plugins/chartjs.min.js')}}"></script>

  <script src="{{asset('js/plugins/chartjs.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('js/material-dashboard.min.js?v=3.0.0')}}"></script>

  
  @include('inc.admin.js.dashboard')
  @include('inc.admin.js.clients')
  @include('inc.admin.js.items')
  @include('inc.admin.js.company')
  @include('inc.admin.js.license')
  @include('inc.admin.js.devices')

</body>

</html>