@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Karyawan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NIK</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $karyawan)
                <tr>
                    <td>{{ $karyawan->user->name }}</td>
                    <td>{{ $karyawan->user->email }}</td>
                    <td>{{ $karyawan->nik }}</td>
                    <td>{{ $karyawan->jabatan }}</td>
                    <td>{{ $karyawan->divisi }}</td>
                    <td>{{ $karyawan->no_hp ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $karyawans->links() }}
</div>
@endsection
