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
                                        value="2024">
                                </div>
                            </div>
                            <div class="form-group col mb-3">
                                <label for="bulan" class="col-sm-3 col-form-label">Bulan:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="bulan" name="bulan">
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05" selected>Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col mb-3">
                                <button type="submit" class="col-sm-5 btn btn-primary">Tampilkan</button>
                                <a class="btn btn-success col-sm-5"
                                    href="ekspor_rekap">Excel</a>
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
                                    <!--<td>
                                        <a href="{{ route('models.index', ['id' => $d->id]) }}" class="btn btn-warning">Datasets</a>
                                        <a href="{{ route('users.edit', $d->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('users.destroy', $d->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>-->
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