@extends('layouts.sidebar')
@section('content')

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kamera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Gedung:</label>
                        <select class="form-select" name="gedung_id" id="edit_gedung" required>
                            <option selected>Pilih gedung</option>
                            @foreach ($gedungs as $gedung)
                                <option value="{{ $gedung->id }}">{{ $gedung->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ruang:</label>
                        <select class="form-select" name="ruang_id" id="edit_ruang" required>
                            <option selected>Pilih ruang</option>
                            @foreach ($ruangs as $ruang)
                                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_kamera" class="form-label">Nama Kamera:</label>
                        <input type="text" class="form-control" id="edit_nama_kamera" name="nama_kamera">
                    </div>
                    <div class="mb-3">
                        <label for="edit_sumber" class="form-label">Sumber:</label>
                        <input type="text" class="form-control" id="edit_sumber" name="sumber">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status:</label>
                        <select class="form-control" id="edit_status" name="status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Kamera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kamera.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="edit_nama_ruang" class="form-label">Nama Gedung:</label>
                        {{-- <input type="text" class="form-control" id="edit_nama_ruang" name="nama_ruang"> --}}
                        
                        <select class="form-select" name="gedung_id" required>
                            <option selected>Pilih gedung</option>
                            @foreach ($gedungs as $gedung)
                                <option value="{{ $gedung->id }}">{{ $gedung->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ruang:</label>
                        {{-- <input type="text" class="form-control" id="edit_nama_kamera" name="nama_kamera"> --}}
                        <select class="form-select" name="ruang_id" required>
                            <option selected>Pilih ruang</option>
                            @foreach ($ruangs as $ruang)
                                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kamera:</label>
                        <input type="text" class="form-control" id="edit_nama_kamera" name="nama_kamera">
                    </div>
                    <div class="mb-3">
                        <label for="edit_sumber" class="form-label">Sumber:</label>
                        <input type="text" class="form-control" id="edit_sumber" name="sumber">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status:</label>
                        <select class="form-control" id="edit_status" name="status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Data Kamera</h4>
                    {{-- <a href="{{ route('kamera.create') }}" class="btn btn-success mb-3">Tambah</a> --}}
                    <button id="tambahMdl" type="button" class="btn btn-success" data-bs-target="#tambahModal">Tambah</button>
                </div>
                <div class="card-body pt-0 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2">#</th>
                                <th scope="col" class="px-2">Nama Gedung</th>
                                <th scope="col" class="px-2">Nama Ruang</th>
                                <th scope="col" class="px-2">Nama Kamera</th>
                                <th scope="col" class="px-2">Sumber Kamera (IP)</th>
                                <th scope="col" class="px-2">Status</th>
                                <th scope="col" class="px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kameras as $kamera)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kamera->nama_gedung }}</td>
                                    <td>{{ $kamera->nama_ruang }}</td>
                                    <td>{{ $kamera->nama_kamera }}</td>
                                    <td>{{ $kamera->sumber }}</td>
                                    <td>
                                        @if ($kamera->status == 'aktif')
                                            <span class="text-success">Aktif</span>
                                        @else
                                            <span class="text-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-target="#editModal"
                                            data-id="{{ $kamera->id }}"
                                            data-gedung_id="{{ $kamera->gedung_id }}"
                                            data-ruang_id="{{ $kamera->ruang_id }}"
                                            data-nama_kamera="{{ $kamera->nama_kamera }}"
                                            data-sumber="{{ $kamera->sumber }}"
                                            data-status="{{ $kamera->status }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('kamera.destroy', $kamera->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editButtons = document.querySelectorAll('.btn-warning');
        var editModal = document.getElementById('editModal');
        var editForm = document.getElementById('editForm');
        var editNamaRuang = document.getElementById('edit_nama_ruang');
        var editNamaKamera = document.getElementById('edit_nama_kamera');
        var editSumber = document.getElementById('edit_sumber');
        var editStatus = document.getElementById('edit_status');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var gedung = this.getAttribute('data-gedung_id');
                var ruang = this.getAttribute('data-ruang_id');
                var namaKamera = this.getAttribute('data-nama_kamera');
                var sumber = this.getAttribute('data-sumber');
                var status = this.getAttribute('data-status');

                editForm.action = '/kamera/update/' + id;
                editNamaKamera.value = namaKamera;
                editSumber.value = sumber;
                editStatus.value = status;

                var editGedungSelect = document.getElementById('edit_gedung');
                for (var i = 0; i < editGedungSelect.options.length; i++) {
                    if (editGedungSelect.options[i].value === gedung) {
                        editGedungSelect.options[i].selected = true;
                        break;
                    }
                }

                var editRuangSelect = document.getElementById('edit_ruang');
                for (var i = 0; i < editRuangSelect.options.length; i++) {
                    if (editRuangSelect.options[i].value === ruang) {
                        editRuangSelect.options[i].selected = true;
                        break;
                    }
                }

                var modal = new bootstrap.Modal(editModal);
                modal.show();
            });
        });

        var tambahButton = document.getElementById('tambahMdl');
        tambahButton.addEventListener('click', function () {
            var tambahModal = document.getElementById('tambahModal');
            var modal = new bootstrap.Modal(tambahModal);
            modal.show();
        });
    });
</script>
@endsection