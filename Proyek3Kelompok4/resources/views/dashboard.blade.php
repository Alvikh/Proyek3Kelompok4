<!doctype html>
<html lang="en">
<head>
  <title>AutoAttend Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #f8f9fa, #e9ecef);
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
    }
    .container-fluid {
      padding: 20px;
    }
    .btn-danger {
      background-color: #ff4d4d;
      border: none;
      transition: background-color 0.3s, transform 0.3s;
    }
    .btn-danger:hover {
      background-color: #ff3333;
      transform: scale(1.05);
    }
    .form-group select {
      margin-left: 10px;
    }
    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card-title {
      color: #888;
      font-size: 18px;
      margin-bottom: 10px;
    }
    .card-value-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    .card-value {
      color: #4a4af2;
      font-size: 36px;
      font-weight: bold;
    }
    .card-icon {
      display: inline-block;
      width: 50px;
      height: 50px;
      background: #4a4af2;
      border-radius: 50%;
      color: white;
      line-height: 50px;
      text-align: center;
      font-size: 24px;
    }
    .card-icon i {
      vertical-align: middle;
    }
    .dropdown-menu {
      width: 100%;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .dropdown-item {
      padding: 10px;
      border-bottom: 1px solid #e9ecef;
      transition: background-color 0.3s;
    }
    .dropdown-item:hover {
      background-color: #f1f1f1;
    }
    .avatar {
      border-radius: 50%;
    }
    .dashboard {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: space-between;
    }
    .canvas-container {
      position: relative;
    }
    .deteksiKamera {
      transform: scaleX(-1);
      text-indent: -9999px;
    }
  </style>
</head>
<body>
@include('layouts.sidebar')
<div class="container-fluid py-4">
    <div class="col d-flex w-100 gap-3 mb-4">
        <div id="btn_aktifkan" class="btn btn-danger" onclick="aktifkan()">Mulai Deteksi</div>
        <div id="btn_pilihkamera" class="d-flex form-group">
            <select id="cameraSelect" class="form-control">
                @foreach ($kamera as $d)
                    <option value="videoInput{{ $loop->iteration }}">{{ $d->nama_ruang }} - {{ $d->nama_kamera }}</option>
                @endforeach  
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card canvas-container" style="height: 400px;">
                <style>
                    canvas {position: absolute;}
                    .hiddenCam { opacity: 0; position: absolute; visibility: hidden; }
                    .showCam { opacity: 1; position: relative; visibility: visible; }
                </style>
                <div class="d-flex justify-content-center">
                    @foreach ($kamera as $d)
                        <img id="videoInput{{ $loop->iteration }}" class="deteksiKamera hiddenCam" src="{{ $d->sumber }}" alt="{{ $d->nama_ruang }} - {{ $d->nama_kamera }}" width="320" height="240" crossorigin="anonymous">
                    @endforeach  
                    <video id="lokalKamera" class="deteksiKamera d-none" width="320" height="240" autoplay muted></video>
                    <style>.deteksiKamera {-webkit-transform: scaleX(-1);transform: scaleX(-1);text-indent:-9999px}</style>
                        <script defer async src="{{ asset('assets/js/face-api.min.js') }}"></script>
                        <script>
                            const labelOrang = @json($labels);
                            var labels = labelOrang;
                        </script>
                        <script async src="{{ asset('assets/js/script.js') }}"></script>
                </div>
                <p class="d-none text-center mt-2">Orang dalam pantauan: <span id="orang"></span></p>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card" style="height: 400px;">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Kehadiran</h5>
                    <ul class="dropdown-menu show position-relative m-0 p-0">
                        @foreach ($absensi as $data)
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="{{ asset($data->profil_user) }}" class="avatar avatar-sm  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">{{ $data->nama_user }}</span> -
                                                @if (!is_null($data->waktu_masuk))
                                                    <i>Masuk</i>
                                                @else
                                                    <i>Keluar</i>
                                                @endif
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1" aria-hidden="true"></i>
                                                @if (!is_null($data->waktu_masuk))
                                                    {{ $data->waktu_masuk }} WIB
                                                @else
                                                    {{ $data->waktu_keluar }} WIB
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard mt-4">
        <div class="card" style="width: 23%; height: 150px;">
            <div class="card-title">Jumlah Pegawai</div>
            <div class="card-value-container">
                <div class="card-icon"><i class="bi bi-people"></i></div>
                <div class="card-value">100</div>
            </div>
        </div>
        <div class="card" style="width: 23%; height: 150px;">
            <div class="card-title">Pegawai Masuk Hari Ini</div>
            <div class="card-value-container">
                <div class="card-icon"><i class="bi bi-person-check"></i></div>
                <div class="card-value">70</div>
            </div>
        </div>
        <div class="card" style="width: 23%; height: 150px;">
            <div class="card-title">Waktu Masuk</div>
            <div class="card-value-container">
                <div class="card-icon"><i class="bi bi-clock"></i></div>
                <div class="card-value">07.00</div>
            </div>
        </div>
        <div class="card" style="width: 23%; height: 150px;">
            <div class="card-title">Waktu Pulang</div>
            <div class="card-value-container">
                <div class="card-icon"><i class="bi bi-clock-history"></i></div>
                <div class="card-value">15.00</div>
            </div>
        </div>
    </div>
</div>

<!-- Core JS Files -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>
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
<script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
