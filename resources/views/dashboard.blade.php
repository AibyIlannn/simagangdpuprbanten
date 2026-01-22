<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMAGANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f5f5f5; }
        
        .dashboard-container { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #1a1a2e; color: white; padding: 20px; }
        .sidebar-header { margin-bottom: 30px; }
        .sidebar-header h2 { font-size: 20px; }
        .sidebar-header small { font-size: 12px; opacity: 0.7; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a { 
            display: flex; align-items: center; gap: 10px; 
            padding: 12px 15px; color: white; text-decoration: none; 
            border-radius: 6px; transition: 0.2s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #16213e; }
        .sidebar-menu i { width: 20px; }
        
        /* Main Content */
        .main-content { flex: 1; padding: 30px; }
        .topbar { 
            background: white; padding: 20px 30px; margin: -30px -30px 30px; 
            border-bottom: 1px solid #e0e0e0; display: flex; 
            justify-content: space-between; align-items: center;
        }
        .topbar h1 { font-size: 24px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-info span { font-size: 14px; }
        .btn-logout { 
            padding: 8px 16px; background: #dc3545; color: white; 
            border: none; border-radius: 4px; cursor: pointer;
        }
        
        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #007bff; }
        .stat-card.warning { border-left-color: #ffc107; }
        .stat-card.success { border-left-color: #28a745; }
        .stat-card.danger { border-left-color: #dc3545; }
        .stat-label { font-size: 14px; color: #666; margin-bottom: 8px; }
        .stat-value { font-size: 32px; font-weight: bold; color: #1a1a2e; }
        
        /* Table */
        .card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
        .card h2 { margin-bottom: 20px; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 14px; }
        td { font-size: 14px; }
        .badge { 
            padding: 4px 12px; border-radius: 12px; font-size: 12px; 
            font-weight: 500; display: inline-block;
        }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>SIMAGANG</h2>
                <small>Dashboard Admin</small>
            </div>
            
            <nav>
                <ul class="sidebar-menu">
                    <li><a href="{{ url('/dashboard') }}" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                    
                    @auth('superadmin')
                    <li><a href="{{ url('/dashboard/admin') }}"><i class="fas fa-user-shield"></i> Kelola Admin</a></li>
                    @endauth
                    
                    <li><a href="{{ url('/dashboard/admin/validasi') }}"><i class="fas fa-clock"></i> Validasi Pengajuan</a></li>
                    <li><a href="{{ url('/dashboard/admin/sekolah') }}"><i class="fas fa-school"></i> Data Sekolah</a></li>
                    <li><a href="{{ url('/dashboard/admin/peserta') }}"><i class="fas fa-users"></i> Data Peserta</a></li>
                    <li><a href="{{ url('/dashboard/admin/dokumen') }}"><i class="fas fa-file-pdf"></i> Dokumen ACC</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="topbar">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>{{ Auth::guard('superadmin')->check() ? Auth::guard('superadmin')->user()->nama_lengkap : Auth::guard('admin')->user()->nama_lengkap }}</span>
                    <span class="badge badge-success">{{ Auth::guard('superadmin')->check() ? 'SuperAdmin' : 'Admin' }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card warning">
                    <div class="stat-label">Pengajuan Pending</div>
                    <div class="stat-value">{{ \App\Models\PengajuanMagang::where('status', 'pending')->count() }}</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-label">Pengajuan ACC</div>
                    <div class="stat-value">{{ \App\Models\PengajuanMagang::where('status', 'acc')->count() }}</div>
                </div>
                
                <div class="stat-card danger">
                    <div class="stat-label">Pengajuan Reject</div>
                    <div class="stat-value">{{ \App\Models\PengajuanMagang::where('status', 'reject')->count() }}</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">Total Sekolah</div>
                    <div class="stat-value">{{ \App\Models\Kordinator::count() }}</div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="card">
                <h2>Pengajuan Terbaru</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Sekolah</th>
                            <th>Jenis Kegiatan</th>
                            <th>Periode</th>
                            <th>Jumlah Siswa</th>
                            <th>Status</th>
                            <th>Tanggal Ajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentPengajuan = \App\Models\PengajuanMagang::with('kordinator')
                                ->latest()
                                ->take(10)
                                ->get();
                        @endphp
                        
                        @forelse($recentPengajuan as $pengajuan)
                        <tr>
                            <td>{{ $pengajuan->kordinator->nama_sekolah }}</td>
                            <td>{{ $pengajuan->jenis_kegiatan }}</td>
                            <td>{{ $pengajuan->tanggal_mulai->format('d/m/Y') }} - {{ $pengajuan->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>{{ $pengajuan->jumlah_siswa }} siswa</td>
                            <td>
                                @if($pengajuan->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($pengajuan->status === 'acc')
                                    <span class="badge badge-success">ACC</span>
                                @else
                                    <span class="badge badge-danger">Reject</span>
                                @endif
                            </td>
                            <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #999;">Belum ada pengajuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>