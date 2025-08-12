@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="mb-5 text-center text-primary fw-bold">Edit Karyawan</h3>

    <form id="editKaryawanForm" action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control form-control-lg" value="{{ old('name', $karyawan->user->name) }}" required autofocus>
            <div class="invalid-feedback">Nama wajib diisi.</div>
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ old('email', $karyawan->user->email) }}" required>
            <div class="invalid-feedback">Email tidak valid atau kosong.</div>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password <small class="text-muted">(kosongkan jika tidak ingin ganti)</small></label>
            <input type="password" id="password" name="password" class="form-control form-control-lg" autocomplete="new-password" placeholder="••••••••" minlength="6">
            <div class="invalid-feedback">Password minimal 6 karakter jika diisi.</div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" autocomplete="new-password" placeholder="••••••••" minlength="6">
            <div class="invalid-feedback">Konfirmasi password harus sama dengan password.</div>
        </div>

        <div class="mb-4">
            <label for="nik" class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
            <input type="text" id="nik" name="nik" class="form-control form-control-lg" value="{{ old('nik', $karyawan->nik) }}" required>
            <div class="invalid-feedback">NIK wajib diisi.</div>
        </div>

        <div class="mb-4">
            <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
            <input type="text" id="jabatan" name="jabatan" class="form-control form-control-lg" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
            <div class="invalid-feedback">Jabatan wajib diisi.</div>
        </div>

        <div class="mb-4">
            <label for="divisi" class="form-label fw-semibold">Divisi <span class="text-danger">*</span></label>
            <input type="text" id="divisi" name="divisi" class="form-control form-control-lg" value="{{ old('divisi', $karyawan->divisi) }}" required>
            <div class="invalid-feedback">Divisi wajib diisi.</div>
        </div>

        <div class="mb-4">
            <label for="no_hp" class="form-label fw-semibold">No HP</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control form-control-lg" value="{{ old('no_hp', $karyawan->no_hp) }}">
        </div>

        <hr class="my-4">

        <div class="mb-4">
            <label for="kontrak_kerja" class="form-label fw-semibold">Kontrak Kerja <small class="text-muted">(PDF, JPG, PNG)</small></label>
            <input class="form-control form-control-lg" type="file" id="kontrak_kerja" name="kontrak_kerja" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="mb-5">
            <label for="npwp" class="form-label fw-semibold">NPWP <small class="text-muted">(PDF, JPG, PNG)</small></label>
            <input class="form-control form-control-lg" type="file" id="npwp" name="npwp" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary btn-lg px-4">Batal</a>
            <button class="btn btn-primary btn-lg px-5" type="submit">Update</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    (() => {
        const form = document.getElementById('editKaryawanForm');
        const password = form.password;
        const passwordConfirmation = form.password_confirmation;

        // Function to check if email format valid
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        // Realtime validation handler
        form.addEventListener('input', e => {
            const target = e.target;

            if (target.required && !target.value.trim()) {
                target.classList.add('is-invalid');
                target.classList.remove('is-valid');
                return;
            }

            if (target.type === 'email') {
                if (!isValidEmail(target.value)) {
                    target.classList.add('is-invalid');
                    target.classList.remove('is-valid');
                    return;
                }
            }

            if (target.id === 'password') {
                if (target.value && target.value.length < 6) {
                    target.classList.add('is-invalid');
                    target.classList.remove('is-valid');
                    return;
                }
            }

            if (target.id === 'password_confirmation') {
                if (password.value !== target.value) {
                    target.classList.add('is-invalid');
                    target.classList.remove('is-valid');
                    return;
                }
            }

            target.classList.remove('is-invalid');
            target.classList.add('is-valid');
        });

        // On form submit validation
        form.addEventListener('submit', e => {
            let valid = true;

            // Check required fields
            [...form.elements].forEach(el => {
                if (el.required && !el.value.trim()) {
                    el.classList.add('is-invalid');
                    valid = false;
                }
            });

            // Email format
            if (!isValidEmail(form.email.value)) {
                form.email.classList.add('is-invalid');
                valid = false;
            }

            // Password length if filled
            if (form.password.value && form.password.value.length < 6) {
                form.password.classList.add('is-invalid');
                valid = false;
            }

            // Password confirmation match
            if (form.password.value !== form.password_confirmation.value) {
                form.password_confirmation.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    })();
</script>
@endsection
