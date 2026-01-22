<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaMagang extends Model
{
    use HasFactory;

    protected $table = 'peserta_magang';

    protected $fillable = [
        'pengajuan_id',
        'nama_siswa',
        'nisn',
        'kelas',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function pengajuanMagang()
    {
        return $this->belongsTo(PengajuanMagang::class, 'pengajuan_id');
    }
}