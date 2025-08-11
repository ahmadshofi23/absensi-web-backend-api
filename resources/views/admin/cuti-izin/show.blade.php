@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="mb-4">Detail Pengajuan Cuti/Izin</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $cutiIzin->karyawan->user->name }} <small class="text-muted">({{ $cutiIzin->karyawan->nik }})</small></h5>

            <p><strong>Jenis:</strong> <span class="badge bg-primary text-uppercase">{{ $cutiIzin->jenis }}</span></p>
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($cutiIzin->tanggal_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($cutiIzin->tanggal_selesai)->format('d M Y') }}</p>
            <p><strong>Alasan:</strong> {!! nl2br(e($cutiIzin->alasan ?? '-')) !!}</p>
            <p><strong>Status:</strong> 
                @php
                    $statusClass = match($cutiIzin->status) {
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        'pending' => 'warning',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($cutiIzin->status) }}</span>
            </p>

            @if($cutiIzin->surat_dokter)
            <p><strong>Surat Dokter:</strong> 
                <a href="{{ asset('storage/'.$cutiIzin->surat_dokter) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Lihat File
                </a>
            </p>
            @endif
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Update Status Pengajuan</h5>

            <form method="POST" action="{{ route('admin.cuti-izin.update', $cutiIzin->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ $cutiIzin->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ $cutiIzin->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $cutiIzin->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Update Status
                </button>
                <a href="{{ route('admin.cuti-izin.index') }}" class="btn btn-secondary ms-2">Kembali ke Daftar</a>
            </form>
        </div>
    </div>
</div>
@endsection
