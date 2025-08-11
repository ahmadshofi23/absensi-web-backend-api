<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal dan karyawan
        $query = \App\Models\Absensi::query()->with('karyawan.user');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        $absensis = $query->orderBy('tanggal', 'desc')->paginate(20);
        $karyawans = \App\Models\Karyawan::with('user')->get();

        return view('admin.absensi.index', compact('absensis', 'karyawans'));
    }


        public function create()
    {
        $karyawans = \App\Models\Karyawan::with('user')->get();
        return view('admin.absensi.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_pulang' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
            'lokasi' => 'nullable|string',
            'foto_selfie' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['karyawan_id', 'tanggal', 'waktu_masuk', 'waktu_pulang', 'lokasi']);

        if ($request->hasFile('foto_selfie')) {
            $data['foto_selfie'] = $request->file('foto_selfie')->store('absensi');
        }

        \App\Models\Absensi::create($data);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan');
    }


    public function export()
    {
        return Excel::download(new AbsensiExport, 'laporan-absensi.xlsx');
    }


}
