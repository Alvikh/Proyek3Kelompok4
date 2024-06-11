@extends('layouts.sidebar')
@section('content')

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Gedung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Gedung:</label>
                        <input type="text" class="form-control" id="edit_nama_gedung" name="nama_gedung">
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah Gedung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gedung.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Gedung:</label>
                        <input type="text" class="form-control" name="nama_gedung">
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
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Data Gedung</h4>
                    <button id="tambahMdl" type="button" class="btn btn-success" data-bs-target="#tambahModal">Tambah</button>
                </div>
                <div class="card-body pt-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2">#</th>
                                <th scope="col" class="px-2">Nama Gedung</th>
                                <th scope="col" class="px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gedungs as $gedung)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $gedung->nama_gedung }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-target="#editModal"
                                            data-id="{{ $gedung->id }}"
                                            data-nama_gedung="{{ $gedung->nama_gedung }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('gedung.destroy', $gedung->id) }}" method="POST"
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
        var editNamaGedung = document.getElementById('edit_nama_gedung');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var namaGedung = this.getAttribute('data-nama_gedung');

                editForm.action = '/gedung/update/' + id;
                editNamaGedung.value = namaGedung;

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