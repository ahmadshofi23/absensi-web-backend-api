<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\CutiIzin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();
        $totalAbsensi = Absensi::count();
        $totalCutiIzin = CutiIzin::count();

        // Siapkan data bulan dan jumlah absensi per bulan selama 6 bulan terakhir
        $months = [];
        $monthlyAbsensiCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y'); // Jan 2025, Feb 2025, etc.

            $count = Absensi::whereYear('tanggal', $month->year)
                            ->whereMonth('tanggal', $month->month)
                            ->count();

            $monthlyAbsensiCounts[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalKaryawan', 'totalAbsensi', 'totalCutiIzin', 'months', 'monthlyAbsensiCounts'
        ));
    }
}
