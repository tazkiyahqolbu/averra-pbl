<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil — Sanggar Rantiang Tagok</title>

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

        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full opacity-20"
             style="background: radial-gradient(circle, #e8b96a 0%, transparent 70%)"
             aria-hidden="true"></div>

        <div class="relative z-10 flex h-full flex-col justify-between p-12">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-full border border-white/20 bg-white/10 p-0.5">
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-full w-full rounded-full object-cover">
                </div>
                <span class="text-sm font-semibold tracking-wide text-white/80">Sanggar Rantiang Tagok</span>
            </div>

            <div>
                <p class="mb-4 text-xs font-semibold uppercase tracking-[0.2em] text-[#e8b96a]/70">
                    Selamat Bergabung
                </p>
                <h2 class="font-heading text-4xl font-bold leading-snug text-white xl:text-5xl">
                    Akun Anda<br>
                    Siap Digunakan<br>
                    <em class="not-italic text-[#e8b96a]">Sekarang</em>
                </h2>
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-white/50">
                    Masuk dan mulai pesan layanan sanggar favorit Anda — dari kostum hingga paket acara adat.
                </p>
            </div>

            <p class="text-xs text-white/25">© 2025 Sanggar Rantiang Tagok</p>
        </div>
    </aside>

    {{-- ── KANAN: Success Panel ── --}}
    <main id="auth-form" class="auth-form-panel">
        <div class="w-full max-w-sm text-center">

            {{-- Mobile logo --}}
            <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                <div class="h-9 w-9 overflow-hidden rounded-full border border-[#decba5]">
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-full w-full object-cover">
                </div>
                <span class="text-sm font-semibold text-[#4a0f1a]">Sanggar Rantiang Tagok</span>
            </div>

            {{-- Ikon sukses --}}
            <div class="flex justify-center mb-6">
                <svg class="check-circle" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="38" fill="#f0fdf4" stroke="#22c55e" stroke-width="2.5"/>
                    <polyline class="check-path" points="22,42 34,54 58,28" fill="none" stroke="#16a34a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            {{-- Pesan --}}
            <h1 class="font-heading text-3xl font-bold text-gray-900">Pendaftaran Berhasil!</h1>
            <p class="mt-2 text-sm text-[#7a5d58]">
                Halo, <span class="font-semibold text-[#4a0f1a]">{{ session('registered_name') }}</span>!<br>
                Akun Anda telah berhasil dibuat.
            </p>

            {{-- Info box --}}
            <div class="mt-6 rounded-xl border border-[#e2d4c0] bg-[#faf7f2] p-4 text-left space-y-2">
                <div class="flex items-start gap-2.5">
                    <span class="mt-0.5 text-green-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </span>
                    <p class="text-xs text-[#5a4040]">Akun terdaftar dan siap digunakan</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="mt-0.5 text-green-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </span>
                    <p class="text-xs text-[#5a4040]">Silakan masuk untuk mulai memesan layanan</p>
                </div>
            </div>

            {{-- Tombol masuk --}}
            <button id="go-login" onclick="authGo('{{ route('login') }}')"
               class="auth-btn-primary mt-6 cursor-pointer items-center gap-2 hover:opacity-90 hover:shadow-lg active:scale-[0.98]">
                Masuk ke Akun
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>

            <p class="mt-5 text-xs text-[#7a5d58]">
                <a href="{{ url('/') }}" class="hover:text-[#7b1c2e] transition">← Kembali ke beranda</a>
            </p>

        </div>
    </main>

</body>
</html>
