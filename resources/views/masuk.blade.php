<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIMAGANG</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/masuk.css') }}">
</head>
<body>
    <div class="main-content">
        <div class="login-container" x-data="loginApp()">
            <div class="login-card">
                <!-- Logo -->
                <div class="logo-wrapper">
                    <img src="{{ asset('image/ArtiLambang.png') }}" alt="Logo SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
                </div>
                
                <!-- Header -->
                <section class="login-header">
                    <h1>SIMAGANG</h1>
                    <p>Sistem Informasi Magang DPUPR Banten</p>
                </section>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login.submit') }}" @submit="isLoading = true">
                    @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                class="form-input"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            >
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                id="password" 
                                name="password"
                                class="form-input"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >
                            <button 
                                type="button" 
                                class="toggle-password"
                                @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                            >
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Form Footer: Remember Me & Forgot Password -->
                    <div class="form-footer">
                        <div style="opacity:0;" class="remember-me">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember"
                            >
                            <label for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="forgot-password">Lupa sandi?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn-submit"
                        :class="{ 'loading': isLoading }"
                        :disabled="isLoading"
                    >
                        Masuk
                    </button>
                </form>
                
                <!-- Divider -->
                <hr class="divider">
                
                <!-- Register Link -->
                <p class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai peserta magang</a>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; 2026 DPUPR Provinsi Banten. Platform Sistem Informasi Magang.</p>
    </footer>
    
    <script>
        function loginApp() {
            return {
                showPassword: false,
                isLoading: false
            }
        }
    </script>
</body>
</html>