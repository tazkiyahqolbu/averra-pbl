<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-page font-body flex min-h-screen items-center justify-center p-4 antialiased">
    <main class="w-full max-w-md animate-scale-in">
        <section class="auth-card p-7 sm:p-8">
            <div class="mb-7 flex items-center gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-[#5A0B1A] bg-white p-1">
                    <img
                        src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}"
                        alt="Logo Sanggar Rantiang Tagok"
                        class="h-full w-full rounded-full object-cover"
                    >
                </div>

                <div>
                    <h1 class="font-heading text-2xl font-bold leading-tight text-gray-900">
                        Sanggar Rantiang Tagok
                    </h1>
                    <p class="mt-1 text-sm leading-5 text-[#7a5d58]">
                        Melestarikan seni dan budaya Minangkabau melalui layanan digital.
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="auth-label">Email</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7a5d58]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            class="auth-input pl-11 pr-4 focus:border-[#7b1c2e] focus:ring-2 focus:ring-[#7b1c2e]/15"
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="auth-label">Password</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7a5d58]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="11" x="3" y="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="Masukkan password"
                            class="auth-input pl-11 pr-12 focus:border-[#7b1c2e] focus:ring-2 focus:ring-[#7b1c2e]/15"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full text-[#7a5d58] transition hover:bg-[#f3eadc] hover:text-[#5A0B1A]"
                            aria-label="Tampilkan password"
                            onclick="
                                const input = document.getElementById('password');
                                const eye = document.getElementById('eye-icon');
                                const eyeOff = document.getElementById('eye-off-icon');

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
                            <svg id="eye-icon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>

                            <svg id="eye-off-icon" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/>
                                <path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/>
                                <path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="button" class="text-xs font-semibold text-[#7b1c2e] hover:underline opacity-60 cursor-not-allowed">
                        Lupa password?
                    </button>
                </div>

                <button type="submit" class="auth-btn-primary hover:bg-[#5A0B1A] active:scale-[0.98]">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#7a5d58]">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-[#7b1c2e] hover:underline">
                    Daftar di sini
                </a>
            </p>

            <div class="mt-6 rounded-2xl border border-[#ead8b8] bg-[#f8f3ea] p-4 text-center text-xs text-[#5A0B1A]">
                <p class="mb-3 font-semibold">Demo Akun</p>

                <div class="overflow-hidden rounded-xl border border-[#ead8b8] bg-[#fffdf7]">
                    <div class="border-b border-[#ead8b8] p-3">
                        <span class="font-semibold">Admin:</span>
                        <span class="font-semibold text-gray-800">admin@rantiang.com</span>
                        /
                        <span class="font-semibold text-gray-800">password</span>
                    </div>

                    <div class="p-3">
                        <span class="font-semibold">User:</span>
                        <span class="font-semibold text-gray-800">user@rantiang.com</span>
                        /
                        <span class="font-semibold text-gray-800">password</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
