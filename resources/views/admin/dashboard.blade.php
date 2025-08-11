@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-5 text-center fw-bold text-primary">Dashboard Admin</h1>

    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-white bg-primary h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
                    <h5 class="card-title text-uppercase fw-semibold mb-3">Total Karyawan</h5>
                    <p class="display-3 fw-bold mb-0">{{ $totalKaryawan }}</p>
                    <i class="bi bi-people-fill fs-1 mt-3 opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-white bg-success h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
                    <h5 class="card-title text-uppercase fw-semibold mb-3">Total Absensi</h5>
                    <p class="display-3 fw-bold mb-0">{{ $totalAbsensi }}</p>
                    <i class="bi bi-check2-square fs-1 mt-3 opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 text-white bg-warning h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
                    <h5 class="card-title text-uppercase fw-semibold mb-3">Total Pengajuan Cuti/Izin</h5>
                    <p class="display-3 fw-bold mb-0">{{ $totalCutiIzin }}</p>
                    <i class="bi bi-file-earmark-text-fill fs-1 mt-3 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold text-secondary">Statistik Absensi Bulanan</h5>
        </div>
        <div class="card-body p-4">
            <canvas id="absensiChart" height="120" style="max-height: 400px;"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('absensiChart').getContext('2d');
    const absensiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Jumlah Absensi',
                data: {!! json_encode($monthlyAbsensiCounts) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.8)', // Bootstrap primary 600 with opacity
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 2,
                borderRadius: 6,
                maxBarThickness: 50,
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#6c757d',
                        font: {
                            size: 14,
                        }
                    },
                    grid: {
                        color: '#e9ecef'
                    }
                },
                x: {
                    ticks: {
                        color: '#495057',
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#495057',
                        font: {
                            size: 16,
                            weight: '700'
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(13,110,253,0.8)',
                    titleFont: { weight: 'bold', size: 14 },
                    bodyFont: { size: 14 },
                }
            }
        }
    });
</script>
@endsection
