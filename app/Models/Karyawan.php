<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    // Tambahkan kolom yang boleh diisi lewat mass assignment
    protected $fillable = [
        'user_id',
        'nik',
        'jabatan',
        'divisi',
        'no_hp',
        'kontrak_kerja',
        'npwp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
