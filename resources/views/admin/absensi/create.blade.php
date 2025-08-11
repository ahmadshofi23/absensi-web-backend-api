@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Absensi Manual</h3>

    <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="karyawan_id">Karyawan</label>
            <select name="karyawan_id" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}">{{ $karyawan->user->name }} ({{ $karyawan->nik }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="waktu_masuk">Waktu Masuk</label>
            <input type="time" name="waktu_masuk" class="form-control">
        </div>

        <div class="mb-3">
            <label for="waktu_pulang">Waktu Pulang</label>
            <input type="time" name="waktu_pulang" class="form-control">
        </div>

        <div class="mb-3">
            <label for="lokasi">Lokasi</label>
            <input type="text" name="lokasi" class="form-control">
        </div>

        <div class="mb-3">
            <label for="foto_selfie">Foto Selfie (opsional)</label>
            <input type="file" name="foto_selfie" class="form-control">
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</div>
@endsection
