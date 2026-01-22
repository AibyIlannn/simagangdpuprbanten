<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - SIMAGANG</title>
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
        
        .btn { 
            padding: 8px 16px; border: none; border-radius: 4px; 
            cursor: pointer; font-size: 14px; text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 14px; }
        td { font-size: 14px; }
        
        .badge { 
            padding: 4px 12px; border-radius: 12px; font-size: 12px; 
            font-weight: 500; display: inline-block;
        }
        .badge-success { background: #d4edda; color: #155724; }
        
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
        .form-group input, .form-group select { 
            width: 100%; padding: 10px; border: 1px solid #ddd; 
            border-radius: 4px; font-size: 14px;
        }
        
        .alert { padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
                    <li><a href="{{ url('/dashboard/admin') }}" class="active"><i class="fas fa-user-shield"></i> Kelola Admin</a></li>
                    <li><a href="{{ url('/dashboard/admin/validasi') }}"><i class="fas fa-clock"></i> Validasi Pengajuan</a></li>
                    <li><a href="{{ url('/dashboard/admin/sekolah') }}"><i class="fas fa-school"></i> Data Sekolah</a></li>
                    <li><a href="{{ url('/dashboard/admin/peserta') }}"><i class="fas fa-users"></i> Data Peserta</a></li>
                    <li><a href="{{ url('/dashboard/admin/dokumen') }}"><i class="fas fa-file-pdf"></i> Dokumen ACC</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="main-content">
            <div class="topbar">
                <h1>Kelola Admin</h1>
                <div class="user-info">
                    <span>{{ Auth::guard('superadmin')->user()->nama_lengkap }}</span>
                    <span class="badge badge-success">SuperAdmin</span>
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
            
            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Admin</h2>
                    <button class="btn btn-primary" onclick="openModal('create')">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </button>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terakhir Login</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $admins = \App\Models\Admin::latest()->get();
                        @endphp
                        
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->nama_lengkap }}</td>
                            <td>{{ $admin->email }}</td>
                            <td><span class="badge badge-success">Admin</span></td>
                            <td>{{ $admin->terakhir_login ? $admin->terakhir_login->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="editAdmin({{ $admin->id }}, '{{ $admin->nama_lengkap }}', '{{ $admin->email }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="#" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #999;">Belum ada data admin</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Modal Create/Edit -->
    <div class="modal" id="adminModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Admin</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="adminForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="admin_id" id="adminId">
                
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" id="namaLengkap" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" id="email" required>
                </div>
                
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" id="password" minlength="8">
                    <small style="color: #666;">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</small>
                </div>
                
                <div class="form-group">
                    <label>Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" id="passwordConfirmation">
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn" onclick="closeModal()" style="background: #6c757d; color: white;">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal(mode) {
            document.getElementById('adminModal').classList.add('active');
            if (mode === 'create') {
                document.getElementById('modalTitle').textContent = 'Tambah Admin';
                document.getElementById('adminForm').reset();
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('password').required = true;
                document.getElementById('passwordConfirmation').required = true;
            }
        }
        
        function closeModal() {
            document.getElementById('adminModal').classList.remove('active');
            document.getElementById('adminForm').reset();
        }
        
        function editAdmin(id, nama, email) {
            document.getElementById('adminModal').classList.add('active');
            document.getElementById('modalTitle').textContent = 'Edit Admin';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('adminId').value = id;
            document.getElementById('namaLengkap').value = nama;
            document.getElementById('email').value = email;
            document.getElementById('password').required = false;
            document.getElementById('passwordConfirmation').required = false;
        }
    </script>
</body>
</html>