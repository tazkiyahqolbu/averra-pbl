<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — SILART</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 antialiased font-sans">

    <div class="relative w-full max-w-md animate-scale-in py-10"
         x-data="{
            nama: '{{ old('nama') }}',
            email: '{{ old('email') }}',
            no_hp: '{{ old('no_hp') }}',
            password: '',
            password_confirmation: '',
            clientError: '',
            validateForm(e) {
                if (!this.nama.trim()) {
                    this.clientError = 'Nama wajib diisi.';
                    e.preventDefault();
                    return;
                }
                if (!/^[0-9+\-\s]{8,16}$/.test(this.no_hp)) {
                    this.clientError = 'Nomor telepon tidak valid.';
                    e.preventDefault();
                    return;
                }
                if (this.password.length < 6) {
                    this.clientError = 'Password minimal 6 karakter.';
                    e.preventDefault();
                    return;
                }
                if (this.password !== this.password_confirmation) {
                    this.clientError = 'Konfirmasi password tidak cocok.';
                    e.preventDefault();
                    return;
                }
                this.clientError = '';
            }
         }">
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
            <h1 class="font-serif text-3xl font-semibold text-gray-900">Buat akun baru</h1>
            <p class="mt-2 text-sm text-muted-foreground">Gratis · Booking lebih cepat & pantau status.</p>

            <!-- Client-side Error Alert (Alpine.js) -->
            <div x-show="clientError"
                 x-transition
                 class="mt-5 flex items-start gap-2 rounded-2xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-800"
                 style="display: none;">
                <!-- AlertCircle Icon -->
                <svg class="h-4 w-4 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
                <span x-text="clientError"></span>
            </div>

            <!-- Server-side Error Alerts (Laravel) -->
            @if ($errors->any())
                <div x-show="!clientError" class="mt-5 flex items-start gap-2 rounded-2xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-800">
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
            <form action="{{ url('/register') }}" method="POST" @submit="validateForm($event)" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="nama" class="mb-2 block text-sm font-medium text-gray-700">Nama lengkap</label>
                    <input id="nama" name="nama" type="text" required x-model="nama"
                        class="w-full rounded-xl h-12 px-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required x-model="email"
                        class="w-full rounded-xl h-12 px-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                </div>

                <div>
                    <label for="no_hp" class="mb-2 block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input id="no_hp" name="no_hp" type="tel" required x-model="no_hp" placeholder="08xx xxxx xxxx"
                        class="w-full rounded-xl h-12 px-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required x-model="password"
                            class="w-full rounded-xl h-12 px-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                    </div>
                    <div>
                        <label for="confirm" class="mb-2 block text-sm font-medium text-gray-700">Konfirmasi</label>
                        <input id="confirm" name="password_confirmation" type="password" required x-model="password_confirmation"
                            class="w-full rounded-xl h-12 px-4 border border-border focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" />
                    </div>
                </div>

                <button type="submit" class="w-full rounded-full h-12 bg-primary text-primary-foreground font-semibold hover:bg-rose-700 active:scale-[0.98] transition shadow-md flex items-center justify-center">
                    Daftar
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-muted-foreground">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Masuk</a>
            </p>
        </div>
    </div>

</body>
</html>
