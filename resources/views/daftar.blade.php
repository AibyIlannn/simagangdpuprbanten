<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Magang SIMAGANG - DPUPR Provinsi Banten">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran - SIMAGANG</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
</head>
<body>
    <div class="main-content">
        <div class="register-container" x-data="registerApp()">
            <div class="register-card">
                
                <!-- Logo -->
                <div class="logo-wrapper">
                    <img src="{{ asset('image/ArtiLambang.png') }}" alt="Logo SIMAGANG">
                </div>
                
                <!-- Header -->
                <header class="register-header">
                    <h1 x-text="stepTitles[currentStep - 1]"></h1>
                    <p x-text="stepSubtitles[currentStep - 1]"></p>
                </header>
                
                <!-- Step 1: Data Akun -->
                <div x-show="currentStep === 1" x-transition>
                    <form @submit.prevent="nextStep">
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-label required">Nama Lengkap Pendaftar</label>
                            <input 
                                type="text" 
                                id="nama_lengkap" 
                                class="form-input"
                                placeholder="Masukkan nama lengkap"
                                x-model="formData.nama_lengkap"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="jabatan" class="form-label required">Jabatan</label>
                            <select 
                                id="jabatan" 
                                class="form-select"
                                x-model="formData.jabatan"
                                required
                            >
                                <option value="">Pilih Jabatan</option>
                                <option value="Guru Pembimbing">Guru Pembimbing</option>
                                <option value="Waka Humas">Waka Humas</option>
                                <option value="Waka Kurikulum">Waka Kurikulum</option>
                                <option value="Kaprodi">Kaprodi</option>
                                <option value="Wali Kelas">Wali Kelas</option>
                                <option value="Tata Usaha">Tata Usaha</option>
                                <option value="Koordinator PKL">Koordinator PKL</option>
                                <option value="Kepala Sekolah">Kepala Sekolah</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_sekolah" class="form-label required">Nama Sekolah</label>
                            <input 
                                type="text" 
                                id="nama_sekolah" 
                                class="form-input"
                                placeholder="Masukkan nama sekolah"
                                x-model="formData.nama_sekolah"
                                @input="formData.nama_sekolah = $event.target.value.toUpperCase()"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label required">Alamat Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                class="form-input"
                                placeholder="email@example.com"
                                x-model="formData.email"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="nomor_wa" class="form-label required">Nomor WhatsApp</label>
                            <input 
                                type="tel" 
                                id="nomor_wa" 
                                class="form-input"
                                placeholder="628xxxxxxxxxx"
                                x-model="formData.nomor_wa"
                                pattern="^(628[0-9]{9,11}|08[0-9]{9,11})$"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label required">Password</label>
                            <div class="password-wrapper">
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    id="password" 
                                    class="form-input"
                                    placeholder="Masukan password"
                                    x-model="formData.password"
                                    minlength="4"
                                    required
                                >
                                <button 
                                    type="button" 
                                    class="toggle-password"
                                    @click="showPassword = !showPassword"
                                >
                                    <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                            <div class="password-wrapper">
                                <input 
                                    :type="showConfirmPassword ? 'text' : 'password'" 
                                    id="password_confirmation" 
                                    class="form-input"
                                    placeholder="Ulangi password"
                                    x-model="formData.password_confirmation"
                                    required
                                >
                                <button 
                                    type="button" 
                                    class="toggle-password"
                                    @click="showConfirmPassword = !showConfirmPassword"
                                >
                                    <i :class="showConfirmPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                Lanjutkan Pendaftaran
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Step 2: Data Pengajuan -->
                <div x-show="currentStep === 2" x-transition>
                    <form @submit.prevent="nextStep">
                        <div class="form-group">
                            <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan</label>
                            <input 
                                type="text" 
                                id="jenis_kegiatan" 
                                class="form-input"
                                x-model="formData.jenis_kegiatan"
                                readonly
                            >
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">Periode Magang</label>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input 
                                        type="date" 
                                        id="tanggal_mulai" 
                                        class="form-input"
                                        x-model="formData.tanggal_mulai"
                                        required
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input 
                                        type="date" 
                                        id="tanggal_selesai" 
                                        class="form-input"
                                        x-model="formData.tanggal_selesai"
                                        :min="formData.tanggal_mulai"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" @click="previousStep">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Lanjutkan Pendaftaran
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Step 3: Data Peserta -->
                <div x-show="currentStep === 3" x-transition>
                    <form @submit.prevent="nextStep">
                        <div class="participants-list">
                            <template x-for="(participant, index) in formData.participants" :key="index">
                                <div class="participant-item">
                                    <div class="participant-header">
                                        <span class="participant-number">Siswa <span x-text="index + 1"></span></span>
                                        <button 
                                            type="button" 
                                            class="btn-remove"
                                            @click="removeParticipant(index)"
                                            x-show="formData.participants.length > 1"
                                        >
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label :for="'nama_siswa_' + index" class="form-label required" style="color:#121212">Nama Siswa</label>
                                        <input 
                                            type="text" 
                                            :id="'nama_siswa_' + index"
                                            class="form-input"
                                            placeholder="Masukkan nama lengkap siswa"
                                            x-model="participant.nama_siswa"
                                            required
                                        >
                                    </div>
                                    
                                    <div class="form-group">
                                        <label :for="'nisn_' + index" class="form-label required" style="color:#121212">NISN</label>
                                        <input 
                                            type="text" 
                                            :id="'nisn_' + index"
                                            class="form-input"
                                            placeholder="10 digit NISN"
                                            x-model="participant.nisn"
                                            pattern="[0-9]{10}"
                                            maxlength="10"
                                            required
                                        >
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label :for="'kelas_' + index" class="form-label required" style="color:#121212">Kelas</label>
                                            <input 
                                                type="text" 
                                                :id="'kelas_' + index"
                                                class="form-input"
                                                placeholder="Contoh: XII TKJ 1"
                                                x-model="participant.kelas"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label :for="'bidang_unit_' + index" class="form-label required" style="color:#121212">Bidang Unit Tujuan</label>
                                        <select 
                                            :id="'bidang_unit_' + index"
                                            class="form-select"
                                            x-model="participant.bidang_unit"
                                            required
                                        >
                                            <option value="">Pilih Bidang Unit</option>
                                            <option value="Bidang Teknik">Bidang Teknik</option>
                                            <option value="Administrasi">Administrasi</option>
                                            <option value="IT & Digital">IT & Digital</option>
                                        </select>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <button 
                            type="button" 
                            class="btn-add"
                            @click="addParticipant"
                            x-show="formData.participants.length < 50"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Tambah Siswa
                        </button>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" @click="previousStep">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Lanjutkan Pendaftaran
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Step 4: Upload Dokumen -->
                <div x-show="currentStep === 4 && !isSubmitted" x-transition>
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="file-upload-wrapper">
                            <label class="file-upload-label required">Upload Dokumen</label>
                            <p class="file-upload-info">
                                Surat Pengajuan Resmi dari Sekolah ke DPUPR Provinsi Banten
                            </p>
                            
                            <div 
                                class="file-upload-area"
                                :class="{ 'has-file': formData.document }"
                                @click="$refs.fileInput.click()"
                            >
                                <input 
                                    type="file" 
                                    class="file-upload-input"
                                    x-ref="fileInput"
                                    accept=".pdf"
                                    @change="handleFileUpload"
                                    required
                                >
                                <div class="file-upload-icon">
                                    <i :class="formData.document ? 'fa-solid fa-file-pdf' : 'fa-solid fa-cloud-arrow-up'"></i>
                                </div>
                                <p class="file-upload-text" x-text="formData.document ? 'Dokumen berhasil dipilih' : 'Klik untuk upload dokumen'"></p>
                                <p class="file-upload-hint">Format: PDF (Maksimal 5MB)</p>
                                <div class="file-name" x-show="formData.document">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span x-text="formData.documentName"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" @click="previousStep">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali
                            </button>
                            <button 
                                type="submit" 
                                class="btn btn-primary"
                                :class="{ 'loading': isLoading }"
                                :disabled="isLoading"
                            >
                                <template x-if="!isLoading">
                                    <span>Kirim Pengajuan Magang Resmi</span>
                                </template>
                                <template x-if="isLoading">
                                    <span><i class="fa-solid fa-spinner fa-spin"></i> Mengirim...</span>
                                </template>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Success Message -->
                <div x-show="isSubmitted" x-transition>
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h2>Pengajuan Berhasil Dikirim!</h2>
                        <p>
                            Terima kasih telah mendaftar. Pengajuan magang Anda telah kami terima dan akan segera diproses oleh tim DPUPR Provinsi Banten. 
                            Kami akan menghubungi Anda melalui WhatsApp untuk informasi selanjutnya.
                        </p>
                        <a href="{{ route('login') }}" class="btn-back-login">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 DPUPR Provinsi Banten. Platform Sistem Informasi Magang.</p>
    </footer>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerApp', () => ({
                currentStep: 1,
                isLoading: false,
                isSubmitted: false,
                showPassword: false,
                showConfirmPassword: false,
                
                stepTitles: [
                    'Data Akun Pendaftar',
                    'Data Pengajuan Magang',
                    'Data Peserta Magang',
                    'Upload Dokumen Resmi'
                ],
                stepSubtitles: [
                    'Lengkapi informasi akun Anda untuk mendaftar',
                    'Informasi detail tentang pengajuan magang',
                    'Data lengkap siswa yang akan mengikuti magang',
                    'Upload surat pengajuan resmi dari sekolah'
                ],
                
                formData: {
                    nama_lengkap: '',
                    jabatan: '',
                    nama_sekolah: '',
                    email: '',
                    nomor_wa: '',
                    password: '',
                    password_confirmation: '',
                    jenis_kegiatan: 'PKL / Prakerin',
                    tanggal_mulai: '',
                    tanggal_selesai: '',
                    participants: [
                        { nama_siswa: '', nisn: '', kelas: '', bidang_unit: '' }
                    ],
                    document: null,
                    documentName: ''
                },
                
                nextStep() {
                    if (this.currentStep === 1) {
                        if (this.formData.password !== this.formData.password_confirmation) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Password Tidak Cocok',
                                text: 'Password dan konfirmasi password tidak sama!',
                                confirmButtonColor: '#f97316'
                            });
                            return;
                        }
                        if (this.formData.password.length < 4) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Password Terlalu Pendek',
                                text: 'Password minimal 4 karakter!',
                                confirmButtonColor: '#f97316'
                            });
                            return;
                        }
                    }
                    
                    if (this.currentStep === 3) {
                        if (this.formData.participants.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Siswa Kosong',
                                text: 'Anda harus menambahkan minimal 1 siswa untuk melanjutkan.',
                                confirmButtonColor: '#f97316'
                            });
                            return;
                        }
                    }
                    
                    if (this.currentStep < 4) {
                        this.currentStep++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                addParticipant() {
                    if (this.formData.participants.length < 50) {
                        this.formData.participants.push({
                            nama_siswa: '',
                            nisn: '',
                            kelas: '',
                            bidang_unit: ''
                        });
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Siswa Ditambahkan',
                            text: `Total siswa: ${this.formData.participants.length}`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Batas Maksimal',
                            text: 'Maksimal 50 siswa per pengajuan',
                            confirmButtonColor: '#f97316'
                        });
                    }
                },
                
                removeParticipant(index) {
                    if (this.formData.participants.length > 1) {
                        Swal.fire({
                            title: 'Hapus Data Siswa?',
                            text: 'Data siswa ini akan dihapus dari daftar',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.formData.participants.splice(index, 1);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: 'Data siswa berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Dapat Dihapus',
                            text: 'Minimal harus ada 1 siswa dalam pengajuan',
                            confirmButtonColor: '#f97316'
                        });
                    }
                },
                
                handleFileUpload(event) {
                    const file = event.target.files[0];
                    
                    if (file) {
                        if (file.type !== 'application/pdf') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Format File Salah',
                                text: 'File harus berformat PDF!',
                                confirmButtonColor: '#f97316'
                            });
                            event.target.value = '';
                            return;
                        }
                        
                        if (file.size > 5 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 5MB!',
                                confirmButtonColor: '#f97316'
                            });
                            event.target.value = '';
                            return;
                        }
                        
                        this.formData.document = file;
                        this.formData.documentName = file.name;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'File Berhasil Dipilih',
                            text: file.name,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                
                async submitForm() {
                    const totalSiswa = this.formData.participants.length;
                    
                    const result = await Swal.fire({
                        title: 'Kirim Pengajuan Magang?',
                        html: `Anda akan mengirim pengajuan untuk <strong>${totalSiswa} siswa</strong>.<br>Pastikan semua data sudah benar.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f97316',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Kirim',
                        cancelButtonText: 'Periksa Lagi'
                    });
                    
                    if (!result.isConfirmed) return;
                    
                    this.isLoading = true;
                    
                    const formDataToSend = new FormData();
                    
                    // Step 1 Data
                    formDataToSend.append('nama_lengkap', this.formData.nama_lengkap);
                    formDataToSend.append('jabatan', this.formData.jabatan);
                    formDataToSend.append('nama_sekolah', this.formData.nama_sekolah);
                    formDataToSend.append('email', this.formData.email);
                    formDataToSend.append('nomor_wa', this.formData.nomor_wa);
                    formDataToSend.append('password', this.formData.password);
                    formDataToSend.append('password_confirmation', this.formData.password_confirmation);
                    
                    // Step 2 Data
                    formDataToSend.append('jenis_kegiatan', this.formData.jenis_kegiatan);
                    formDataToSend.append('tanggal_mulai', this.formData.tanggal_mulai);
                    formDataToSend.append('tanggal_selesai', this.formData.tanggal_selesai);
                    formDataToSend.append('jumlah_siswa', this.formData.participants.length);
                    
                    // Step 3 Data
                    this.formData.participants.forEach((participant, index) => {
                        formDataToSend.append(`participants[${index}][nama_siswa]`, participant.nama_siswa);
                        formDataToSend.append(`participants[${index}][nisn]`, participant.nisn);
                        formDataToSend.append(`participants[${index}][kelas]`, participant.kelas);
                        formDataToSend.append(`participants[${index}][bidang_unit]`, participant.bidang_unit);
                    });
                    
                    // Step 4 Data
                    if (this.formData.document) {
                        formDataToSend.append('dokumen', this.formData.document);
                    }
                    
                    try {
                        const response = await fetch('{{ route("register.submit") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formDataToSend
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            await Swal.fire({
                                icon: 'success',
                                title: 'Pengajuan Berhasil!',
                                text: 'Pengajuan magang Anda telah diterima dan akan segera diproses',
                                confirmButtonColor: '#10b981'
                            });
                            this.isSubmitted = true;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Pengajuan Gagal',
                                text: result.message || 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Koneksi Gagal',
                            text: 'Terjadi kesalahan saat mengirim data. Periksa koneksi internet Anda.',
                            confirmButtonColor: '#dc2626'
                        });
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>