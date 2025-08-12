<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new Karyawan([
            'user_id' => $row['user_id'],
            'nik' => $row['nik'],
            'jabatan' => $row['jabatan'],
            'divisi' => $row['divisi'],
            'no_hp' => $row['no_hp'],
        ]);
    }
}
