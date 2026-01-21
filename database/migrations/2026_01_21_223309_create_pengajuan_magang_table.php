<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kordinator_id')->constrained('kordinator')->onDelete('cascade');
            $table->string('jenis_kegiatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_siswa');
            $table->string('bidang_unit');
            $table->string('dokumen_path')->nullable();
            $table->enum('status', ['pending', 'acc', 'reject'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_magang');
    }
};