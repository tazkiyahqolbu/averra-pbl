<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — SILART</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 antialiased font-sans">

    <div class="relative w-full max-w-md animate-scale-in">
        <!-- Logo -->
        <a href="/" class="flex items-center justify-center gap-2 mb-6 hover:opacity-90 transition">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-rose text-primary-foreground shadow-petal">
                <!-- Sparkles Icon -->
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                </svg>
            </span>
            <span class="font-serif text-2xl font-semibold tracking-wide text-gray-900">SILART</span>
        </a>

        <!-- Card Container -->
        <div class="rounded-3xl bg-white p-8 shadow-soft border border-border">
            <h1 class="font-serif text-3xl font-semibold text-gray-900">Selamat datang kembali</h1>
            <p class="mt-2 text-sm text-muted-foreground">Masuk untuk mengelola booking & testimoni Bunda.</p>

            <!-- Success Alert (e.g., from registration) -->
            @if (session('success'))
                <div class="mt-5 flex items-start gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-800">
                    <svg class="h-4 w-4 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <path d="m9 11 3 3L22 4"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="mt-5 flex items-start gap-2 rounded-2xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-800 animate-scale-in">
                    <!-- AlertCircle Icon -->
                    <svg class="h-4 w-4 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            <!-- Form -->
            <form action="{{ url('/login') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <!-- Mail Icon -->
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="nama@email.com" 
                            class="w-full rounded-xl h-12 pl-10 pr-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                    </div>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <!-- Lock Icon -->
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="password" name="password" type="password" required 
                            class="w-full rounded-xl h-12 pl-10 pr-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="button" class="text-xs text-primary hover:underline font-medium">Lupa password?</button>
                </div>

                <button type="submit" class="w-full rounded-full h-12 bg-primary text-primary-foreground font-semibold hover:bg-rose-700 active:scale-[0.98] transition shadow-md flex items-center justify-center">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-muted-foreground">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Daftar di sini</a>
            </p>

            <!-- Demo Credentials -->
            <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-100 p-4 text-xs text-gray-600 text-center">
                <div class="font-semibold mb-1 text-gray-800">Demo Akun:</div>
                <div class="space-y-1">
                    <p>Admin: <b class="text-gray-900">admin@silart.id</b> / <b class="text-gray-900">admin123</b></p>
                    <p>User: <b class="text-gray-900">user@silart.id</b> / <b class="text-gray-900">user123</b></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
