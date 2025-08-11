@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="mb-4 text-center text-primary fw-bold">Daftar Karyawan</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Karyawan
        </a>

        <form class="d-flex" method="GET" action="{{ route('admin.karyawan.index') }}">
            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Cari nama, NIK..." aria-label="Search" value="{{ request('search') }}">
            <button class="btn btn-outline-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="table-primary text-uppercase text-center small">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                    <th>No HP</th>
                    <th style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $karyawan)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $karyawan->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($karyawan->user->name).'&background=0D8ABC&color=fff' }}" alt="Foto {{ $karyawan->user->name }}" class="rounded-circle me-3" width="40" height="40" />
                                <div>
                                    <strong>{{ $karyawan->user->name }}</strong><br>
                                    <small class="text-muted">{{ $karyawan->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{ $karyawan->user->email }}</td>
                        <td class="text-center">{{ $karyawan->nik }}</td>
                        <td class="text-center">{{ $karyawan->jabatan }}</td>
                        <td class="text-center">{{ $karyawan->divisi }}</td>
                        <td class="text-center">{{ $karyawan->no_hp ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" title="Edit Karyawan">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus karyawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus Karyawan">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted fst-italic">Tidak ada data karyawan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $karyawans->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection
