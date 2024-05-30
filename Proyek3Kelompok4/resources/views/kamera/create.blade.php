@extends('layouts.sidebar')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Tambah Data Kamera</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kamera.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_ruang">Nama Ruang:</label>
                            <input type="text" name="nama_ruang" id="nama_ruang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_kamera">Nama Kamera:</label>
                            <input type="text" name="nama_kamera" id="nama_kamera" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="sumber">Sumber Kamera (IP):</label>
                            <input type="text" name="sumber" id="sumber" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection