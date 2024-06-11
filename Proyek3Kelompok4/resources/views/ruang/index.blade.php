@extends('layouts.sidebar')
@section('content')

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_nama_ruang" class="form-label">Nama Ruang:</label>
                        <input type="text" class="form-control" id="edit_nama_ruang" name="nama_ruang">
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ruang.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="edit_nama_ruang" class="form-label">Nama Ruang:</label>
                        <input type="text" class="form-control" id="edit_nama_ruang" name="nama_ruang">
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
                    <h4>Data Ruang</h4>
                    <button id="tambahMdl" type="button" class="btn btn-success" data-bs-target="#tambahModal">Tambah</button>
                </div>
                <div class="card-body pt-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2">#</th>
                                <th scope="col" class="px-2">Nama Ruang</th>
                                <th scope="col" class="px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruangs as $ruang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ruang->nama_ruang }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-target="#editModal"
                                            data-id="{{ $ruang->id }}"
                                            data-nama_ruang="{{ $ruang->nama_ruang }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('ruang.destroy', $ruang->id) }}" method="POST"
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

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var namaRuang = this.getAttribute('data-nama_ruang');

                editForm.action = '/ruang/update/' + id;
                editNamaRuang.value = namaRuang;

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