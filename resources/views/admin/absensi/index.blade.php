@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data Absensi</h3>

    {{-- Tombol Export Absensi --}}
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('admin.absensi.export') }}" class="btn btn-outline-primary btn-sm shadow-sm">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Absensi
        </a>
    </div>

    <form method="GET" action="{{ route('admin.absensi.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-4">
                <label for="karyawan_id" class="form-label fw-semibold">Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="form-select">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->user->name }} ({{ $karyawan->nik }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-primary text-center">
                <tr>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Pulang</th>
                    <th>Lokasi Masuk</th>
                    <th>Lokasi Pulang</th>
                    <th>Foto Masuk</th>
                    <th>Foto Pulang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($absensis as $absen)
                    <tr>
                        <td>
                            <strong>{{ $absen->karyawan->user->name }}</strong><br>
                            <small class="text-muted">{{ $absen->karyawan->nik }}</small>
                        </td>
                        <td class="text-center">{{ $absen->tanggal->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $absen->jam_masuk ?? '-' }}</td>
                        <td class="text-center">{{ $absen->jam_pulang ?? '-' }}</td>
                        <td>
                            @if($absen->lokasi_masuk)
                                <span class="badge bg-info text-dark">{{ $absen->lokasi_masuk }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($absen->lokasi_pulang)
                                <span class="badge bg-warning text-dark">{{ $absen->lokasi_pulang }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($absen->foto_masuk)
                                <img src="{{ asset('storage/'.$absen->foto_masuk) }}" alt="Foto Masuk" class="img-thumbnail" style="max-width: 70px; height: auto;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($absen->foto_pulang)
                                <img src="{{ asset('storage/'.$absen->foto_pulang) }}" alt="Foto Pulang" class="img-thumbnail" style="max-width: 70px; height: auto;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted fst-italic">Tidak ada data absensi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $absensis->withQueryString()->links() }}
    </div>
</div>
@endsection
