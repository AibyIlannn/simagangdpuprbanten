<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create SuperAdmin
        SuperAdmin::create([
            'nama_lengkap' => 'Super Administrator',
            'email' => 'superadmin@dpupr.banten.go.id',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        // Create Admin
        Admin::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@dpupr.banten.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $this->command->info('SuperAdmin dan Admin berhasil dibuat!');
        $this->command->info('SuperAdmin: superadmin@dpupr.banten.go.id / superadmin123');
        $this->command->info('Admin: admin@dpupr.banten.go.id / admin123');
    }
}