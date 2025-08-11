<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    // Absen Masuk
    public function masuk(Request $request)
    {
        $user = $request->user();
        $karyawan = $user->karyawan;

        $validator = Validator::make($request->all(), [
            'lokasi' => 'required|string|max:255',
            'foto' => 'required|image|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::firstOrNew([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $today,
        ]);

        if ($absensi->jam_masuk) {
            return response()->json(['message' => 'Sudah absen masuk hari ini'], 400);
        }

        // Simpan foto
        $path = $request->file('foto')->store('absensi/foto_masuk', 'public');

        $absensi->jam_masuk = Carbon::now()->toTimeString();
        $absensi->lokasi_masuk = $request->lokasi;
        $absensi->foto_masuk = $path;
        $absensi->save();

        return response()->json(['message' => 'Absensi masuk berhasil', 'data' => $absensi]);
    }

    // Absen Pulang
    public function pulang(Request $request)
    {
        $user = $request->user();
        $karyawan = $user->karyawan;

        $validator = Validator::make($request->all(), [
            'lokasi' => 'required|string|max:255',
            'foto' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $today)
            ->first();

        if (!$absensi || !$absensi->jam_masuk) {
            return response()->json(['message' => 'Belum absen masuk hari ini'], 400);
        }

        if ($absensi->jam_pulang) {
            return response()->json(['message' => 'Sudah absen pulang hari ini'], 400);
        }

        // Simpan foto pulang
        $path = $request->file('foto')->store('absensi/foto_pulang', 'public');

        $absensi->jam_pulang = Carbon::now()->toTimeString();
        $absensi->lokasi_pulang = $request->lokasi;
        $absensi->foto_pulang = $path;
        $absensi->save();

        return response()->json(['message' => 'Absensi pulang berhasil', 'data' => $absensi]);
    }

    // Lihat Riwayat Absensi
    public function riwayat(Request $request)
    {
        $user = $request->user();
        $karyawan = $user->karyawan;

        $absensis = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return response()->json($absensis);
    }
}
