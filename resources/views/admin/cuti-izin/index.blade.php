@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="mb-4">Daftar Pengajuan Cuti & Izin</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Karyawan</th>
                    <th>Jenis</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cutiIzins as $cuti)
                <tr>
                    <td>{{ $cuti->id }}</td>
                    <td>{{ $cuti->karyawan->user->name }} <br><small class="text-muted">{{ $cuti->karyawan->nik }}</small></td>
                    <td>
                        <span class="badge bg-primary text-uppercase">{{ $cuti->jenis }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }}<br>
                        <small>s/d</small><br>
                        {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td>
                        @php
                            $statusClass = match($cuti->status) {
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'pending' => 'warning',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">{{ ucfirst($cuti->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.cuti-izin.show', $cuti->id) }}" class="btn btn-sm btn-info">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $cutiIzins->links() }}
    </div>
</div>
@endsection
