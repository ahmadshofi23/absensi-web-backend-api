<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\KaryawanImport;
use App\Exports\KaryawanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanImportExportController extends Controller
{
    public function export()
    {
        return Excel::download(new KaryawanExport, 'karyawan.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        Excel::import(new KaryawanImport, $request->file('file'));

        return back()->with('success', 'Data karyawan berhasil diimport!');
    }
}
