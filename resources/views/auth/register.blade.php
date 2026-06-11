<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-page flex min-h-screen items-center justify-center p-4 py-8 font-body antialiased">
    <main class="w-full max-w-md animate-scale-in">
        <section class="auth-card p-7 sm:p-8">
            <div class="mb-6 flex items-center gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-[#5A0B1A] bg-white">
                    <img
                        src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}"
                        alt="Logo Rantiang Tagok"
                        class="h-full w-full object-cover"
                    >
                </div>

                <div>
                    <h1 class="font-heading text-2xl font-semibold tracking-wide text-gray-900">
                        Buat Akun Baru
                    </h1>
                    <p class="text-sm text-[#7a5d58]">
                        Daftarkan akun untuk mengakses layanan dan pemesanan sanggar.
                    </p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-5 flex items-start gap-2 rounded-2xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-800">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" x2="12" y1="8" y2="12"/>
                        <line x1="12" x2="12.01" y1="16" y2="16"/>
                    </svg>

                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nama" class="auth-label">Nama Lengkap</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#5A0B1A]/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21a8 8 0 0 0-16 0"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>

                        <input
                            id="nama"
                            name="nama"
                            type="text"
                            required
                            value="{{ old('nama') }}"
                            placeholder="Nama lengkap"
                            class="auth-input pl-10 pr-4 focus:border-[#5A0B1A] focus:ring focus:ring-[#5A0B1A]/20"
                        >
                    </div>
                </div>

                <div>
                    <label for="email" class="auth-label">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#5A0B1A]/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="auth-input pl-10 pr-4 focus:border-[#5A0B1A] focus:ring focus:ring-[#5A0B1A]/20"
                        >
                    </div>
                </div>

                <div>
                    <label for="no_hp" class="auth-label">Nomor Telepon</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#5A0B1A]/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.61a2 2 0 0 1-.45 2.11L8 9.72a16 16 0 0 0 6 6l1.28-1.28a2 2 0 0 1 2.11-.45c.84.29 1.71.5 2.61.62A2 2 0 0 1 22 16.92z"/>
                        </svg>

                        <input
                            id="no_hp"
                            name="no_hp"
                            type="tel"
                            required
                            value="{{ old('no_hp') }}"
                            placeholder="08xx xxxx xxxx"
                            class="auth-input pl-10 pr-4 focus:border-[#5A0B1A] focus:ring focus:ring-[#5A0B1A]/20"
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="auth-label">Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#5A0B1A]/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="11" x="3" y="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="Minimal 6 karakter"
                            class="auth-input pl-10 pr-12 focus:border-[#5A0B1A] focus:ring focus:ring-[#5A0B1A]/20"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full text-[#5A0B1A]/70 transition hover:bg-[#F8F3EA] hover:text-[#5A0B1A]"
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
                            "
                        >
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

                <div>
                    <label for="password_confirmation" class="auth-label">Konfirmasi Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#5A0B1A]/70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="11" x="3" y="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            placeholder="Ulangi password"
                            class="auth-input pl-10 pr-12 focus:border-[#5A0B1A] focus:ring focus:ring-[#5A0B1A]/20"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full text-[#5A0B1A]/70 transition hover:bg-[#F8F3EA] hover:text-[#5A0B1A]"
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
                            "
                        >
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

                <button
                    type="submit"
                    class="auth-btn-primary hover:bg-[#4b0917] active:scale-[0.98]"
                >
                    Daftar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#7a5d58]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-[#7b1c2e] hover:underline">
                    Masuk di sini
                </a>
            </p>
        </section>
    </main>
</body>
</html>
