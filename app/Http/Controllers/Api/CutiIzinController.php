<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CutiIzin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CutiIzinController extends Controller
{
    // Ajukan cuti/izin/sakit
    public function store(Request $request)
    {
        $user = $request->user();
        $karyawan = $user->karyawan;

        $validator = Validator::make($request->all(), [
            'jenis' => 'required|in:cuti,izin,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'nullable|string',
            'surat_dokter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('surat_dokter')) {
            $path = $request->file('surat_dokter')->store('cuti_izin/surat_dokter', 'public');
            $data['surat_dokter'] = $path;
        }

        $data['karyawan_id'] = $karyawan->id;
        $data['status'] = 'pending';

        $cutiIzin = CutiIzin::create($data);

        return response()->json(['message' => 'Pengajuan berhasil dikirim', 'data' => $cutiIzin]);
    }

    // Lihat status pengajuan
    public function index(Request $request)
    {
        $user = $request->user();
        $karyawan = $user->karyawan;

        $cutiIzins = CutiIzin::where('karyawan_id', $karyawan->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($cutiIzins);
    }
}
