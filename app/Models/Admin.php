<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'terakhir_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'terakhir_login' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}