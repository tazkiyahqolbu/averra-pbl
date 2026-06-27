<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password — Sanggar Rantiang Tagok</title>

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
                    Satu Langkah Lagi
                </p>
                <h2 class="font-heading text-4xl font-bold leading-snug text-white xl:text-5xl">
                    Buat Password<br>
                    Baru Akun Anda<br>
                    <em class="not-italic text-[#e8b96a]">Aman & Kuat</em>
                </h2>
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-white/50">
                    Buat kata sandi baru minimal 8 karakter untuk mengamankan akun Anda kembali.
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
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-full w-full object-cover">
                </div>
                <span class="text-sm font-semibold text-[#4a0f1a]">Sanggar Rantiang Tagok</span>
            </div>

            <div class="mb-7">
                <h1 class="font-heading text-3xl font-bold text-[#4A0F1A]">Reset Password</h1>
                <p class="mt-1.5 text-sm text-[#7a5d58]">Silakan masukkan kata sandi baru Anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="auth-label">Password Baru</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#a08070]"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="11" x="3" y="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="password" name="password" type="password" required autofocus
                            placeholder="Minimal 8 karakter"
                            class="auth-input pl-10 pr-11 focus:border-[#7b1c2e] focus:ring-2 focus:ring-[#7b1c2e]/10">
                        <button type="button"
                            class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-[#a08070] transition hover:bg-[#f3eadc] hover:text-[#5A0B1A]"
                            aria-label="Tampilkan password"
                            onclick="
                                const input = document.getElementById('password');
                                const eye = document.getElementById('eye-password');
                                const eyeOff = document.getElementById('eye-off-password');
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    eye.classList.add('hidden');
                                    eyeOff.classList.remove('hidden');
                                    this.setAttribute('aria-label', 'Sembunyikan password');
                                } else {
                                    input.type = 'password';
                                    eye.classList.remove('hidden');
                                    eyeOff.classList.add('hidden');
                                    this.setAttribute('aria-label', 'Tampilkan password');
                                }
                            ">
                            <svg id="eye-password" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye-off-password" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/>
                                <path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/>
                                <path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="auth-label">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#a08070]"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="11" x="3" y="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            placeholder="Ulangi password baru"
                            class="auth-input pl-10 pr-11 focus:border-[#7b1c2e] focus:ring-2 focus:ring-[#7b1c2e]/10">
                        <button type="button"
                            class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-lg text-[#a08070] transition hover:bg-[#f3eadc] hover:text-[#5A0B1A]"
                            aria-label="Tampilkan konfirmasi password"
                            onclick="
                                const input = document.getElementById('password_confirmation');
                                const eye = document.getElementById('eye-confirm');
                                const eyeOff = document.getElementById('eye-off-confirm');
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    eye.classList.add('hidden');
                                    eyeOff.classList.remove('hidden');
                                    this.setAttribute('aria-label', 'Sembunyikan konfirmasi password');
                                } else {
                                    input.type = 'password';
                                    eye.classList.remove('hidden');
                                    eyeOff.classList.add('hidden');
                                    this.setAttribute('aria-label', 'Tampilkan konfirmasi password');
                                }
                            ">
                            <svg id="eye-confirm" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye-off-confirm" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/>
                                <path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/>
                                <path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-btn-primary mt-2 hover:opacity-90 hover:shadow-lg active:scale-[0.98]">
                    Simpan Password Baru
                </button>
            </form>

        </div>
    </main>

    <script>
        document.querySelector('form')?.addEventListener('submit', function () {
            var v = document.getElementById('auth-veil');
            if (v) { v.style.transition = 'none'; v.style.opacity = '1'; v.style.pointerEvents = 'auto'; }
        });
    </script>

</body>
</html>
