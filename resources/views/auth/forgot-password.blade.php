<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - ATK SMART</title>
    <meta name="description" content="Pulihkan akses akun ATK SMART Anda dengan mudah melalui verifikasi email atau hubungi admin via WhatsApp.">

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

        .hero-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 35%, #1d4ed8 70%, #0f172a 100%);
            background-size: 200% 200%;
            animation: gradientShift 14s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .blob-1 { animation: floatBlob1 16s ease-in-out infinite alternate; }
        .blob-2 { animation: floatBlob2 20s ease-in-out infinite alternate; }
        .blob-3 { animation: floatBlob3 14s ease-in-out infinite alternate; }
        @keyframes floatBlob1 {
            0%   { transform: translate(0px, 0px) scale(1); }
            50%  { transform: translate(45px, -35px) scale(1.18); }
            100% { transform: translate(-30px, 25px) scale(0.92); }
        }
        @keyframes floatBlob2 {
            0%   { transform: translate(0px, 0px) scale(1); }
            50%  { transform: translate(-50px, 45px) scale(1.22); }
            100% { transform: translate(35px, -25px) scale(0.9); }
        }
        @keyframes floatBlob3 {
            0%   { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            50%  { transform: translate(35px, 30px) scale(1.12) rotate(35deg); }
            100% { transform: translate(-35px, -25px) scale(0.92) rotate(-25deg); }
        }

        .float-card-1 { animation: floatBadge1 6s ease-in-out infinite; }
        .float-card-2 { animation: floatBadge2 7s ease-in-out infinite 1.8s; }
        @keyframes floatBadge1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%      { transform: translateY(-12px) rotate(1.2deg); }
        }
        @keyframes floatBadge2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%      { transform: translateY(-14px) rotate(-1.5deg); }
        }

        .spin-slow         { animation: spinSlow 24s linear infinite; }
        .spin-reverse-slow { animation: spinReverseSlow 32s linear infinite; }
        @keyframes spinSlow        { from { transform: rotate(0deg); }   to { transform: rotate(360deg); } }
        @keyframes spinReverseSlow { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }

        .pulse-slow { animation: pulseGlow 4s ease-in-out infinite alternate; }
        @keyframes pulseGlow {
            0%   { opacity: 0.35; transform: scale(0.95); }
            100% { opacity: 0.8;  transform: scale(1.06); }
        }

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
            0%   { stroke-dashoffset: 800; opacity: 0.15; }
            100% { stroke-dashoffset: 0;   opacity: 0.45; }
        }

        .shimmer-btn { position: relative; overflow: hidden; }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: -50%; left: -120%;
            width: 60%; height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.28), transparent);
            transform: rotate(25deg);
            animation: shimmerMove 4.5s cubic-bezier(0.4,0,0.2,1) infinite;
        }
        @keyframes shimmerMove {
            0%   { left: -120%; }
            25%  { left:  220%; }
            100% { left:  220%; }
        }

        .custom-input {
            border-bottom: 2px solid #e2e8f0;
            background-color: #f8fafc;
            border-top-left-radius: 0.6rem;
            border-top-right-radius: 0.6rem;
            transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        }
        .custom-input:focus {
            border-bottom-color: #2563eb;
            background-color: #ffffff;
            box-shadow: 0 4px 16px -2px rgba(37,99,235,0.14);
            outline: none;
        }
        .custom-input.active { border-bottom-color: #2563eb; }

        .fade-in-up { animation: fadeInUp 0.75s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .glass-box {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.22);
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.2);
        }

        .twinkle { animation: twinkle 3.5s ease-in-out infinite alternate; }
        @keyframes twinkle {
            0%   { transform: scale(0.85); opacity: 0.3; }
            100% { transform: scale(1.18); opacity: 1; filter: drop-shadow(0 0 10px rgba(255,255,255,0.9)); }
        }

        .bounce-gentle { display: inline-block; animation: bounceGentle 3s ease-in-out infinite; }
        @keyframes bounceGentle {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-6px) rotate(8deg); }
        }

        .lock-pulse { animation: lockPulse 2.5s ease-in-out infinite; }
        @keyframes lockPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25%      { transform: scale(1.15) rotate(-8deg); }
            75%      { transform: scale(1.08) rotate(5deg); }
        }

        /* Progress Stepper */
        .step-connector {
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin: 0 6px;
            position: relative;
            top: -14px;
        }

        /* Success checkmark pop */
        .success-checkmark { animation: checkmarkPop 0.6s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes checkmarkPop {
            0%   { transform: scale(0) rotate(-180deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg);    opacity: 1; }
        }

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

        {{-- ============================================== --}}
        {{-- LEFT COLUMN: ANIMATED HERO SECTION             --}}
        {{-- ============================================== --}}
        <div id="heroContainer" class="relative hero-bg overflow-hidden text-white flex flex-col justify-between p-8 sm:p-12 lg:p-16 min-h-[460px] lg:min-h-screen select-none">

            <canvas id="particleCanvas"></canvas>

            {{-- Floating Blobs --}}
            <div class="blob-1 absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-400/25 blur-3xl pointer-events-none"></div>
            <div class="blob-2 absolute top-1/2 -right-28 w-96 h-96 rounded-full bg-indigo-500/30 blur-3xl pointer-events-none"></div>
            <div class="blob-3 absolute -bottom-20 left-1/4 w-80 h-80 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>

            {{-- Geometric Wireframe --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" fill="none">
                <circle cx="280" cy="300" r="320" stroke="white" stroke-width="1.5" stroke-dasharray="6 8" class="spin-slow" opacity="0.22" />
                <circle cx="280" cy="300" r="440" stroke="white" stroke-width="1" stroke-dasharray="4 6" class="spin-reverse-slow" opacity="0.15" />
                <path class="animated-line-1" d="M-100,500 C150,150 450,20 850,-50" stroke="white" stroke-width="2" />
                <path class="animated-line-2" d="M-50,600 C200,250 500,80 900,20" stroke="white" stroke-width="1.8" />
                <path class="animated-line-1" d="M0,700 C250,350 550,140 950,90" stroke="white" stroke-width="1.5" opacity="0.25" />
                <path class="animated-line-2" d="M50,800 C300,450 600,200 1000,160" stroke="white" stroke-width="1.2" opacity="0.2" />
            </svg>

            <div class="hidden lg:block absolute top-0 bottom-0 right-0 w-28 bg-gradient-to-l from-white/10 via-transparent to-transparent pointer-events-none z-10"></div>

            {{-- Top Brand --}}
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full bg-blue-300/30 blur-md pulse-slow"></div>
                        <div class="absolute inset-1 rounded-full border border-dashed border-white/40 spin-slow"></div>
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white relative z-10 drop-shadow-md" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/>
                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                            <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/>
                            <path d="M2 7h20"/>
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
                    <span>Sistem Aman</span>
                </div>
            </div>

            {{-- Center Headline --}}
            <div class="relative z-10 max-w-lg my-10 lg:my-auto">

                <div class="float-card-1 inline-flex items-center gap-2.5 glass-box px-4 py-2 rounded-2xl mb-6 shadow-xl transition-all hover:scale-105 cursor-default">
                    <div class="w-7 h-7 rounded-xl bg-amber-400/20 text-amber-300 flex items-center justify-center text-sm shadow-inner">
                        🔐
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white tracking-wide">Keamanan Akun</p>
                        <p class="text-[10px] text-blue-100/80">Enkripsi data end-to-end</p>
                    </div>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Lupa Kata<br>
                    <span class="bg-gradient-to-r from-white via-blue-100 to-cyan-200 bg-clip-text text-transparent">
                        Sandi?
                    </span>
                    <span class="bounce-gentle ml-1">🔑</span>
                </h1>

                <p class="mt-5 text-sm sm:text-base text-blue-100/90 leading-relaxed font-normal max-w-md">
                    Jangan khawatir. Masukkan email akun Anda dan Admin akan membantu memulihkan akses dengan cepat dan aman.
                </p>

                <div class="float-card-2 inline-flex items-center gap-3 glass-box px-4 py-2.5 rounded-2xl mt-8 shadow-xl transition-all hover:scale-105 cursor-default">
                    <div class="w-8 h-8 rounded-xl bg-emerald-400/20 text-emerald-300 flex items-center justify-center text-base shadow-inner">
                        🛡️
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-xs font-bold text-white">Pemulihan Instan</span>
                        </div>
                        <p class="text-[10px] text-blue-100/80">Proses reset cepat via Admin</p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
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

        {{-- ============================================== --}}
        {{-- RIGHT COLUMN: FORGOT PASSWORD FORM             --}}
        {{-- ============================================== --}}
        <div class="flex flex-col justify-between p-8 sm:p-12 lg:p-20 bg-white relative">

            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-50/60 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Top Logo --}}
            <div class="flex items-center justify-between relative z-10">
                <div class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2 select-none">
                    <span class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm font-black shadow-md shadow-blue-500/30">
                        A
                    </span>
                    <span>ATK SMART</span>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full border border-slate-200">
                    Pemulihan Akun
                </span>
            </div>

            {{-- Main Form Area --}}
            <div class="w-full max-w-md mx-auto my-8 lg:my-auto fade-in-up relative z-10">

                {{-- Progress Stepper --}}
                <div class="flex items-start mb-8">
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shadow-md shadow-blue-600/30 ring-4 ring-blue-100">
                            1
                        </div>
                        <span class="text-[10px] font-bold text-blue-600 text-center whitespace-nowrap">Verifikasi<br>Email</span>
                    </div>
                    <div class="step-connector"></div>
                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 text-xs font-bold flex items-center justify-center border-2 border-slate-200">
                            2
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400 text-center whitespace-nowrap">Konfirmasi<br>Admin</span>
                    </div>
                    <div class="step-connector"></div>
                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 text-xs font-bold flex items-center justify-center border-2 border-slate-200">
                            3
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400 text-center whitespace-nowrap">Reset<br>Sandi</span>
                    </div>
                </div>

                {{-- Title --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        Lupa Kata Sandi?
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Masukkan email akun Anda. Sistem akan memverifikasi dan mengarahkan Anda ke WhatsApp Admin untuk proses reset segera.
                    </p>
                </div>

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-start gap-2.5">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600 mt-0.5">
                            <svg class="w-4 h-4 success-checkmark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold mb-0.5">Permintaan Terkirim!</p>
                            <p class="font-normal text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2.5">
                        <div class="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center shrink-0 text-rose-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
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

                {{-- Form --}}
                <form action="{{ route('password.forgot.post') }}" method="POST" class="space-y-5" id="forgotPasswordForm">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email Akun
                        </label>
                        <div class="relative">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email terdaftar..."
                                class="custom-input w-full px-4 py-3.5 pr-11 text-sm font-medium text-slate-900 placeholder-slate-400 {{ old('email') ? 'active' : '' }}"
                                required
                                autofocus
                            >
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-[11px] text-slate-400 font-medium">
                            Gunakan email yang sama saat mendaftar akun
                        </p>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="shimmer-btn w-full py-3.5 px-6 bg-slate-900 hover:bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-blue-600/30 transition-all duration-300 cursor-pointer flex items-center justify-center gap-2 hover:scale-[1.01] active:scale-98"
                        >
                            <span id="submitText">Kirim Instruksi Reset</span>
                            <svg id="submitArrow" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                            <svg id="submitSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 12 0 12 0v4a8 8 0 00-8 8H4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Back to Login --}}
                <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors group"
                    >
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke halaman masuk
                    </a>
                </div>
            </div>

            <div class="hidden lg:block"></div>
        </div>
    </div>

    <script>
        // Particle Canvas
        (function () {
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let width, height, particles = [];
            const COUNT = 42;

            function resize() {
                const rect = canvas.parentElement.getBoundingClientRect();
                width = canvas.width = rect.width;
                height = canvas.height = rect.height;
            }
            window.addEventListener('resize', resize);
            resize();

            class Particle {
                constructor() { this.reset(); }
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
                        this.reset(); this.y = height + 10;
                    }
                }
                draw() {
                    ctx.save();
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255,255,255,${Math.max(0.1, Math.min(0.85, this.alpha))})`;
                    ctx.shadowBlur = 8;
                    ctx.shadowColor = 'rgba(255,255,255,0.8)';
                    ctx.fill();
                    ctx.restore();
                }
            }

            for (let i = 0; i < COUNT; i++) particles.push(new Particle());
            function animate() {
                ctx.clearRect(0, 0, width, height);
                particles.forEach(p => { p.update(); p.draw(); });
                requestAnimationFrame(animate);
            }
            animate();
        })();

        // Hero Parallax
        (function () {
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

        // Submit Loading State
        document.getElementById('forgotPasswordForm').addEventListener('submit', function () {
            const btn    = document.getElementById('submitBtn');
            const text   = document.getElementById('submitText');
            const arrow  = document.getElementById('submitArrow');
            const spin   = document.getElementById('submitSpinner');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            text.textContent = 'Memproses...';
            arrow.classList.add('hidden');
            spin.classList.remove('hidden');
        });

        // Auto-update WhatsApp link with typed email
        document.getElementById('email').addEventListener('input', function () {
            const email = encodeURIComponent(this.value);
            const waBtn = document.getElementById('waBtn');
            waBtn.href = `https://wa.me/6282232857302?text=Halo%20Admin%20ATK%20SMART,%20saya%20lupa%20password%20akun%20saya%20(email:%20${email}).%20Mohon%20bantuan%20reset%20password.`;
        });
    </script>
</body>
</html>
