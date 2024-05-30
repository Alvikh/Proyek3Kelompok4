@extends('layouts.sidebar')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>Data Pengguna</h4>
                    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Tambah</a>
                </div>
                <div class="card-body pt-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="px-2">Nama</th>
                                <th class="px-2">Email</th>
                                <th class="px-2">Role</th>
                                <th class="px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>@if($user->role == "user") Pegawai @else Administrator @endif</td>
                                    <td>
                                        <a href="{{ route('models.index', ['id' => $user->id]) }}" class="btn btn-warning">Datasets</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline">
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
@endsection