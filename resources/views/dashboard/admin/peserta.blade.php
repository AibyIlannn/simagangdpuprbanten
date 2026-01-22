<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta - SIMAGANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f5f5f5; }
        
        .dashboard-container { display: flex; min-height: 100vh; }
        
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
        
        .main-content { flex: 1; padding: 30px; }
        .topbar { 
            background: white; padding: 20px 30px; margin: -30px -30px 30px; 
            border-bottom: 1px solid #e0e0e0; display: flex; 
            justify-content: space-between; align-items: center;
        }
        .topbar h1 { font-size: 24px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .btn-logout { 
            padding: 8px 16px; background: #dc3545; color: white; 
            border: none; border-radius: 4px; cursor: pointer;
        }
        
        .card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .card-header h2 { font-size: 18px; }
        
        .search-bar { 
            display: flex; gap: 10px; margin-bottom: 20px; 
        }
        .search-bar input, .search-bar select { 
            padding: 10px; border: 1px solid #ddd; 
            border-radius: 4px; font-size: 14px;
        }
        .search-bar input { flex: 1; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 14px; }
        td { font-size: 14px; }
        
        .badge { 
            padding: 4px 12px; border-radius: 12px; font-size: 12px; 
            font-weight: 500; display: inline-block;
        }
        .badge-success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>SIMAGANG</h2>
                <small>Dashboard Admin</small>
            </div>
            
            <nav>
                <ul class="sidebar-menu">
                    <li><a href="{{ url('/dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    
                    @auth('superadmin')
                    <li><a href="{{ url('/dashboard/admin') }}"><i class="fas fa-user-shield"></i> Kelola Admin</a></li>
                    @endauth
                    
                    <li><a href="{{ url('/dashboard/admin/validasi') }}"><i class="fas fa-clock"></i> Validasi Pengajuan</a></li>
                    <li><a href="{{ url('/dashboard/admin/sekolah') }}"><i class="fas fa-school"></i> Data Sekolah</a></li>
                    <li><a href="{{ url('/dashboard/admin/peserta') }}" class="active"><i class="fas fa-users"></i> Data Peserta</a></li>
                    <li><a href="{{ url('/dashboard/admin/dokumen') }}"><i class="fas fa-file-pdf"></i> Dokumen ACC</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="topbar">
                <h1>Data Peserta Magang</h1>
                <div class="user-info">
                    <span>{{ Auth::guard('superadmin')->check() ? Auth::guard('superadmin')->user()->nama_lengkap : Auth::guard('admin')->user()->nama_lengkap }}</span>
                    <span class="badge badge-success">{{ Auth::guard('superadmin')->check() ? 'SuperAdmin' : 'Admin' }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Peserta Magang (Pengajuan ACC)</h2>
                    <div>
                        <span style="color: #666; font-size: 14px;">
                            Total: <strong>{{ \App\Models\PesertaMagang::whereHas('pengajuanMagang', function($q) { $q->where('status', 'acc'); })->count() }}</strong> peserta
                        </span>
                    </div>
                </div>
                
                <div class="search-bar">
                    <input type="text" placeholder="Cari nama siswa, NISN, atau sekolah..." id="searchInput" onkeyup="filterTable()">
                    <select id="bidangFilter" onchange="filterTable()">
                        <option value="">Semua Bidang</option>
                        <option value="Bidang Teknik">Bidang Teknik</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="IT & Digital">IT & Digital</option>
                    </select>
                </div>
                
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Nama Sekolah</th>
                            <th>Periode Magang</th>
                            <th>Bidang Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $peserta = \App\Models\PesertaMagang::with(['pengajuanMagang.kordinator'])
                                ->whereHas('pengajuanMagang', function($query) {
                                    $query->where('status', 'acc');
                                })
                                ->get();
                        @endphp
                        
                        @forelse($peserta as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $p->nama_siswa }}</strong></td>
                            <td>{{ $p->nisn }}</td>
                            <td>{{ $p->kelas }}</td>
                            <td>{{ $p->pengajuanMagang->kordinator->nama_sekolah }}</td>
                            <td>
                                {{ $p->pengajuanMagang->tanggal_mulai->format('d/m/Y') }} - 
                                {{ $p->pengajuanMagang->tanggal_selesai->format('d/m/Y') }}
                            </td>
                            <td>{{ $p->pengajuanMagang->bidang_unit }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #999;">Belum ada peserta dengan pengajuan yang di-ACC</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script>
        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const bidangValue = document.getElementById('bidangFilter').value.toLowerCase();
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    const namaSiswa = cells[1].textContent.toLowerCase();
                    const nisn = cells[2].textContent.toLowerCase();
                    const namaSekolah = cells[4].textContent.toLowerCase();
                    const bidang = cells[6].textContent.toLowerCase();
                    
                    const matchSearch = namaSiswa.includes(searchValue) || 
                                      nisn.includes(searchValue) || 
                                      namaSekolah.includes(searchValue);
                    const matchBidang = bidangValue === '' || bidang.includes(bidangValue);
                    
                    rows[i].style.display = matchSearch && matchBidang ? '' : 'none';
                }
            }
        }
    </script>
</body>
</html>