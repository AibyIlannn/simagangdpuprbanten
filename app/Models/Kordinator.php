<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kordinator extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'kordinator';

    protected $fillable = [
        'nama_lengkap',
        'jabatan',
        'nama_sekolah',
        'email',
        'nomor_wa',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagang::class, 'kordinator_id');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}