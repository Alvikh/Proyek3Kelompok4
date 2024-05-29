@include('layouts.sidebar')
@include('layouts.navbar')

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk edit jadwal -->
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_nama_hari" class="form-label">Hari:</label>
                        <input type="text" class="form-control" id="edit_nama_hari" name="nama_hari" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_masuk" class="form-label">Waktu Masuk:</label>
                        <input type="time" class="form-control" id="edit_waktu_masuk" name="waktu_masuk">
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_keluar" class="form-label">Waktu Pulang:</label>
                        <input type="time" class="form-control" id="edit_waktu_keluar" name="waktu_keluar">
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
            <div class="card mt-8">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Data Jadwal</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2">No</th>
                                <th scope="col" class="px-2">Hari</th>
                                <th scope="col" class="px-2">Waktu Masuk</th>
                                <th scope="col" class="px-2">Waktu Pulang</th>
                                <th scope="col" class="px-2">Status</th>
                                <th scope="col" class="px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jadwal->nama_hari }}</td>
                                    <td>{{ $jadwal->waktu_masuk }}</td>
                                    <td>{{ $jadwal->waktu_keluar }}</td>
                                    <td>
                                        @if ($jadwal->status == 'aktif')
                                            <span class="text-success">Aktif</span>
                                        @else
                                            <span class="text-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            data-bs-target="#editModal"
                                            data-id="{{ $jadwal->id }}"
                                            data-nama_hari="{{ $jadwal->nama_hari }}"
                                            data-waktu_masuk="{{ $jadwal->waktu_masuk }}"
                                            data-waktu_keluar="{{ $jadwal->waktu_keluar }}"
                                            data-status="{{ $jadwal->status }}">
                                            Edit
                                        </button>
                                        <!--<form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>-->
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
        var editNamaHari = document.getElementById('edit_nama_hari');
        var editWaktuMasuk = document.getElementById('edit_waktu_masuk');
        var editWaktuKeluar = document.getElementById('edit_waktu_keluar');
        var editStatus = document.getElementById('edit_status');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var namaHari = this.getAttribute('data-nama_hari');
                var waktuMasuk = this.getAttribute('data-waktu_masuk');
                var waktuKeluar = this.getAttribute('data-waktu_keluar');
                var status = this.getAttribute('data-status');

                editForm.action = '/jadwal/update/' + id;
                editNamaHari.value = namaHari;
                editWaktuMasuk.value = waktuMasuk;
                editWaktuKeluar.value = waktuKeluar;
                editStatus.value = status;

                var modal = new bootstrap.Modal(editModal);
                modal.show();
            });
        });

    });
</script>
