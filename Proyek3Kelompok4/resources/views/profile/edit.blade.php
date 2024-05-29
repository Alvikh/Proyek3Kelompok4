<!doctype html>
<html lang="en">
<head>
  <title>User Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
    .profile-card {
      margin-top: 20px;
    }
    .profile-header {
      display: flex;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #ddd;
    }
    .profile-image {
      margin-right: 20px;
    }
    .profile-info h5 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }
    .profile-info p {
      margin: 0;
      color: #666;
    }
    .form-group label {
      font-weight: bold;
    }
  </style>
</head>
<body>

@include('layouts.sidebar')
@include('layouts.navbar')

<div class="container-fluid py-4">
  <div class="card shadow-lg mx-4 profile-card">
    <div class="card-body p-3">
      <div class="row gx-4 profile-header">
        <div class="col-auto profile-image">
          <div class="avatar avatar-xl position-relative">
            <img src="{{ Auth::user()->photo }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
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
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card mt-4">
        <div class="card-header pb-0">
          <h5 class="font-weight-bolder">Edit Profile</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <p class="text-uppercase text-sm">User Information</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="username" class="form-control-label">Username</label>
                  <input class="form-control" type="text" id="username" name="name" value="{{ Auth::user()->name }}">
                </div>
              </div>              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="form-control-label">Email address</label>
                  <input class="form-control" type="email" id="email" name="email" value="{{ Auth::user()->email }}">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="photo" class="form-control-label">Profile Photo</label>
                  <input class="form-control" type="file" id="photo" name="photo">
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Change Password</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password" class="form-control-label">New Password</label>
                  <input class="form-control" type="password" id="password" name="password">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password_confirmation" class="form-control-label">Confirm Password</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
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
</body>
</html>
