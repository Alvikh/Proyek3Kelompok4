@extends('layouts.sidebar')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-5">
                <div class="card-header">
                    Tambah Jadwal Baru
                </div>
                <div class="card-body">
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_hari">Nama Hari:</label>
                            <select name="nama_hari" id="nama_hari" class="form-control" required>
                                <option value="">Pilih Hari</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                    @if (!in_array($hari, $existingDays))
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="waktu_masuk">Waktu Masuk:</label>
                            <input type="time" name="waktu_masuk" id="waktu_masuk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_keluar">Waktu Pulang:</label>
                            <input type="time" name="waktu_keluar" id="waktu_keluar" class="form-control" required>
                            @error('waktu_keluar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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