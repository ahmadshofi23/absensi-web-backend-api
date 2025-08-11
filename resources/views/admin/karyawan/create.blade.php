@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="mb-4 text-center text-primary fw-bold">Tambah Karyawan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.karyawan.store') }}" method="POST" class="mx-auto" style="max-width: 600px;" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="nik" class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
            <input type="text" id="nik" name="nik" class="form-control" value="{{ old('nik') }}" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
            <input type="text" id="jabatan" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
        </div>

        <div class="mb-3">
            <label for="divisi" class="form-label fw-semibold">Divisi <span class="text-danger">*</span></label>
            <input type="text" id="divisi" name="divisi" class="form-control" value="{{ old('divisi') }}" required>
        </div>

        <div class="mb-4">
            <label for="no_hp" class="form-label fw-semibold">No HP</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-primary px-5">Simpan</button>
        </div>
    </form>
</div>
@endsection
