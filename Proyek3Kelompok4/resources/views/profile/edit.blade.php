  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .profile-card {
      margin-top: 20px;
      border-radius: 15px;
    }
    .profile-header {
      display: flex;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #ddd;
      background: linear-gradient(60deg, #4a90e2, #50a3a2);
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      color: white;
    }
    .profile-image img {
      border-radius: 10%;
      border: 3px solid #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .profile-info h5 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }
    .profile-info p {
      margin: 0;
      color: #ddd;
    }
    .form-group label {
      font-weight: bold;
      color: #495057;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    .form-control {
      border-radius: 10px;
      transition: all 0.3s;
    }
    .form-control:focus {
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      border-color: #80bdff;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      transition: all 0.3s;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>


@extends('layouts.sidebar')
@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-lg mx-4 profile-card">
    <div class="card-body p-3">
      <div class="row gx-4 profile-header">
        <div class="col-auto profile-image">
          <div class="avatar avatar-xl position-relative">
            <img src="{{ Auth::user()->photo }}" alt="foto profile" class="w-100 border-radius-lg shadow-sm">
          </div>
        </div>
        <div class="col-auto my-auto profile-info">
          <div class="h-100">
            <h5 class="mb-1">
              {{ Auth::user()->name }}
            </h5>
            <p class="mb-0 font-weight-bold text-sm">
              {{ Auth::user()->email }}
            </p>
          </div>
        </div>
      </div>
      <hr>
      <!-- Edit Profile Form -->
      <div class="card mt-4 mt-md-0">
        <div class="card-header pb-0">
          <h5 class="font-weight-bolder">Profile</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="text-uppercase text-sm">Informasi User</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="username" class="form-control-label">Username</label>
                  <input class="form-control" type="text" id="username" name="name" value="{{ Auth::user()->name }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="form-control-label">Email</label>
                  <input class="form-control" type="email" id="email" name="email" value="{{ Auth::user()->email }}">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="photo" class="form-control-label">Foto Profile</label>
                  <input class="form-control" type="file" id="photo" name="photo">
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Ganti Password</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password" class="form-control-label">Password Baru</label>
                  <input class="form-control" type="password" id="password" name="password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password_confirmation" class="form-control-label">Konfirmasi Password</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Core JS Files -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
@endsection
