<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

// Halaman Publik (Landing Page)
Route::get('/', function () {
    return view('welcome'); // atau view('index')
});

// Authentication Routes
Route::get('/masuk', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/daftar', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/daftar', [RegisterController::class, 'register'])->name('register.submit');

// Protected Routes - SuperAdmin Only
Route::middleware(['role:superadmin'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // User Management - SuperAdmin Only
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('dashboard.admin.index');
        })->name('dashboard.admin');

        Route::get('/sekolah', function () {
            return view('dashboard.admin.sekolah');
        })->name('dashboard.admin.sekolah');

        Route::get('/peserta', function () {
            return view('dashboard.admin.peserta');
        })->name('dashboard.admin.peserta');
    });

    // Management - SuperAdmin Only
    Route::get('/admin/dokumen', function () {
        return view('dashboard.admin.dokumen');
    })->name('dashboard.admin.dokumen');

    Route::get('/admin/validasi', function () {
        return view('dashboard.admin.validasi');
    })->name('dashboard.admin.validasi');
});

// Protected Routes - SuperAdmin & Admin
Route::middleware(['role:superadmin,admin'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard.index');

    // Admin dapat akses sekolah, peserta, dokumen, validasi
    Route::prefix('admin')->group(function () {
        Route::get('/sekolah', function () {
            return view('dashboard.admin.sekolah');
        })->name('dashboard.sekolah');

        Route::get('/peserta', function () {
            return view('dashboard.admin.peserta');
        })->name('dashboard.peserta');

        Route::get('/dokumen', function () {
            return view('dashboard.admin.dokumen');
        })->name('dashboard.dokumen');

        Route::get('/validasi', function () {
            return view('dashboard.admin.validasi');
        })->name('dashboard.validasi');
    });
});

// Protected Routes - Kordinator Sekolah Only
Route::middleware(['role:kordinator_sekolah'])->group(function () {
    Route::get('/verification', function () {
        $kordinator = auth()->guard('kordinator')->user();
        $pengajuan = $kordinator->pengajuanMagang()->with('pesertaMagang')->latest()->get();
        
        return view('verification', compact('pengajuan'));
    })->name('verification');
});