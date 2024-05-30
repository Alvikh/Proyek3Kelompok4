<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/favicon.ico') }}">
  <title>
      AutoAttend
  </title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body class="g-sidenav-show   bg-gray-100">
    @if($errors->any())
    <span id="notifError" class="d-none">{{$errors->first()}}</span>
    <script>
    async function notifErrors() {
      await Swal.fire({
      title: 'Error!',
      text: '' + notifError.innerText,
      icon: 'error',
      //confirmButtonText: 'Cool'
    })
    }
    notifErrors();
    </script>
    @endif
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/img/Logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" style="display: block; margin: 0 auto; max-height: 70px;">
    </a>
    </div>
    <hr class="horizontal dark mt-3">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Discover</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('users*', 'or', 'models*') ? 'active' : ''}}" href="{{ url('/users') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengguna</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}" href="{{ url('/laporan') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-bar-32 text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('jadwal*') ? 'active' : '' }}" href="{{ url('/jadwal') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jadwal</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('kamera*') ? 'active' : '' }}" href="{{ url('/kamera') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-camera-compact text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kamera</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun Saya</h6>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ url('/profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ Auth::user()->name }}</span>
                </a>
            </li>
          <li class="nav-item active">
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Log Out</span>
            </a>
          </li>
      </ul>
  </div>
  
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    @yield('content')
  </main>
</body>
</html>
