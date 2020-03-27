<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="icon" width="100%" href="{{ asset('img/logo.png')}}">
  <title>@yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/ionicons/css/ionicons.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
<!-- Start GA -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body class="">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg bg-warning"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
             <a href="{{ route('logout')}}" class="btn btn-outline-danger has-icon " onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </ul>
      </nav>

      <!-- Sidebar -->
      @include('admin.layout.module.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('content_header')</h1>
            <div class="section-header-breadcrumb">
              @yield('breadcrumb')
            </div>
          </div>

          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>

      <!-- Footer -->
      <footer class="main-footer">
        <div class="footer-left">
          Kerja Project &copy; 2019 <div class="bullet"></div> Sarana & Prasarana
        </div>
        <div class="footer-right">

        </div>
      </footer>
    </div>
  </div>

  @if ($message = Session::get('error'))
      <div id="failed" data-flashdata="{{ $message }}"></div>
  @endif
  @if ($message = Session::get('success'))
      <div id="success" data-flashdata="{{ $message }}"></div>
  @endif

  <!-- JS Call -->
  @yields('js')
  <!-- General JS Scripts -->

  <!-- Default SweetAlert -->
  <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
      var fail = $('#failed').data('flashdata');
      var success = $('#success').data('flashdata');
      if (fail) {
          swal({
              title: "Failed",
              text: fail,
              type: "error",
          });
      }
      if (success) {
          swal({
              title: "Success",
              text: success,
              type: "success",
          });
      }
    </script>

  <!-- End -->
  
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
  <script src="{{ asset('assets/js/page/modules-ion-icons.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
  <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  @yield('js')
</body>
</html>
