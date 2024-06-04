@extends('layouts.sidebar')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Riwayat Kehadiran</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="get" action="">
                        <div class="input-group mb-3">
                            <div class="form-group col mb-3">
                                <label for="tahun" class="col-sm-3 col-form-label">Tahun:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tahun" name="tahun"
                                        value="{{ request('tahun', date('Y')) }}">
                                </div>
                            </div>
                            <div class="form-group col mb-3">
                                <label for="bulan" class="col-sm-3 col-form-label">Bulan:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="bulan" name="bulan">
                                        @foreach ([
                                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                                            '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                        ] as $key => $value)
                                            <option value="{{ $key }}" 
                                                {{ request('bulan', date('m')) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col mb-3">
                                <button type="submit" class="col-sm-5 btn btn-primary">Tampilkan</button>
                                <a class="btn btn-success col-sm-5" href="ekspor_rekap">Excel</a>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="px-2">Tanggal</th>
                                <th class="px-2">Nama</th>
                                <th class="px-2">Waktu Masuk</th>
                                <th class="px-2">Waktu Pulang</th>
                                <th class="px-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $d)
                                <tr>
                                    <td>{{ $d->f_tanggal }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->f_waktu_masuk }}</td>
                                    <td>{{ $d->f_waktu_keluar }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {!! $laporan->links() !!}
                    </div>
                </div>
            </div>            

        </div>
    </div>
</div>
@endsection