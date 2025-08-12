<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Absensi;

class AbsensiExport implements FromCollection
{
    public function collection()
    {
        return Absensi::all();
        // return \App\Models\Absensi::with('karyawan.user')->get()->map(function($absen){
        //     return [
        //         'Nama' => $absen->karyawan->user->name,
        //         'Tanggal' => $absen->tanggal->format('d-m-Y'),
        //         'Waktu Masuk' => $absen->waktu_masuk,
        //         'Waktu Pulang' => $absen->waktu_pulang,
        //         'Lokasi' => $absen->lokasi,
        //     ];
        // });
    }
}
