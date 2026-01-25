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
        'approved_at',
        'approved_by_id',
        'approved_by_role',
        'approved_by_name',
        'rejected_at',
        'rejected_by_id',
        'rejected_by_role',
        'rejected_by_name',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relationships
    public function kordinator()
    {
        return $this->belongsTo(Kordinator::class, 'kordinator_id');
    }

    public function pesertaMagang()
    {
        return $this->hasMany(PesertaMagang::class, 'pengajuan_id');
    }

    // Accessor untuk menampilkan siapa yang approve/reject
    public function getApprovedByAttribute()
    {
        if ($this->approved_by_name) {
            return "{$this->approved_by_name} ({$this->approved_by_role})";
        }
        return null;
    }

    public function getRejectedByAttribute()
    {
        if ($this->rejected_by_name) {
            return "{$this->rejected_by_name} ({$this->rejected_by_role})";
        }
        return null;
    }
}