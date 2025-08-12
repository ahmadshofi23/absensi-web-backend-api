<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tampilkan semua karyawan dengan relasi user
        $karyawans = Karyawan::with('user')->paginate(15);
        return view('admin.karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Form tambah karyawan baru
        return view('admin.karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nik' => 'required|string|unique:karyawans,nik',
            'jabatan' => 'required|string',
            'divisi' => 'required|string',
            'no_hp' => 'nullable|string',
        ]);

        // Buat user dulu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan', // set role karyawan
        ]);

        // Buat karyawan terkait user
        Karyawan::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('admin.karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users','email')->ignore($karyawan->user->id)],
            'nik' => ['required','string', Rule::unique('karyawans','nik')->ignore($karyawan->id)],
            'jabatan' => 'required|string',
            'divisi' => 'required|string',
            'no_hp' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update user
        $karyawan->user->name = $request->name;
        $karyawan->user->email = $request->email;
        if($request->filled('password')){
            $karyawan->user->password = Hash::make($request->password);
        }
        $karyawan->user->save();

        // Update karyawan
        $karyawan->nik = $request->nik;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->divisi = $request->divisi;
        $karyawan->no_hp = $request->no_hp;
        
        if ($request->hasFile('kontrak_kerja')) {
            $path = $request->file('kontrak_kerja')->store('dokumen/kontrak_kerja', 'public');
            $karyawan->kontrak_kerja = $path;
        }

        if ($request->hasFile('npwp')) {
            $path = $request->file('npwp')->store('dokumen/npwp', 'public');
            $karyawan->npwp = $path;
        }
        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        $karyawan->user->delete(); // delete user otomatis delete karyawan (cascade)
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function exports()
    {
       return 'test connection';
    }
}
