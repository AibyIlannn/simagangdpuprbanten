<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

// Halaman Publik (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/masuk', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/daftar', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/daftar', [RegisterController::class, 'register'])->name('register.submit');

// Protected Routes - SuperAdmin & Admin (Gabungan)
Route::middleware(['role:superadmin,admin'])->prefix('dashboard')->group(function () {
    
    // Dashboard Utama
    Route::get('/', function () {
        $stats = [
            'pending' => \App\Models\PengajuanMagang::where('status', 'pending')->count(),
            'acc' => \App\Models\PengajuanMagang::where('status', 'acc')->count(),
            'reject' => \App\Models\PengajuanMagang::where('status', 'reject')->count(),
            'total_sekolah' => \App\Models\Kordinator::count(),
        ];
        
        $recentPengajuan = \App\Models\PengajuanMagang::with('kordinator')
            ->latest()
            ->take(10)
            ->get();
        
        return view('dashboard', compact('stats', 'recentPengajuan'));
    })->name('dashboard');

    // Kelola Admin - SuperAdmin Only
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/admin', function () {
            return view('dashboard.admin');
        })->name('dashboard.admin');
    });

    // Halaman yang bisa diakses Admin & SuperAdmin
    Route::prefix('admin')->group(function () {
        Route::get('/validasi', function () {
            $pengajuanList = \App\Models\PengajuanMagang::with(['kordinator', 'pesertaMagang'])
                ->whereIn('status', ['pending', 'reject'])
                ->latest()
                ->get();
            
            return view('dashboard.admin.validasi', compact('pengajuanList'));
        })->name('dashboard.admin.validasi');

        Route::get('/sekolah', function () {
            $kordinators = \App\Models\Kordinator::whereHas('pengajuanMagang', function($query) {
                $query->where('status', 'acc');
            })->with(['pengajuanMagang' => function($query) {
                $query->where('status', 'acc');
            }])->get();
            
            return view('dashboard.admin.sekolah', compact('kordinators'));
        })->name('dashboard.admin.sekolah');

        Route::get('/peserta', function () {
            $peserta = \App\Models\PesertaMagang::with(['pengajuanMagang.kordinator'])
                ->whereHas('pengajuanMagang', function($query) {
                    $query->where('status', 'acc');
                })
                ->get();
            
            return view('dashboard.admin.peserta', compact('peserta'));
        })->name('dashboard.admin.peserta');

        Route::get('/dokumen', function () {
            $dokumen = \App\Models\PengajuanMagang::with('kordinator')
                ->where('status', 'acc')
                ->latest()
                ->get();
            
            return view('dashboard.admin.dokumen', compact('dokumen'));
        })->name('dashboard.admin.dokumen');
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