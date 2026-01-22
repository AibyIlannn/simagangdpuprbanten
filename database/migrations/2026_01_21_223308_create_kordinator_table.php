<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kordinator', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->string('nama_sekolah');
            $table->string('email')->unique();
            $table->string('nomor_wa');
            $table->rememberToken();
            $table->string('password');
            $table->enum('role', ['kordinator_sekolah'])->default('kordinator_sekolah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kordinator');
    }
};