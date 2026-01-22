<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Verifikasi - SIMAGANG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f5f5f5; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 30px; }
        
        .header { 
            background: white; padding: 25px 30px; margin: -30px -30px 30px; 
            border-bottom: 3px solid #007bff; display: flex; 
            justify-content: space-between; align-items: center;
        }
        .header h1 { font-size: 24px; color: #1a1a2e; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .btn-logout { 
            padding: 8px 16px; background: #dc3545; color: white; 
            border: none; border-radius: 4px; cursor: pointer;
        }
        
        .welcome-card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
        .welcome-card h2 { margin-bottom: 10px; color: #1a1a2e; }
        .welcome-card p { color: #666; line-height: 1.6; }
        
        .card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; }
        .card h2 { margin-bottom: 20px; font-size: 18px; color: #1a1a2e; }
        
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
        
        .btn { 
            padding: 6px 12px; border: none; border-radius: 4px; 
            cursor: pointer; font-size: 13px; text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        
        .empty-state { 
            text-align: center; padding: 60px 20px; color: #999; 
        }
        .empty-state i { font-size: 64px; margin-bottom: 20px; opacity: 0.3; }
        
        .detail-row { background: #f8f9fa; }
        .detail-content { padding: 20px; }
        .detail-grid { display: grid; grid-template-columns: 200px 1fr; gap: 10px; margin-bottom: 10px; }
        .detail-label { font-weight: 600; }
        
        .peserta-list { margin-top: 15px; }
        .peserta-item { 
            padding: 10px; background: white; margin-bottom: 8px; 
            border-radius: 4px; border-left: 3px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Status Verifikasi Pengajuan Magang</h1>
                <small style="color: #666;">{{ Auth::guard('kordinator')->user()->nama_sekolah }}</small>
            </div>
            <div class="user-info">
                <span>{{ Auth::guard('kordinator')->user()->nama_lengkap }}</span>
                <span class="badge badge-primary" style="background: #007bff; color: white;">Kordinator</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
        
        <div class="welcome-card">
            <h2>Selamat Datang, {{ Auth::guard('kordinator')->user()->nama_lengkap }}</h2>
            <p>
                Halaman ini menampilkan status verifikasi dari semua pengajuan magang yang telah Anda kirimkan. 
                Silakan pantau status pengajuan Anda secara berkala. Jika ada pertanyaan, silakan hubungi admin DPUPR Banten.
            </p>
        </div>
        
        <div class="card">
            <h2>Daftar Pengajuan Magang</h2>
            
            @if($pengajuan->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Pengajuan</h3>
                    <p>Anda belum mengajukan permohonan magang</p>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i> Buat Pengajuan Baru
                    </a>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Kegiatan</th>
                            <th>Periode Magang</th>
                            <th>Jumlah Siswa</th>
                            <th>Bidang Unit</th>
                            <th>Status</th>
                            <th>Tanggal Ajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->jenis_kegiatan }}</td>
                            <td>{{ $item->tanggal_mulai->format('d/m/Y') }} - {{ $item->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>{{ $item->jumlah_siswa }} siswa</td>
                            <td>{{ $item->bidang_unit }}</td>
                            <td>
                                @if($item->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                                @elseif($item->status === 'acc')
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="toggleDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="detail-{{ $item->id }}" class="detail-row" style="display: none;">
                            <td colspan="8">
                                <div class="detail-content">
                                    <h3 style="margin-bottom: 15px;">Detail Pengajuan</h3>
                                    
                                    <div class="detail-grid">
                                        <div class="detail-label">Jenis Kegiatan:</div>
                                        <div>{{ $item->jenis_kegiatan }}</div>
                                    </div>
                                    
                                    <div class="detail-grid">
                                        <div class="detail-label">Periode Magang:</div>
                                        <div>{{ $item->tanggal_mulai->format('d F Y') }} - {{ $item->tanggal_selesai->format('d F Y') }}</div>
                                    </div>
                                    
                                    <div class="detail-grid">
                                        <div class="detail-label">Bidang Unit Tujuan:</div>
                                        <div>{{ $item->bidang_unit }}</div>
                                    </div>
                                    
                                    <div class="detail-grid">
                                        <div class="detail-label">Jumlah Siswa:</div>
                                        <div>{{ $item->jumlah_siswa }} siswa</div>
                                    </div>
                                    
                                    <div class="detail-grid">
                                        <div class="detail-label">Dokumen:</div>
                                        <div>
                                            @if($item->dokumen_path)
                                                <a href="{{ Storage::url($item->dokumen_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Download Dokumen
                                                </a>
                                            @else
                                                <span style="color: #999;">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($item->status === 'reject' && $item->keterangan)
                                    <div class="detail-grid">
                                        <div class="detail-label">Alasan Penolakan:</div>
                                        <div style="color: #dc3545;">{{ $item->keterangan }}</div>
                                    </div>
                                    @endif
                                    
                                    <div class="peserta-list">
                                        <strong>Daftar Peserta:</strong>
                                        @foreach($item->pesertaMagang as $peserta)
                                        <div class="peserta-item">
                                            <strong>{{ $peserta->nama_siswa }}</strong> - NISN: {{ $peserta->nisn }} - Kelas: {{ $peserta->kelas }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <script>
        function toggleDetail(id) {
            const row = document.getElementById('detail-' + id);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>