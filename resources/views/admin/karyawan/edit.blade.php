@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Karyawan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $karyawan->user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $karyawan->user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak ingin ganti)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik', $karyawan->nik) }}" required>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
        </div>

        <div class="mb-3">
            <label>Divisi</label>
            <input type="text" name="divisi" class="form-control" value="{{ old('divisi', $karyawan->divisi) }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $karyawan->no_hp) }}">
        </div>

        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
