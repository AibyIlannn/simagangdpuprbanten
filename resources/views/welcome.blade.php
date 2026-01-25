<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title>SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten | Platform PKL Resmi</title>
    <meta name="title" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten | Platform PKL Resmi">
    <meta name="description" content="Platform resmi penyedia ruang PKL dan magang di DPUPR Provinsi Banten. Program magang berkualitas untuk siswa SMK/SMA dengan pembimbing profesional dan sertifikat resmi.">
    <meta name="keywords" content="magang banten, PKL banten, praktek kerja lapangan, DPUPR Banten, magang SMK, magang SMA, sistem informasi magang, pendaftaran magang online, program magang pemerintah, dinas PUPR Banten, magang serang, lowongan magang banten">
    <meta name="author" content="DPUPR Provinsi Banten">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="revisit-after" content="7 days">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
    <meta property="og:description" content="Platform resmi penyedia ruang PKL dan magang untuk sekolah di Provinsi Banten. Daftar sekarang dan wujudkan pengalaman magang berkualitas!">
    <meta property="og:image" content="{{ asset('image/ArtiLambang.png') }}">
    <meta property="og:site_name" content="SIMAGANG DPUPR Banten">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
    <meta name="twitter:description" content="Platform resmi penyedia ruang PKL dan magang untuk sekolah di Provinsi Banten">
    <meta name="twitter:image" content="{{ asset('image/ArtiLambang.png') }}">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="ID-BT">
    <meta name="geo.placename" content="Serang, Banten, Indonesia">
    <meta name="geo.position" content="-6.118700;106.150290">
    <meta name="ICBM" content="-6.118700, 106.150290">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/ArtiLambang.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/ArtiLambang.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <!-- Header -->
    <header id="mainHeader">
        <nav role="navigation" aria-label="Main Navigation">
            <div class="logo-section">
                <h3>SIMAGANG</h3>
                <small>Sistem Informasi Magang DPUPR Banten</small>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="nav-desktop">
                @auth('superadmin')
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline" aria-label="Dashboard SuperAdmin">
                        <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                    </a>
                @elseauth('admin')
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline" aria-label="Dashboard Admin">
                        <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                    </a>
                @elseauth('kordinator')
                    <a href="{{ url('/verification') }}" class="btn btn-outline" aria-label="Dashboard Verifikasi">
                        <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                    </a>
                @else
                    <a href="{{ url('/daftar') }}" class="btn btn-outline" aria-label="Daftar Sekolah">Daftar</a>
                    <a href="{{ url('/masuk') }}" class="btn btn-primary" aria-label="Masuk ke Sistem">Masuk</a>
                @endauth
            </div>
            
            <!-- Mobile Hamburger Button -->
            <button class="hamburger-btn" 
                    id="hamburgerBtn"
                    aria-label="Buka Menu" 
                    aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-header">
                <h4>Menu</h4>
                <button class="close-btn" 
                        id="closeMenuBtn"
                        aria-label="Tutup Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mobile-menu-content">
                <div class="mobile-menu-item">
                    <a href="{{ url('/') }}" class="mobile-menu-link">Beranda</a>
                </div>
                
                <div class="mobile-dropdown">
                    <button class="dropdown-trigger" id="dropdownTrigger" aria-expanded="false">
                        <span>Layanan</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="{{ url('/daftar') }}" class="dropdown-item">Pendaftaran Peserta Magang</a>
                        <a href="{{ url('/verification') }}" class="dropdown-item">Informasi Pendaftaran</a>
                    </div>
                </div>
                
                <div class="mobile-menu-item">
                    <a href="#footer" class="mobile-menu-link">Kontak</a>
                </div>
                
                <div class="mobile-menu-actions">
                    @auth('superadmin')
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @elseauth('admin')
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @elseauth('kordinator')
                        <a href="{{ url('/verification') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ url('/daftar') }}" class="btn btn-outline-mobile">Daftar</a>
                        <a href="{{ url('/masuk') }}" class="btn btn-primary">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Overlay -->
        <div class="menu-overlay" id="menuOverlay" aria-hidden="true"></div>
    </header>

    <!-- Main Content -->
    <main>
        <section class="hero" aria-labelledby="hero-heading">
            <div class="container">
                <div class="hero-grid">
                    <!-- Hero Left Content -->
                    <div class="hero-left">
                        <article class="hero-content fade-in-up">
                            <h1 id="hero-heading">Wujudkan Pengalaman Magang Berkualitas untuk Generasi Banten</h1>
                            <a href="{{ url('/daftar') }}" class="btn btn-primary">
                                Ajukan Kerja Sama <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                            </a>
                        </article>

                        <!-- Info Cards -->
                        <div class="info-cards fade-in-up">
                            <article class="info-card">
                                <h3 class="info-card-title">Bidang Teknik</h3>
                                <p class="info-card-subtitle">Pengalaman langsung di proyek infrastruktur</p>
                                <div class="info-card-price">100+ Kuota</div>
                            </article>

                            <article class="info-card stell">
                                <h3 class="info-card-title">Administrasi</h3>
                                <p class="info-card-subtitle">Kelola dokumen dan sistem pemerintahan</p>
                                <div class="info-card-price">75+ Kuota</div>
                            </article>

                            <article class="info-card">
                                <h3 class="info-card-title">IT &amp; Digital</h3>
                                <p class="info-card-subtitle">Teknologi informasi modern</p>
                                <div class="info-card-price">50+ Kuota</div>
                            </article>
                        </div>
                    </div>

                    <!-- Registration Card -->
                    <aside class="registration-card fade-in-up" aria-labelledby="registration-heading">
                        <h2 id="registration-heading">Program Magang DPUPR Provinsi Banten</h2>
                        <p class="subtitle">Wujudkan pengalaman magang berkualitas dan terstruktur untuk siswa-siswi terbaik</p>
                        
                        <hr class="divider">
                        
                        <div class="list">
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Program magang telah diverifikasi dan diawasi langsung oleh Pemerintah Provinsi Banten</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Didukung oleh lembaga pemerintahan resmi dengan standar profesional tinggi</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Proses seleksi peserta magang yang transparan dan terstruktur</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Penempatan peserta disesuaikan dengan latar belakang pendidikan</span>
                            </div>
                           
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Monitoring dan evaluasi kegiatan magang dilakukan secara berkala</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Program dirancang sesuai kebutuhan dunia kerja modern</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Data dijamin keamanannya dengan sistem enkripsi standar pemerintahan</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Kurikulum disesuaikan dengan standar kompetensi tingkat nasional</span>
                            </div>
                        </div>
                        
                        <a href="{{ url('/daftar') }}" class="btn btn-primary">Daftar Sekarang</a>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Footer Brand -->
                <div class="footer-brand">
                    <h3>SIMAGANG</h3>
                    <p>Platform resmi penyedia ruang magang dan PKL untuk meningkatkan kompetensi siswa</p>
                    <div class="social-links">
                        <a href="https://instagram.com/dpupr.banten" 
                           class="social-link" 
                           aria-label="Instagram DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/dpupr.banten" 
                           class="social-link" 
                           aria-label="Facebook DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://youtube.com/@dpuprbanten" 
                           class="social-link" 
                           aria-label="YouTube DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Footer Menu -->
                <div class="footer-section">
                    <h4>Menu</h4>
                    <nav class="footer-links" aria-label="Footer Menu">
                        <a href="{{ url('/') }}">Beranda</a>
                        <a href="#footer">Kontak</a>
                    </nav>
                </div>

                <!-- Footer Layanan -->
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <nav class="footer-links" aria-label="Footer Layanan">
                        <a href="{{ url('/daftar') }}">Pendaftaran Peserta Magang</a>
                        <a href="{{ url('/verification') }}">Halaman Verifikasi</a>
                    </nav>
                </div>

                <!-- Footer Contact -->
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <address class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>Jl. Syekh Nawawi Al-Bantani, Serang, Banten 42111</div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <a href="mailto:kontak@pupr.bantenprov.go.id">kontak@pupr.bantenprov.go.id</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <a href="tel:+622541234456">(0254) 123 456</a>
                            </div>
                        </div>
                    </address>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} DPUPR Provinsi Banten. Platform Sistem Informasi Magang.</p>
            </div>
        </div>
    </footer>

    <!-- Vanilla JavaScript -->
    <script>
        (function() {
            'use strict';
            
            // DOM Elements
            const header = document.getElementById('mainHeader');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const closeMenuBtn = document.getElementById('closeMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            const dropdownTrigger = document.getElementById('dropdownTrigger');
            const dropdownContent = document.getElementById('dropdownContent');
            const dropdownIcon = dropdownTrigger.querySelector('.dropdown-icon');
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link, .dropdown-item, .mobile-menu-actions a');
            
            // State
            let lastScroll = 0;
            let isMenuOpen = false;
            let isDropdownOpen = false;
            
            // Header Scroll Effect
            function handleScroll() {
                const currentScroll = window.pageYOffset;
                
                // Add scrolled class
                if (currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                // Hide header on scroll down
                if (currentScroll > lastScroll && currentScroll > 200) {
                    header.classList.add('hidden');
                } else {
                    header.classList.remove('hidden');
                }
                
                lastScroll = currentScroll;
            }
            
            // Open Mobile Menu
            function openMobileMenu() {
                isMenuOpen = true;
                mobileMenu.classList.add('active');
                menuOverlay.classList.add('active');
                hamburgerBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }
            
            // Close Mobile Menu
            function closeMobileMenu() {
                isMenuOpen = false;
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                hamburgerBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                
                // Close dropdown juga
                if (isDropdownOpen) {
                    closeDropdown();
                }
            }
            
            // Toggle Dropdown
            function toggleDropdown() {
                isDropdownOpen = !isDropdownOpen;
                
                if (isDropdownOpen) {
                    dropdownContent.classList.add('active');
                    dropdownIcon.classList.add('rotated');
                    dropdownTrigger.setAttribute('aria-expanded', 'true');
                } else {
                    closeDropdown();
                }
            }
            
            // Close Dropdown
            function closeDropdown() {
                isDropdownOpen = false;
                dropdownContent.classList.remove('active');
                dropdownIcon.classList.remove('rotated');
                dropdownTrigger.setAttribute('aria-expanded', 'false');
            }
            
            // Event Listeners
            window.addEventListener('scroll', handleScroll, { passive: true });
            
            hamburgerBtn.addEventListener('click', openMobileMenu);
            closeMenuBtn.addEventListener('click', closeMobileMenu);
            menuOverlay.addEventListener('click', closeMobileMenu);
            
            dropdownTrigger.addEventListener('click', toggleDropdown);
            
            // Close menu saat link diklik
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });
            
            // Close menu dengan ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMobileMenu();
                }
            });
            
            // Prevent scroll behind menu
            mobileMenu.addEventListener('touchmove', function(e) {
                e.stopPropagation();
            }, { passive: false });
            
        })();
    </script>
</body>
</html>