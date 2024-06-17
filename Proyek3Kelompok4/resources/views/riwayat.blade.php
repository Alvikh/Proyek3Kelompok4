@extends('layouts.sidebar')
@section('content')
    <link href="{{ asset('assets/css/discover.css') }}" rel="stylesheet">
    <div class="container-fluid py-4">
        <div class="row justify-content-center mt-6">
            <div class="col-lg-6 mb-4 w-50">
                <div class="card" style="height: 400px;">
                    <div class="card-body p-0">
                        <h5 class="card-title mb-3" style="font-size:18px">Riwayat Kehadiran Hari Ini</h5>
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
    </div>
@endsection
