@extends('layouts.sidebar')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Ubah Data Pengguna</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah <i class='text-danger'>password</i>, ya!</small>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" class="form-control" required>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto Profil:</label>
                            <input type="file" name="photo" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-primary">Oke, simpan!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection