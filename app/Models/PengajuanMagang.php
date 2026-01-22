<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanMagang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_magang';

    protected $fillable = [
        'kordinator_id',
        'jenis_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_siswa',
        'bidang_unit',
        'dokumen_path',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
    ];

    public function kordinator()
    {
        return $this->belongsTo(Kordinator::class, 'kordinator_id');
    }

    public function pesertaMagang()
    {
        return $this->hasMany(PesertaMagang::class, 'pengajuan_id');
    }
}