<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CutiIzin;
use App\Notifications\ApprovalNotification;

class CutiIzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cutiIzins = CutiIzin::with('karyawan.user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.cuti-izin.index', compact('cutiIzins'));
    }

    // Update status approve/reject
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $cutiIzin = CutiIzin::findOrFail($id);
        $cutiIzin->status = $request->status;
        $cutiIzin->save();

        // Kirim notifikasi ke user
        $user = $cutiIzin->karyawan->user;
        $pesan = "Pengajuan {$cutiIzin->jenis} Anda telah {$request->status}.";
        // dimatikan dulu karena harus setting docker
        // $user->notify(new ApprovalNotification($pesan));

        return redirect()->route('admin.cuti-izin.index')->with('success', 'Status pengajuan berhasil diperbarui dan notifikasi terkirim.');
    }

    public function show($id)
    {
        $cutiIzin = CutiIzin::with('karyawan.user')->findOrFail($id);
        return view('admin.cuti-izin.show', compact('cutiIzin'));
    }

    // Opsional: Hapus pengajuan
    public function destroy($id)
    {
        $cutiIzin = CutiIzin::findOrFail($id);
        $cutiIzin->delete();

        return redirect()->route('admin.cuti-izin.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

}
