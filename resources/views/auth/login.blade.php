<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ATK SMART</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, html {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* Ambient Dynamic Background Gradients */
        .hero-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 35%, #1d4ed8 70%, #0f172a 100%);
            background-size: 200% 200%;
            animation: gradientShift 14s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Glowing Blobs */
        .blob-1 {
            animation: floatBlob1 16s ease-in-out infinite alternate;
        }
        .blob-2 {
            animation: floatBlob2 20s ease-in-out infinite alternate;
        }
        .blob-3 {
            animation: floatBlob3 14s ease-in-out infinite alternate;
        }

        @keyframes floatBlob1 {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(45px, -35px) scale(1.18); }
            100% { transform: translate(-30px, 25px) scale(0.92); }
        }

        @keyframes floatBlob2 {
            0% { transform: translate(0px, 0px) scale(1); }
            50% { transform: translate(-50px, 45px) scale(1.22); }
            100% { transform: translate(35px, -25px) scale(0.9); }
        }

        @keyframes floatBlob3 {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            50% { transform: translate(35px, 30px) scale(1.12) rotate(35deg); }
            100% { transform: translate(-35px, -25px) scale(0.92) rotate(-25deg); }
        }

        /* Floating Interactive Badges */
        .float-card-1 {
            animation: floatBadge1 6s ease-in-out infinite;
        }
        .float-card-2 {
            animation: floatBadge2 7s ease-in-out infinite 1.8s;
        }

        @keyframes floatBadge1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.2deg); }
        }

        @keyframes floatBadge2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(-1.5deg); }
        }

        /* Rotating Glow Rings */
        .spin-slow {
            animation: spinSlow 24s linear infinite;
        }
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spin-reverse-slow {
            animation: spinReverseSlow 32s linear infinite;
        }
        @keyframes spinReverseSlow {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        .pulse-slow {
            animation: pulseGlow 4s ease-in-out infinite alternate;
        }
        @keyframes pulseGlow {
            0% { opacity: 0.35; transform: scale(0.95); }
            100% { opacity: 0.8; transform: scale(1.06); }
        }

        /* Animated SVG Lines */
        .animated-line-1 {
            stroke-dasharray: 800;
            stroke-dashoffset: 800;
            animation: drawLine 8s ease-in-out infinite alternate;
        }
        .animated-line-2 {
            stroke-dasharray: 900;
            stroke-dashoffset: 900;
            animation: drawLine 10s ease-in-out infinite alternate 1.5s;
        }

        @keyframes drawLine {
            0% { stroke-dashoffset: 800; opacity: 0.15; }
            100% { stroke-dashoffset: 0; opacity: 0.45; }
        }

        /* Shimmer on Primary Button */
        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -120%;
            width: 60%;
            height: 200%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.28),
                transparent
            );
            transform: rotate(25deg);
            animation: shimmerMove 4.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        @keyframes shimmerMove {
            0% { left: -120%; }
            25% { left: 220%; }
            100% { left: 220%; }
        }

        /* Input styling with smooth focus glow */
        .custom-input {
            border-bottom: 2px solid #e2e8f0;
            background-color: #f8fafc;
            border-top-left-radius: 0.6rem;
            border-top-right-radius: 0.6rem;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .custom-input:focus {
            border-bottom-color: #2563eb;
            background-color: #ffffff;
            box-shadow: 0 4px 16px -2px rgba(37, 99, 235, 0.14);
            outline: none;
        }

        .custom-input.active {
            border-bottom-color: #2563eb;
        }

        /* Fade In Entrance Animation */
        .fade-in-up {
            animation: fadeInUp 0.75s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glassmorphism styling */
        .glass-box {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.2);
        }

        /* Twinkling Sparkles */
        .twinkle {
            animation: twinkle 3.5s ease-in-out infinite alternate;
        }
        @keyframes twinkle {
            0% { transform: scale(0.85); opacity: 0.3; }
            100% { transform: scale(1.18); opacity: 1; filter: drop-shadow(0 0 10px rgba(255,255,255,0.9)); }
        }

        /* Emoji bounce */
        .bounce-gentle {
            display: inline-block;
            animation: bounceGentle 3s ease-in-out infinite;
        }
        @keyframes bounceGentle {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-6px) rotate(8deg); }
        }

        /* Canvas Particle Layer */
        #particleCanvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2">

        <!-- ============================================== -->
        <!-- LEFT COLUMN: ANIMATED HERO SECTION             -->
        <!-- ============================================== -->
        <div id="heroContainer" class="relative hero-bg overflow-hidden text-white flex flex-col justify-between p-8 sm:p-12 lg:p-16 min-h-[460px] lg:min-h-screen select-none">
            
            <!-- Animated Particle Canvas (Floating Stars & Dust) -->
            <canvas id="particleCanvas"></canvas>

            <!-- Floating Ambient Glowing Blobs -->
            <div class="blob-1 absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-400/25 blur-3xl pointer-events-none"></div>
            <div class="blob-2 absolute top-1/2 -right-28 w-96 h-96 rounded-full bg-indigo-500/30 blur-3xl pointer-events-none"></div>
            <div class="blob-3 absolute -bottom-20 left-1/4 w-80 h-80 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>

            <!-- Geometric Animated Wireframe Waves -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" fill="none">
                <!-- Glowing ambient background circle -->
                <circle cx="280" cy="300" r="320" stroke="white" stroke-width="1.5" stroke-dasharray="6 8" class="spin-slow" opacity="0.22" />
                <circle cx="280" cy="300" r="440" stroke="white" stroke-width="1" stroke-dasharray="4 6" class="spin-reverse-slow" opacity="0.15" />
                
                <!-- Dynamic undulating curve lines -->
                <path class="animated-line-1" d="M-100,500 C150,150 450,20 850,-50" stroke="white" stroke-width="2" />
                <path class="animated-line-2" d="M-50,600 C200,250 500,80 900,20" stroke="white" stroke-width="1.8" />
                <path class="animated-line-1" d="M0,700 C250,350 550,140 950,90" stroke="white" stroke-width="1.5" opacity="0.25" />
                <path class="animated-line-2" d="M50,800 C300,450 600,200 1000,160" stroke="white" stroke-width="1.2" opacity="0.2" />
            </svg>

            <!-- Glow transition gradient overlay on right edge -->
            <div class="hidden lg:block absolute top-0 bottom-0 right-0 w-28 bg-gradient-to-l from-white/10 via-transparent to-transparent pointer-events-none z-10"></div>

            <!-- Top Brand Section with Spinning Star Aura -->
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center">
                        <!-- Pulsing glow behind logo -->
                        <div class="absolute inset-0 rounded-full bg-blue-300/30 blur-md pulse-slow"></div>
                        <!-- Outer rotating dashed ring -->
                        <div class="absolute inset-1 rounded-full border border-dashed border-white/40 spin-slow"></div>
                        
                        <!-- Star Brand Icon -->
                        <svg class="w-10 h-10 text-white relative z-10 drop-shadow-md" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="24" y1="2" x2="24" y2="46" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                            <line x1="2" y1="24" x2="46" y2="24" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                            <line x1="8.44" y1="8.44" x2="39.56" y2="39.56" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                            <line x1="39.56" y1="8.44" x2="8.44" y2="39.56" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-lg font-black tracking-wider text-white">ATK SMART</span>
                        <span class="text-[11px] font-semibold tracking-widest uppercase text-blue-200/90">Point of Sales System</span>
                    </div>
                </div>

                <div class="hidden sm:inline-flex items-center gap-2 glass-box px-3.5 py-1.5 rounded-full text-xs font-semibold text-white/95">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 -ml-4"></span>
                    <span>System v2.4 Online</span>
                </div>
            </div>

            <!-- Center Headline, Badges & Copy -->
            <div class="relative z-10 max-w-lg my-10 lg:my-auto">
                
                <!-- Floating Mini Glassmorphic Card 1 -->
                <div class="float-card-1 inline-flex items-center gap-2.5 glass-box px-4 py-2 rounded-2xl mb-6 shadow-xl transition-all hover:scale-105 cursor-default">
                    <div class="w-7 h-7 rounded-xl bg-amber-400/20 text-amber-300 flex items-center justify-center text-sm font-bold shadow-inner">
                        ⚡
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white tracking-wide">Transaksi Kasir Cepat</p>
                        <p class="text-[10px] text-blue-100/80">Otomatisasi cetak struk & barcode</p>
                    </div>
                </div>

                <!-- Main Hero Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Kelola Toko<br>
                    <span class="bg-gradient-to-r from-white via-blue-100 to-cyan-200 bg-clip-text text-transparent">
                        Lebih Cerdas.
                    </span>
                    <span class="bounce-gentle ml-1">✏️</span>
                </h1>

                <p class="mt-5 text-sm sm:text-base text-blue-100/90 leading-relaxed font-normal max-w-md">
                    Sistem inventaris dan kasir pintar toko alat tulis kantor. Pantau stok otomatis, kelola kategori produk, dan layani transaksi pelanggan lebih cepat.
                </p>

                <!-- Floating Mini Glassmorphic Card 2 -->
                <div class="float-card-2 inline-flex items-center gap-3 glass-box px-4 py-2.5 rounded-2xl mt-8 shadow-xl transition-all hover:scale-105 cursor-default">
                    <div class="w-8 h-8 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center text-base font-bold shadow-inner">
                        📦
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-xs font-bold text-white">Stok Real-time Terintegrasi</span>
                        </div>
                        <p class="text-[10px] text-blue-100/80">Peringatan otomatis saat stok menipis</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer Copyright & Status -->
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-6 border-t border-white/10">
                <p class="text-xs text-blue-200/80 font-medium">
                    &copy; {{ date('Y') }} ATK SMART &bull; Solusi Retail & Grosir
                </p>
                <div class="flex items-center gap-3 text-xs text-blue-200/70 font-medium">
                    <span class="inline-flex items-center gap-1">
                        <span class="text-cyan-300 twinkle">✨</span> Aman & Terenkripsi
                    </span>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- RIGHT COLUMN: MINIMALIST & SLEEK LOGIN FORM    -->
        <!-- ============================================== -->
        <div class="flex flex-col justify-between p-8 sm:p-12 lg:p-20 bg-white relative">
            
            <!-- Subtle ambient top-right corner glow -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Right Logo -->
            <div class="flex items-center justify-between relative z-10">
                <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2 group">
                    <span class="w-9 h-9 rounded-xl bg-blue-600 group-hover:bg-blue-700 text-white flex items-center justify-center text-sm font-black shadow-md shadow-blue-500/30 transition-transform group-hover:scale-105">
                        A
                    </span>
                    <span class="group-hover:text-blue-600 transition-colors">ATK SMART</span>
                </a>

                <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full border border-slate-200">
                    Staff Portal
                </span>
            </div>

            <!-- Centered Form Container with Entrance Animation -->
            <div class="w-full max-w-md mx-auto my-8 lg:my-auto fade-in-up relative z-10">
                
                <!-- Title & Subtitle -->
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Masuk ke Akun Anda
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Masukkan email dan password akun anda untuk mulai mengelola kasir dan inventaris toko.
                    </p>
                </div>

                <!-- Alert Messages (Errors or Success) -->
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2.5 animate-fadeIn">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2.5 animate-fadeIn">
                        <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center shrink-0 text-amber-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold animate-fadeIn">
                        <div class="flex items-center gap-2 mb-1.5">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Periksa kembali input Anda:</span>
                        </div>
                        <ul class="list-disc list-inside ml-2 font-normal text-rose-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Akun</label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', 'admin@saleskip.com') }}"
                                placeholder="Masukkan email terdaftar..." 
                                class="custom-input w-full px-4 py-3.5 text-sm font-medium text-slate-900 placeholder-slate-400 {{ old('email') ? 'active' : '' }}"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <div class="relative flex items-center">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="Masukkan kata sandi..." 
                                class="custom-input w-full pl-4 pr-11 py-3.5 text-sm font-medium text-slate-900 placeholder-slate-400"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password', this)"
                                class="absolute right-3.5 text-slate-400 hover:text-blue-600 focus:outline-hidden p-1 rounded-lg transition-colors cursor-pointer"
                                title="Tampilkan / Sembunyikan Password"
                                aria-label="Toggle password visibility"
                            >
                                <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Primary Button: Login Now with Shimmer Effect -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="shimmer-btn w-full py-3.5 px-6 bg-slate-900 hover:bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-blue-600/30 transition-all duration-300 cursor-pointer flex items-center justify-center gap-2 hover:scale-[1.01] active:scale-98"
                        >
                            <span>Masuk Sekarang</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="pt-3 border-t border-slate-100 text-center">
                        <a
                            href="{{ route('password.forgot') }}"
                            class="inline-flex items-center justify-center gap-1.5 text-xs text-blue-600 hover:text-blue-700 font-semibold transition-colors group"
                        >
                            <svg class="w-3.5 h-3.5 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Lupa kata sandi akun toko Anda?
                        </a>
                    </div>
                </form>
            </div>

            <!-- Empty bottom spacer to keep form balanced on large screens -->
            <div class="hidden lg:block"></div>
        </div>
    </div>

    <!-- Interactive Scripts: Particle Canvas, 3D Parallax & Password Toggle -->
    <script>
        // Toggle Password Visibility
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle('hidden', isPassword);
                eyeClosed.classList.toggle('hidden', !isPassword);
            }
        }

        // Lightweight Interactive Particle Canvas (Floating Starlight / Dust)
        (function initParticles() {
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            const particleCount = 42;

            function resize() {
                const rect = canvas.parentElement.getBoundingClientRect();
                width = canvas.width = rect.width;
                height = canvas.height = rect.height;
            }

            window.addEventListener('resize', resize);
            resize();

            class Particle {
                constructor() {
                    this.reset();
                }

                reset() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.size = Math.random() * 2.2 + 0.6;
                    this.speedY = -(Math.random() * 0.45 + 0.15);
                    this.speedX = (Math.random() - 0.5) * 0.25;
                    this.alpha = Math.random() * 0.65 + 0.2;
                    this.twinkleSpeed = Math.random() * 0.02 + 0.005;
                }

                update() {
                    this.y += this.speedY;
                    this.x += this.speedX;
                    this.alpha += Math.sin(Date.now() * this.twinkleSpeed) * 0.008;

                    if (this.y < -10 || this.x < -10 || this.x > width + 10) {
                        this.reset();
                        this.y = height + 10;
                    }
                }

                draw() {
                    ctx.save();
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255, 255, 255, ${Math.max(0.1, Math.min(0.85, this.alpha))})`;
                    ctx.shadowBlur = 8;
                    ctx.shadowColor = 'rgba(255, 255, 255, 0.8)';
                    ctx.fill();
                    ctx.restore();
                }
            }

            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();
                }
                requestAnimationFrame(animate);
            }

            animate();
        })();

        // Subtle 3D Parallax Tilt Effect on Mouse Move
        (function initHeroParallax() {
            const container = document.getElementById('heroContainer');
            const card1 = document.querySelector('.float-card-1');
            const card2 = document.querySelector('.float-card-2');
            if (!container || !card1 || !card2) return;

            container.addEventListener('mousemove', (e) => {
                const rect = container.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                card1.style.transform = `translate(${x * 18}px, ${y * 18}px)`;
                card2.style.transform = `translate(${-x * 22}px, ${-y * 22}px)`;
            });

            container.addEventListener('mouseleave', () => {
                card1.style.transform = '';
                card2.style.transform = '';
            });
        })();
    </script>   
</body>
</html>
