<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_magang', function (Blueprint $table) {
            // Approval tracking
            $table->timestamp('approved_at')->nullable()->after('keterangan');
            $table->unsignedBigInteger('approved_by_id')->nullable()->after('approved_at');
            $table->string('approved_by_role')->nullable()->after('approved_by_id');
            $table->string('approved_by_name')->nullable()->after('approved_by_role');
            
            // Rejection tracking
            $table->timestamp('rejected_at')->nullable()->after('approved_by_name');
            $table->unsignedBigInteger('rejected_by_id')->nullable()->after('rejected_at');
            $table->string('rejected_by_role')->nullable()->after('rejected_by_id');
            $table->string('rejected_by_name')->nullable()->after('rejected_by_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_magang', function (Blueprint $table) {
            $table->dropColumn([
                'approved_at',
                'approved_by_id',
                'approved_by_role',
                'approved_by_name',
                'rejected_at',
                'rejected_by_id',
                'rejected_by_role',
                'rejected_by_name',
            ]);
        });
    }
};