@include('layouts.sidebar')
@include('layouts.navbar')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mt-8">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Daftar Model Deteksi Wajah</h4>
                    <a href="{{ route('models.create', ['id' => $user->id]) }}" class="btn btn-success">Tambah</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center px-0">#</th>
                                    <th>Gambar</th>
                                    <th>Nama Pengguna</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($models as $model)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($model->gambar) }}" alt="{{ $model->gambar }}" style="max-width: 100px;" class="model-image"></td>
                                    <td>{{ $model->user->name }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('models.destroy', $model->id) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var images = document.querySelectorAll('.model-image');

        images.forEach(function(image) {
            image.addEventListener('click', function() {
                var src = this.getAttribute('src');
                Swal.fire({
                    imageUrl: src,
                    imageAlt: 'Model Image',
                    confirmButtonText: 'Oke, sip!',
                });
            });
        });
    });
</script>