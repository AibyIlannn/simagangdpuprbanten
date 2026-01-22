<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sekolah - SIMAGANG</title>
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
        .search-bar input { 
            flex: 1; padding: 10px; border: 1px solid #ddd; 
            border-radius: 4px; font-size: 14px;
        }
        .search-bar select { 
            padding: 10px; border: 1px solid #ddd; 
            border-radius: 4px; font-size: 14px;
        }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 14px; }
        td { font-size: 14px; }
        
        .badge { 
            padding: 4px 12px; border-radius: 12px; font-size: 12px; 
            font-weight: 500; display: inline-block;
        }
        .badge-success { background: #d4edda; color: #155724; }
        
        .btn { 
            padding: 8px 16px; border: none; border-radius: 4px; 
            cursor: pointer; font-size: 14px; text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
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
                    <li><a href="{{ url('/dashboard/admin/sekolah') }}" class="active"><i class="fas fa-school"></i> Data Sekolah</a></li>
                    <li><a href="{{ url('/dashboard/admin/peserta') }}"><i class="fas fa-users"></i> Data Peserta</a></li>
                    <li><a href="{{ url('/dashboard/admin/dokumen') }}"><i class="fas fa-file-pdf"></i> Dokumen ACC</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="topbar">
                <h1>Data Sekolah</h1>
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
                    <h2>Daftar Sekolah Terdaftar (Pengajuan ACC)</h2>
                    <div>
                        <span style="color: #666; font-size: 14px;">
                            Total: <strong>{{ \App\Models\Kordinator::whereHas('pengajuanMagang', function($q) { $q->where('status', 'acc'); })->count() }}</strong> sekolah
                        </span>
                    </div>
                </div>
                
                <div class="search-bar">
                    <input type="text" placeholder="Cari nama sekolah, kordinator, atau email..." id="searchInput" onkeyup="filterTable()">
                    <select id="jabatanFilter" onchange="filterTable()">
                        <option value="">Semua Jabatan</option>
                        <option value="Guru Pembimbing">Guru Pembimbing</option>
                        <option value="Waka Humas">Waka Humas</option>
                        <option value="Koordinator PKL">Koordinator PKL</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                    </select>
                </div>
                
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Nama Pendaftar</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp</th>
                            <th>Pengajuan ACC</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $kordinators = \App\Models\Kordinator::whereHas('pengajuanMagang', function($query) {
                                $query->where('status', 'acc');
                            })->with(['pengajuanMagang' => function($query) {
                                $query->where('status', 'acc');
                            }])->get();
                        @endphp
                        
                        @forelse($kordinators as $index => $kordinator)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $kordinator->nama_sekolah }}</strong></td>
                            <td>{{ $kordinator->nama_lengkap }}</td>
                            <td>{{ $kordinator->jabatan }}</td>
                            <td>{{ $kordinator->email }}</td>
                            <td>{{ $kordinator->nomor_wa }}</td>
                            <td>{{ $kordinator->pengajuanMagang->count() }} pengajuan</td>
                            <td>{{ $kordinator->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #999;">Belum ada sekolah dengan pengajuan yang di-ACC</td>
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
            const jabatanValue = document.getElementById('jabatanFilter').value.toLowerCase();
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    const namaSekolah = cells[1].textContent.toLowerCase();
                    const namaPendaftar = cells[2].textContent.toLowerCase();
                    const jabatan = cells[3].textContent.toLowerCase();
                    const email = cells[4].textContent.toLowerCase();
                    
                    const matchSearch = namaSekolah.includes(searchValue) || 
                                      namaPendaftar.includes(searchValue) || 
                                      email.includes(searchValue);
                    const matchJabatan = jabatanValue === '' || jabatan.includes(jabatanValue);
                    
                    rows[i].style.display = matchSearch && matchJabatan ? '' : 'none';
                }
            }
        }
    </script>
</body>
</html>