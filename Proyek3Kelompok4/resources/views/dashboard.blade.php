@extends('layouts.sidebar')
{{-- @include('layouts.navbar') --}}
@section('content')
<link href="{{ asset('assets/css/discover.css') }}" rel="stylesheet">
<div class="container-fluid py-4">
    <div class="col d-flex w-100 gap-3">
        <div id="btn_pilihkamera" class="d-flex form-group">
            <select id="gedungSelect" class="form-control" style="margin-left:0">
                <option value="">Pilih Gedung</option>
                @foreach ($gedung as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_gedung }}</option>
                @endforeach
            </select>
            <select id="ruangSelect" class="form-control d-none">
                <option value="">Pilih Ruang</option>
            </select>
            <select id="kameraSelect" class="form-control d-none">
                <option value="">Pilih Kamera</option>
            </select>
        </div>
        <div id="btn_aktifkan" class="btn btn-danger d-none" onclick="aktifkan()">Mulai Deteksi</div>
    </div>
    
    <div class="row">
        <div class="col-lg-6 mb-4 w-60">
            <div class="card canvas-container" style="height: 400px;">
                <style>
                    canvas {position: fixed !important;}
                    .hiddenCam { opacity: 0; position: absolute; visibility: hidden; }
                    .showCam { opacity: 1; position: relative; visibility: visible; }
                </style>
                <div class="d-flex justify-content-center">
                    @foreach ($kamera as $d)
                        <img id="videoInput{{ $loop->iteration }}" class="deteksiKamera hiddenCam" src="{{ $d->sumber }}" data-id="{{ $d->id }}" alt="{{ $d->nama_gedung }} - {{ $d->nama_ruang }}" width="480" height="360" crossorigin="anonymous">
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
            <div class="dashboard gap-0 mt-3">
                <div class="card" style="width: 49%; height: 150px;">
                    <div class="card-title">Jumlah Pegawai</div>
                    <div class="card-value-container">
                        <div class="card-icon"><i class="bi bi-people"></i></div>
                        <div class="card-value" id="jumlahPegawai">{{ $jumlahPegawai }}</div>
                    </div>
                </div>
                <div class="card" style="width: 49%; height: 150px;">
                    <div class="card-title">Pegawai Masuk Hari Ini</div>
                    <div class="card-value-container">
                        <div class="card-icon"><i class="bi bi-person-check"></i></div>
                        <div class="card-value" id="jumlahPegawaiMasukHariIni">{{ $jumlahPegawaiMasukHariIni }}</div>
                    </div>
                </div>
                <script>
                    function ambilDataPegawaiBaru() {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', '/absensi/pegawai/terbaru', true);
                
                        xhr.onload = function() {
                            if (xhr.status >= 200 && xhr.status < 400) {
                                const data = JSON.parse(xhr.responseText);
                                document.getElementById('jumlahPegawai').innerText = data.jumlahPegawai;
                                document.getElementById('jumlahPegawaiMasukHariIni').innerText = data.jumlahPegawaiMasukHariIni;
                            }
                        };
                
                        xhr.send();
                    }
                </script>
                {{-- 
                    <div class="card" style="width: 25%; height: 150px;">
                        <div class="card-title">Waktu Masuk</div>
                        <div class="card-value-container">
                            <div class="card-icon"><i class="bi bi-clock"></i></div>
                            <div class="card-value">{{ \Carbon\Carbon::parse($jadwal->waktu_masuk)->format('H:i') }}</div>
                        </div>
                    </div>
                    <div class="card" style="width: 25%; height: 150px;">
                        <div class="card-title">Waktu Pulang</div>
                        <div class="card-value-container">
                            <div class="card-icon"><i class="bi bi-clock-history"></i></div>
                            <div class="card-value">{{ \Carbon\Carbon::parse($jadwal->waktu_keluar)->format('H:i') }}</div>
                        </div>
                    </div>
                --}}
            </div>
        </div>
        <div class="col-lg-6 mb-4 w-40">
            <div class="card" style="height: 100%;">
                <div class="card-body p-0">
                    <h5 class="card-title mb-3" style="font-size:18px">Riwayat Pendeteksian Awal Hari Ini</h5>
                    <ul id="absensi-list" class="dropdown-menu show position-relative m-0 p-0">
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
                                                    <i>{{ $data->keterangan }}</i>
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

    <script>
        function ambilDataAbsensiBaru() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/absensi/terbaru', true);
    
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    const data = JSON.parse(xhr.responseText);
                    const absensiList = document.getElementById('absensi-list');
                    absensiList.innerHTML = '';
    
                    data.forEach(function(absensi) {
                        const newItem = document.createElement('li');
                        newItem.classList.add('mb-2');
    
                        newItem.innerHTML = `
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="${absensi.profil_user}" class="avatar avatar-sm me-3">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">${absensi.nama_user}</span> -
                                            ${absensi.waktu_masuk ? '<i>' + absensi.keterangan + '</i>' : '<i>Keluar</i>'}
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1" aria-hidden="true"></i>
                                            ${absensi.waktu_masuk ? absensi.waktu_masuk + ' WIB' : absensi.waktu_keluar + ' WIB'}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        `;
    
                        absensiList.appendChild(newItem);
                    });
                }
            };
    
            xhr.send();

            setTimeout(() => {
                ambilDataPegawaiBaru();
            }, 300);
        }
    
        setInterval(ambilDataAbsensiBaru, 6666);
    
        ambilDataAbsensiBaru();
    </script>
    
    
    
</div>
@endsection