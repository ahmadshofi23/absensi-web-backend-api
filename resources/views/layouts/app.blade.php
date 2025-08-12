<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Absensi App - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="{{ url('admin/dashboard') }}">AbsensiApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item">
            <a href="{{ route('admin.karyawan.index') }}" class="nav-link">Karyawan</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.absensi.index') }}" class="nav-link">Absensi</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.cuti-izin.index') }}" class="nav-link">Cuti & Izin</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                  @csrf
                  <button type="submit" class="btn btn-link text-danger p-0">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
