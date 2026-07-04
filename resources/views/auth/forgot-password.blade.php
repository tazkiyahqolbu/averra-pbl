<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-split-page font-body antialiased">
    <div id="auth-veil" style="position:fixed;inset:0;z-index:9999;pointer-events:none;background:#fffdf7;opacity:1;"></div>
    <script>
    (function () {
        var v = document.getElementById('auth-veil');
        v.style.transition = 'opacity 0.22s ease';
        requestAnimationFrame(function () { requestAnimationFrame(function () { v.style.opacity = '0'; }); });
        window.authGo = function (href) {
            v.style.transition = 'none';
            v.style.opacity = '1';
            v.style.pointerEvents = 'auto';
            setTimeout(function () { window.location.href = href; }, 30);
        };
    })();
    </script>

    {{-- ── KIRI: Brand Panel ── --}}
    <aside id="auth-brand" class="auth-brand-panel hidden lg:flex">

        {{-- Motif geometri diamond --}}
        <div class="absolute inset-0 opacity-[0.06]" aria-hidden="true">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="geo" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                        <path d="M40 3 L77 40 L40 77 L3 40 Z" fill="none" stroke="white" stroke-width="1"/>
                        <path d="M40 16 L64 40 L40 64 L16 40 Z" fill="none" stroke="white" stroke-width="0.7"/>
                        <path d="M40 28 L52 40 L40 52 L28 40 Z" fill="none" stroke="white" stroke-width="0.5"/>
                        <circle cx="40" cy="40" r="1.5" fill="white"/>
                        <circle cx="40" cy="3"  r="1"   fill="white"/>
                        <circle cx="77" cy="40" r="1"   fill="white"/>
                        <circle cx="40" cy="77" r="1"   fill="white"/>
                        <circle cx="3"  cy="40" r="1"   fill="white"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#geo)"/>
            </svg>
        </div>

        {{-- Radial glow pojok kanan bawah --}}
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full opacity-20"
             style="background: radial-gradient(circle, #e8b96a 0%, transparent 70%)"
             aria-hidden="true"></div>

        {{-- Konten --}}
        <div class="relative z-10 flex h-full flex-col justify-between p-12">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border border-white/20 bg-white/10 p-0.5">
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-full w-full rounded-full object-cover">
                </div>
                <span class="text-sm font-semibold tracking-wide text-white/80">Sanggar Rantiang Tagok</span>
            </div>

            <div>
                <p class="mb-4 text-xs font-semibold uppercase tracking-[0.2em] text-[#e8b96a]/70">
                    Pemulihan Akun
                </p>
                <h2 class="font-heading text-4xl font-bold leading-snug text-white xl:text-5xl">
                    Lupa Password<br>
                    Akun Anda?<br>
                    <em class="not-italic text-[#e8b96a]">Jangan Khawatir</em>
                </h2>
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-white/50">
                    Kami akan mengirikan kode verifikasi OTP ke email Anda untuk mereset password.
                </p>
            </div>

            <p class="text-xs text-white/25">© 2025 Sanggar Rantiang Tagok</p>
        </div>
    </aside>

    {{-- ── KANAN: Form Panel ── --}}
    <main id="auth-form" class="auth-form-panel">
        <div class="w-full max-w-sm">

            {{-- Mobile logo --}}
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <div class="h-9 w-9 overflow-hidden rounded-full border border-[#decba5]">
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-full w-full rounded-full object-cover">
                </div>
                <span class="text-sm font-semibold text-[#4a0f1a]">Sanggar Rantiang Tagok</span>
            </div>

            <div class="mb-7">
                <h1 class="font-heading text-3xl font-bold text-[#4A0F1A]">Lupa Password</h1>
                <p class="mt-1.5 text-sm text-[#7a5d58]">Masukkan email terdaftar Anda untuk menerima kode OTP.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.send-otp') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="auth-label">Email Terdaftar</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#a08070]"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input id="email" name="email" type="email" required autofocus
                            value="{{ old('email') }}" placeholder="nama@email.com"
                            class="auth-input pl-10 pr-4 focus:border-[#7b1c2e] focus:ring-2 focus:ring-[#7b1c2e]/10">
                    </div>
                </div>

                <button type="submit" class="auth-btn-primary hover:opacity-90 hover:shadow-lg active:scale-[0.98]">
                    Kirim Kode OTP
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#7a5d58]">
                Ingat password Anda?
                <a href="{{ route('login') }}" id="go-login" class="font-semibold text-[#7b1c2e] hover:underline">
                    Kembali ke Masuk
                </a>
            </p>

        </div>
    </main>

    <script>
        document.getElementById('go-login')?.addEventListener('click', function (e) {
            e.preventDefault();
            authGo(this.href);
        });

        document.querySelector('form')?.addEventListener('submit', function () {
            var v = document.getElementById('auth-veil');
            if (v) { v.style.transition = 'none'; v.style.opacity = '1'; v.style.pointerEvents = 'auto'; }
        });
    </script>

</body>
</html>
