<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pengajuan - SIMAGANG</title>
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
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 14px; }
        td { font-size: 14px; }
        
        .badge { 
            padding: 4px 12px; border-radius: 12px; font-size: 12px; 
            font-weight: 500; display: inline-block;
        }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-success { background: #d4edda; color: #155724; }
        
        .btn { 
            padding: 8px 16px; border: none; border-radius: 4px; 
            cursor: pointer; font-size: 14px; text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        .detail-row { background: #f8f9fa; }
        .detail-content { padding: 20px; }
        .detail-grid { display: grid; grid-template-columns: 200px 1fr; gap: 10px; margin-bottom: 10px; }
        .detail-label { font-weight: 600; }
        .peserta-list { margin-top: 15px; }
        .peserta-item { 
            padding: 10px; background: white; margin-bottom: 8px; 
            border-radius: 4px; border-left: 3px solid #007bff;
        }
        
        .action-buttons { display: flex; gap: 5px; }
        
        .modal { 
            display: none; position: fixed; top: 0; left: 0; 
            width: 100%; height: 100%; background: rgba(0,0,0,0.5);
            justify-content: center; align-items: center; z-index: 1000;
        }
        .modal.active { display: flex; }
        .modal-content { 
            background: white; padding: 30px; border-radius: 8px; 
            width: 500px; max-width: 90%;
        }
        .modal-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .modal-header h3 { font-size: 18px; }
        .close-modal { 
            background: none; border: none; font-size: 24px; 
            cursor: pointer; color: #999;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group textarea { 
            width: 100%; padding: 10px; border: 1px solid #ddd; 
            border-radius: 4px; font-size: 14px; min-height: 100px;
            font-family: inherit;
        }
        
        .alert { padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
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
                    
                    <li><a href="{{ url('/dashboard/admin/validasi') }}" class="active"><i class="fas fa-clock"></i> Validasi Pengajuan</a></li>
                    <li><a href="{{ url('/dashboard/admin/sekolah') }}"><i class="fas fa-school"></i> Data Sekolah</a></li>
                    <li><a href="{{ url('/dashboard/admin/peserta') }}"><i class="fas fa-users"></i> Data Peserta</a></li>
                    <li><a href="{{ url('/dashboard/admin/dokumen') }}"><i class="fas fa-file-pdf"></i> Dokumen ACC</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="topbar">
                <h1>Validasi Pengajuan</h1>
                <div class="user-info">
                    <span>{{ Auth::guard('superadmin')->check() ? Auth::guard('superadmin')->user()->nama_lengkap : Auth::guard('admin')->user()->nama_lengkap }}</span>
                    <span class="badge badge-success">{{ Auth::guard('superadmin')->check() ? 'SuperAdmin' : 'Admin' }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Pengajuan yang Perlu Divalidasi</h2>
                    <div>
                        <span style="color: #666; font-size: 14px;">
                            Pending: <strong style="color: #856404;">{{ \App\Models\PengajuanMagang::where('status', 'pending')->count() }}</strong> | 
                            Reject: <strong style="color: #721c24;">{{ \App\Models\PengajuanMagang::where('status', 'reject')->count() }}</strong>
                        </span>
                    </div>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Kordinator</th>
                            <th>Periode</th>
                            <th>Jumlah Siswa</th>
                            <th>Bidang Unit</th>
                            <th>Status</th>
                            <th>Tanggal Ajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pengajuanList = \App\Models\PengajuanMagang::with(['kordinator', 'pesertaMagang'])
                                ->whereIn('status', ['pending', 'reject'])
                                ->latest()
                                ->get();
                        @endphp
                        
                        @forelse($pengajuanList as $index => $pengajuan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $pengajuan->kordinator->nama_sekolah }}</strong></td>
                            <td>{{ $pengajuan->kordinator->nama_lengkap }}</td>
                            <td>{{ $pengajuan->tanggal_mulai->format('d/m/Y') }} - {{ $pengajuan->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>{{ $pengajuan->jumlah_siswa }} siswa</td>
                            <td>{{ $pengajuan->bidang_unit }}</td>
                            <td>
                                @if($pengajuan->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Reject</span>
                                @endif
                            </td>
                            <td>{{ $pengajuan->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" onclick="toggleDetail({{ $pengajuan->id }})">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    
                                    @if($pengajuan->status === 'pending')
                                    <form action="#" method="POST" style="display: inline;" onsubmit="return confirm('Setujui pengajuan ini?')">
                                        @csrf
                                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">
                                        <input type="hidden" name="action" value="acc">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> ACC
                                        </button>
                                    </form>
                                    
                                    <button class="btn btn-danger btn-sm" onclick="openRejectModal({{ $pengajuan->id }})">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr id="detail-{{ $pengajuan->id }}" class="detail-row" style="display: none;">
                            <td colspan="9">
                                <div class="detail-content">
                                    <h3 style="margin-bottom: 15px;">Detail Pengajuan</h3>
                                    
                                    <strong>Informasi Kordinator:</strong>
                                    <div class="detail-grid">
                                        <div class="detail-label">Nama Lengkap:</div>
                                        <div>{{ $pengajuan->kordinator->nama_lengkap }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Jabatan:</div>
                                        <div>{{ $pengajuan->kordinator->jabatan }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Email:</div>
                                        <div>{{ $pengajuan->kordinator->email }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Nomor WhatsApp:</div>
                                        <div>{{ $pengajuan->kordinator->nomor_wa }}</div>
                                    </div>
                                    
                                    <br>
                                    <strong>Informasi Pengajuan:</strong>
                                    <div class="detail-grid">
                                        <div class="detail-label">Jenis Kegiatan:</div>
                                        <div>{{ $pengajuan->jenis_kegiatan }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Periode Magang:</div>
                                        <div>{{ $pengajuan->tanggal_mulai->format('d F Y') }} - {{ $pengajuan->tanggal_selesai->format('d F Y') }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Bidang Unit:</div>
                                        <div>{{ $pengajuan->bidang_unit }}</div>
                                    </div>
                                    <div class="detail-grid">
                                        <div class="detail-label">Dokumen:</div>
                                        <div>
                                            @if($pengajuan->dokumen_path)
                                                <a href="{{ Storage::url($pengajuan->dokumen_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen PDF
                                                </a>
                                            @else
                                                <span style="color: #999;">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($pengajuan->keterangan)
                                    <div class="detail-grid">
                                        <div class="detail-label">Keterangan:</div>
                                        <div style="color: #dc3545;">{{ $pengajuan->keterangan }}</div>
                                    </div>
                                    @endif
                                    
                                    <div class="peserta-list">
                                        <strong>Daftar Peserta ({{ $pengajuan->pesertaMagang->count() }} siswa):</strong>
                                        @foreach($pengajuan->pesertaMagang as $peserta)
                                        <div class="peserta-item">
                                            <strong>{{ $peserta->nama_siswa }}</strong> - NISN: {{ $peserta->nisn }} - Kelas: {{ $peserta->kelas }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #999;">Tidak ada pengajuan yang perlu divalidasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Modal Reject -->
    <div class="modal" id="rejectModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tolak Pengajuan</h3>
                <button class="close-modal" onclick="closeRejectModal()">&times;</button>
            </div>
            
            <form action="#" method="POST" id="rejectForm">
                @csrf
                <input type="hidden" name="pengajuan_id" id="rejectPengajuanId">
                <input type="hidden" name="action" value="reject">
                
                <div class="form-group">
                    <label>Alasan Penolakan *</label>
                    <textarea name="keterangan" required placeholder="Masukkan alasan penolakan pengajuan..."></textarea>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn" onclick="closeRejectModal()" style="background: #6c757d; color: white;">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function toggleDetail(id) {
            const row = document.getElementById('detail-' + id);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
        
        function openRejectModal(id) {
            document.getElementById('rejectModal').classList.add('active');
            document.getElementById('rejectPengajuanId').value = id;
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.remove('active');
            document.getElementById('rejectForm').reset();
        }
    </script>
</body>
</html>