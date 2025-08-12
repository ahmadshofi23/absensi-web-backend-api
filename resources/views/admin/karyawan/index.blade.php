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

    {{-- Tombol Import dan Export --}}
    <div class="mb-3 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
        <button type="button" class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-arrow-up"></i> Import Excel/CSV
        </button>

        <a href="{{ route('admin.karyawan.export') }}" class="btn btn-outline-primary btn-sm shadow-sm" title="Export Data Karyawan">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Data Karyawan
        </a>

        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary shadow-sm ms-auto">
            <i class="bi bi-plus-lg me-2"></i>Tambah Karyawan
        </a>
    </div>

    {{-- Pencarian --}}
    <form class="d-flex mb-3 justify-content-center justify-content-md-end" method="GET" action="{{ route('admin.karyawan.index') }}">
        <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Cari nama, NIK..." aria-label="Search" value="{{ request('search') }}" style="max-width: 300px;">
        <button class="btn btn-outline-primary btn-sm" type="submit" title="Cari">
            <i class="bi bi-search"></i>
        </button>
    </form>

    {{-- Tabel Karyawan --}}
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
                                <img src="{{ $karyawan->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($karyawan->user->name).'&background=0D8ABC&color=fff' }}" alt="Foto {{ $karyawan->user->name }}" class="rounded-circle me-3 shadow" width="45" height="45" />
                                <div class="text-start">
                                    <strong>{{ $karyawan->user->name }}</strong><br>
                                    <small class="text-muted">{{ $karyawan->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">{{ $karyawan->user->email }}</td>
                        <td class="text-center align-middle">{{ $karyawan->nik }}</td>
                        <td class="text-center align-middle">{{ $karyawan->jabatan }}</td>
                        <td class="text-center align-middle">{{ $karyawan->divisi }}</td>
                        <td class="text-center align-middle">{{ $karyawan->no_hp ?? '-' }}</td>
                        <td class="text-center align-middle">
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" title="Edit Karyawan">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger btn-delete"
                                data-bs-toggle="tooltip"
                                title="Hapus Karyawan"
                                data-id="{{ $karyawan->id }}"
                                data-name="{{ $karyawan->user->name }}"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
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

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $karyawans->links() }}
    </div>
</div>

<!-- Modal Import File -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.karyawan.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">Pilih file Excel/CSV</label>
            <input class="form-control" type="file" id="file" name="file" accept=".xls,.xlsx,.csv" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-upload"></i> Upload
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" id="deleteForm" class="modal-content">
        @csrf
        @method('DELETE')
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus karyawan <strong id="deleteName"></strong>?</p>
        <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
    // Tooltip enable
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Modal Delete handler
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const deleteName = document.getElementById('deleteName');

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            deleteName.textContent = name;
            deleteForm.action = `/admin/karyawan/${id}`;
            deleteModal.show();
        });
    });
</script>
@endsection
