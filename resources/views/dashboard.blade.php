<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — SILART</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased font-sans text-gray-800">

    @php
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
    @endphp

    <div class="min-h-screen bg-slate-50/50 flex flex-col lg:flex-row" 
         x-data="{ 
            tab: '{{ $isAdmin ? 'ringkasan' : 'beranda' }}',
            detail: null,
            rating: 5,
            statusClass(status) {
                const map = {
                    'Pending': 'bg-amber-100 text-amber-800 border border-amber-200',
                    'Confirmed': 'bg-green-100 text-green-800 border border-green-200',
                    'Selesai': 'bg-blue-100 text-blue-800 border border-blue-200',
                    'Ditolak': 'bg-rose-100 text-rose-800 border border-rose-200'
                };
                return map[status] || 'bg-gray-100 text-gray-800';
            }
         }">

        <!-- Sidebar (Desktop) -->
        <aside class="hidden lg:flex w-64 flex-col bg-white border-r border-border min-h-screen sticky top-0">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-border">
                <a href="/" class="flex items-center gap-2 hover:opacity-90 transition">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-rose text-primary-foreground shadow-petal">
                        <!-- Sparkles Icon -->
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                        </svg>
                    </span>
                    <span class="font-serif text-lg font-semibold text-gray-900">SILART</span>
                </a>
                <p class="mt-3 text-[10px] font-bold uppercase tracking-widest text-primary">{{ $isAdmin ? 'Admin' : 'User' }} Panel</p>
                <p class="text-sm font-medium truncate text-gray-700" title="{{ $user->name }}">{{ $user->name }}</p>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 p-4 space-y-1">
                @if ($isAdmin)
                    <!-- Admin Menu -->
                    <button @click="tab = 'ringkasan'" :class="tab === 'ringkasan' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Home Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Ringkasan
                    </button>
                    <button @click="tab = 'bookings'" :class="tab === 'bookings' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- ClipboardList Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
                        Daftar Booking
                    </button>
                    <button @click="tab = 'layanan'" :class="tab === 'layanan' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Crown Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4 5 12h14l3-8-7 4-3-6-3 6-7-4z"/><path d="M3 20h18"/></svg>
                        Kelola Layanan
                    </button>
                    <button @click="tab = 'kostum'" :class="tab === 'kostum' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Shirt Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 7.83V4c0-1.1-.9-2-2-2H10c-1.1 0-2 .9-2 2v3.83L3.62 3.46a2 2 0 0 0-2.83 0l-.79.79a2 2 0 0 0 0 2.83l4 4V18c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6.92l4-4a2 2 0 0 0 0-2.83l-.79-.79a2 2 0 0 0-2.83 0zM10 4h4v4h-4V4z"/></svg>
                        Kelola Kostum
                    </button>
                    <button @click="tab = 'galeri'" :class="tab === 'galeri' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Image Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        Kelola Galeri
                    </button>
                    <button @click="tab = 'testi'" :class="tab === 'testi' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- MessageSquare Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Testimoni Masuk
                    </button>
                    <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Settings Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Pengaturan
                    </button>
                @else
                    <!-- User Menu -->
                    <button @click="tab = 'beranda'" :class="tab === 'beranda' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Beranda
                    </button>
                    <button @click="tab = 'mybookings'" :class="tab === 'mybookings' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
                        Booking Saya
                    </button>
                    <button @click="tab = 'new'" :class="tab === 'new' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- Plus Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                        Buat Booking Baru
                    </button>
                    <button @click="tab = 'testi'" :class="tab === 'testi' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Tulis Testimoni
                    </button>
                    <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-gradient-rose text-primary-foreground shadow-soft font-semibold' : 'hover:bg-slate-100 text-gray-600 hover:text-gray-900'" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                        <!-- User Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil Saya
                    </button>
                @endif
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-border space-y-1">
                <a href="/" class="w-full justify-start rounded-xl px-3 py-2 text-xs font-medium text-gray-500 hover:text-gray-900 hover:bg-slate-100 flex items-center gap-2 transition">
                    Kembali ke Beranda
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" class="w-full text-left rounded-xl px-3 py-2.5 text-sm font-semibold text-rose-700 hover:bg-rose-50 hover:text-rose-800 flex items-center gap-3 transition">
                        <!-- LogOut Icon -->
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 min-w-0 flex flex-col">
            
            <!-- Mobile Top Bar -->
            <div class="lg:hidden sticky top-0 z-30 bg-white border-b border-border px-4 py-3 flex items-center gap-3 overflow-x-auto">
                <a href="/" class="flex items-center gap-1.5 shrink-0 hover:opacity-90 transition">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-rose text-primary-foreground shadow-petal">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                        </svg>
                    </span>
                    <span class="font-serif font-semibold text-gray-900">SILART</span>
                </a>
                <div class="flex gap-1 overflow-x-auto py-1 pr-4">
                    @if ($isAdmin)
                        <!-- Admin Mobile Menu -->
                        <button @click="tab = 'ringkasan'" :class="tab === 'ringkasan' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Ringkasan</button>
                        <button @click="tab = 'bookings'" :class="tab === 'bookings' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Daftar Booking</button>
                        <button @click="tab = 'layanan'" :class="tab === 'layanan' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Layanan</button>
                        <button @click="tab = 'kostum'" :class="tab === 'kostum' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Kostum</button>
                        <button @click="tab = 'galeri'" :class="tab === 'galeri' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Galeri</button>
                        <button @click="tab = 'testi'" :class="tab === 'testi' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Testimoni</button>
                        <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Pengaturan</button>
                    @else
                        <!-- User Mobile Menu -->
                        <button @click="tab = 'beranda'" :class="tab === 'beranda' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Beranda</button>
                        <button @click="tab = 'mybookings'" :class="tab === 'mybookings' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Booking Saya</button>
                        <button @click="tab = 'new'" :class="tab === 'new' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Booking Baru</button>
                        <button @click="tab = 'testi'" :class="tab === 'testi' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Testimoni</button>
                        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-primary text-primary-foreground font-semibold shadow-sm' : 'bg-slate-100 text-gray-600'" class="shrink-0 rounded-full px-3 py-1.5 text-xs transition">Profil</button>
                    @endif
                </div>
            </div>

            <!-- Page Main Content Container -->
            <main class="p-5 sm:p-8 max-w-6xl w-full mx-auto animate-fade-in flex-1">

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 animate-scale-in">
                        <svg class="h-4.5 w-4.5 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-2 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-800 animate-scale-in">
                        <svg class="h-4.5 w-4.5 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif


                <!-- ==================== ADMIN PANELS ==================== -->
                @if ($isAdmin)
                    
                    <!-- TAB: RINGKASAN -->
                    <div x-show="tab === 'ringkasan'" class="space-y-6">
                        <!-- Stats Grid -->
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 animate-scale-in">
                            <div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-primary">
                                    <!-- Calendar Icon -->
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                </div>
                                <p class="mt-4 text-3xl font-serif font-bold text-gray-900">{{ $thisMonthBookingsCount }}</p>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Booking Bulan Ini</p>
                            </div>

                            <div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                    <!-- Bell Icon -->
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                                </div>
                                <p class="mt-4 text-3xl font-serif font-bold text-amber-700">{{ $pendingBookingsCount }}</p>
                                <p class="text-xs font-medium text-amber-600 uppercase tracking-wide mt-1">Pending</p>
                            </div>

                            <div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                    <!-- CheckCircle2 Icon -->
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                </div>
                                <p class="mt-4 text-3xl font-serif font-bold text-emerald-700">{{ $confirmedBookingsCount }}</p>
                                <p class="text-xs font-medium text-emerald-600 uppercase tracking-wide mt-1">Confirmed</p>
                            </div>

                            <div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                                    <!-- ClipboardList Icon -->
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
                                </div>
                                <p class="mt-4 text-3xl font-serif font-bold text-gray-900">{{ $totalBookingsCount }}</p>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mt-1">Total Booking</p>
                            </div>
                        </div>

                        <!-- Notifications / Pending List -->
                        <div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                                <h3 class="font-serif text-xl font-semibold text-gray-900">Notifikasi Booking Baru</h3>
                            </div>
                            
                            @php $pendingBookings = $bookings->where('status', 'Pending'); @endphp
                            
                            @if ($pendingBookings->isEmpty())
                                <p class="text-sm text-muted-foreground">Tidak ada booking pending.</p>
                            @else
                                <ul class="divide-y divide-border">
                                    @foreach ($pendingBookings->take(5) as $b)
                                        <li class="py-4 flex items-center justify-between gap-4">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $b->name }} <span class="text-muted-foreground text-xs font-normal">· {{ $b->id }}</span></p>
                                                <p class="text-xs text-muted-foreground mt-1">{{ $b->service }} · {{ $b->date }} · {{ $b->location }}</p>
                                            </div>
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Pending</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: DAFTAR BOOKING -->
                    <div x-show="tab === 'bookings'" class="rounded-3xl bg-white border border-border p-6 shadow-soft animate-scale-in">
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Daftar Booking</h2>
                        
                        <div class="mt-5 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-xs uppercase tracking-wider text-muted-foreground border-b border-border">
                                        <th class="py-3 pr-3 font-semibold">Pemesan</th>
                                        <th class="py-3 pr-3 font-semibold">Layanan</th>
                                        <th class="py-3 pr-3 font-semibold">Tanggal</th>
                                        <th class="py-3 pr-3 font-semibold">Lokasi</th>
                                        <th class="py-3 pr-3 font-semibold">Status</th>
                                        <th class="py-3 pr-3 text-right font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach ($bookings as $b)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-3 pr-3">
                                                <p class="font-semibold text-gray-900">{{ $b->name }}</p>
                                                <p class="text-xs text-muted-foreground">{{ $b->id }}</p>
                                            </td>
                                            <td class="py-3 pr-3 text-gray-700">{{ $b->service }}</td>
                                            <td class="py-3 pr-3 text-gray-600">{{ $b->date }}</td>
                                            <td class="py-3 pr-3 text-gray-600">{{ $b->location }}</td>
                                            <td class="py-3 pr-3">
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium" :class="statusClass('{{ $b->status }}')">
                                                    {{ $b->status }}
                                                </span>
                                            </td>
                                            <td class="py-3 pr-3">
                                                <div class="flex gap-2 justify-end items-center">
                                                    @if ($b->status === 'Pending')
                                                        <!-- Confirm Form -->
                                                        <form action="{{ route('dashboard.booking.status', $b->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Confirmed">
                                                            <button type="submit" title="Setujui Booking" class="rounded-full h-8 w-8 flex items-center justify-center text-emerald-700 hover:bg-emerald-50 active:scale-95 transition">
                                                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
                                                            </button>
                                                        </form>
                                                        <!-- Reject Form -->
                                                        <form action="{{ route('dashboard.booking.status', $b->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Ditolak">
                                                            <button type="submit" title="Tolak Booking" class="rounded-full h-8 w-8 flex items-center justify-center text-rose-700 hover:bg-rose-50 active:scale-95 transition">
                                                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m9 9 6 6m0-6-6 6"/></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <!-- View Details Button -->
                                                    <button @click="detail = {{ json_encode($b) }}" class="rounded-full h-8 w-8 flex items-center justify-center text-gray-500 hover:bg-slate-100 active:scale-95 transition" title="Lihat Detail">
                                                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB: TESTIMONI MASUK -->
                    <div x-show="tab === 'testi'" class="rounded-3xl bg-white border border-border p-6 shadow-soft animate-scale-in">
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Testimoni Masuk</h2>
                        
                        <div class="mt-5 grid gap-4 md:grid-cols-2">
                            @foreach ($testimonials as $t)
                                <div class="rounded-2xl border border-border p-5 shadow-sm hover:shadow-md transition">
                                    <p class="font-semibold text-gray-900">{{ $t->name }}</p>
                                    <div class="flex mt-1 text-primary">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="h-3.5 w-3.5 {{ $i < $t->rating ? 'fill-primary' : 'text-slate-200' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        @endfor
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600 italic">"{{ $t->message }}"</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- STUBS FOR REMAINING ADMIN TABS -->
                    <div x-show="tab === 'layanan'" class="rounded-3xl bg-white border border-border p-10 text-center shadow-soft animate-scale-in">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-primary mx-auto mb-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Kelola Layanan</h2>
                        <p class="mt-2 text-muted-foreground max-w-md mx-auto">Tambah, ubah, atau nonaktifkan layanan & harga.</p>
                    </div>

                    <div x-show="tab === 'kostum'" class="rounded-3xl bg-white border border-border p-10 text-center shadow-soft animate-scale-in">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-primary mx-auto mb-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Kelola Kostum</h2>
                        <p class="mt-2 text-muted-foreground max-w-md mx-auto">Tambah kostum baru, update stok & status ketersediaan.</p>
                    </div>

                    <div x-show="tab === 'galeri'" class="rounded-3xl bg-white border border-border p-10 text-center shadow-soft animate-scale-in">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-primary mx-auto mb-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Kelola Galeri</h2>
                        <p class="mt-2 text-muted-foreground max-w-md mx-auto">Upload foto kegiatan & atur kategori.</p>
                    </div>

                    <div x-show="tab === 'settings'" class="rounded-3xl bg-white border border-border p-10 text-center shadow-soft animate-scale-in">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-primary mx-auto mb-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </div>
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Pengaturan</h2>
                        <p class="mt-2 text-muted-foreground max-w-md mx-auto">Profil sanggar, kontak, & jam operasional.</p>
                    </div>

                <!-- ==================== USER PANELS ==================== -->
                @else
                    
                    <!-- TAB: BERANDA -->
                    <div x-show="tab === 'beranda'" class="space-y-6">
                        <!-- Welcome Banner -->
                        <div class="rounded-3xl bg-gradient-warm border border-border p-8 shadow-soft animate-scale-in">
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Selamat datang</p>
                            <h2 class="mt-2 font-serif text-3xl font-bold text-gray-900">{{ $user->name }} ✨</h2>
                            <p class="mt-2 text-sm text-gray-600">Pantau status booking Bunda di sini.</p>
                            <a href="{{ route('booking') }}" class="mt-5 inline-flex items-center justify-center rounded-full px-6 py-2.5 bg-primary text-primary-foreground font-semibold hover:bg-rose-700 active:scale-95 shadow-sm transition">
                                Buat Booking Baru
                            </a>
                        </div>

                        <!-- Recent Bookings Card -->
                        <div class="rounded-3xl bg-white border border-border p-6 shadow-soft animate-scale-in">
                            <div class="flex items-center justify-between">
                                <h3 class="font-serif text-xl font-semibold text-gray-900">Booking Terbaru</h3>
                                <button @click="tab = 'mybookings'" class="text-xs font-semibold text-primary hover:underline transition">Lihat semua</button>
                            </div>
                            
                            @if ($bookings->isEmpty())
                                <p class="text-sm text-muted-foreground mt-4">Belum ada booking. <a href="{{ route('booking') }}" class="text-primary font-medium hover:underline">Mulai booking pertama</a>.</p>
                            @else
                                <ul class="mt-3 divide-y divide-border">
                                    @foreach ($bookings->take(3) as $b)
                                        <li class="py-4 flex items-center justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $b->service }}</p>
                                                <p class="text-xs text-muted-foreground mt-1">{{ $b->date }} · {{ $b->location }}</p>
                                            </div>
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium" :class="statusClass('{{ $b->status }}')">
                                                {{ $b->status }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- TAB: BOOKING SAYA -->
                    <div x-show="tab === 'mybookings'" class="rounded-3xl bg-white border border-border p-6 shadow-soft animate-scale-in">
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Booking Saya</h2>
                        
                        @if ($bookings->isEmpty())
                            <p class="mt-4 text-sm text-muted-foreground">Belum ada riwayat booking.</p>
                        @else
                            <div class="mt-5 grid gap-3">
                                @foreach ($bookings as $b)
                                    <div class="rounded-2xl border border-border p-5 flex flex-wrap items-center justify-between gap-3 shadow-sm hover:shadow-md transition">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $b->service }} <span class="text-xs text-muted-foreground font-normal">· {{ $b->id }}</span></p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $b->date }} · {{ $b->location }}</p>
                                        </div>
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium" :class="statusClass('{{ $b->status }}')">
                                            {{ $b->status }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- TAB: BUAT BOOKING NEW -->
                    <div x-show="tab === 'new'" class="rounded-3xl bg-white border border-border p-8 text-center shadow-soft animate-scale-in">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-primary mx-auto mb-4">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                            </svg>
                        </span>
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Buat Booking Baru</h2>
                        <p class="mt-2 text-sm text-gray-600">Form booking lengkap tersedia di halaman publik.</p>
                        <a href="{{ route('booking') }}" class="mt-6 inline-flex items-center justify-center rounded-full px-6 py-2.5 bg-primary text-primary-foreground font-semibold hover:bg-rose-700 active:scale-95 shadow-sm transition">
                            Buka Form Booking
                        </a>
                    </div>

                    <!-- TAB: TULIS TESTIMONI -->
                    <div x-show="tab === 'testi'" class="rounded-3xl bg-white border border-border p-8 shadow-soft animate-scale-in">
                        <h2 class="font-serif text-2xl font-semibold text-gray-900">Tulis Testimoni</h2>
                        
                        @if (!$canSubmitTesti)
                            <div class="text-center py-6">
                                <svg class="h-10 w-10 text-gray-400 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <p class="text-sm text-gray-600">Bunda bisa menulis testimoni setelah memiliki minimal 1 booking.</p>
                            </div>
                        @else
                            <!-- Testi Success Alert -->
                            @if (session('testi_success'))
                                <div class="mt-4 flex items-start gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-800 animate-scale-in">
                                    <svg class="h-4 w-4 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>
                                    </svg>
                                    <span>{{ session('testi_success') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('dashboard.testimoni') }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Rating</label>
                                    <div class="flex gap-1">
                                        <input type="hidden" name="rating" :value="rating">
                                        @for ($n = 1; $n <= 5; $n++)
                                            <button type="button" @click="rating = {{ $n }}" class="focus:outline-none focus:ring-2 focus:ring-rose-100 rounded">
                                                <svg class="h-7 w-7 transition" :class="rating >= {{ $n }} ? 'fill-primary text-primary' : 'text-slate-200 hover:text-primary/50'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                            </button>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label for="message" class="text-sm font-semibold text-gray-700 mb-2 block">Pesan</label>
                                    <textarea id="message" name="message" required minlength="5" rows="4" class="w-full rounded-2xl border border-border p-4 focus:border-primary focus:ring focus:ring-rose-100 focus:outline-none transition text-sm bg-white" placeholder="Pengalaman Bunda bersama SILART..."></textarea>
                                </div>

                                <button type="submit" class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 bg-primary text-primary-foreground font-semibold hover:bg-rose-700 active:scale-95 shadow-sm transition">
                                    <!-- Send Icon -->
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" x2="11" y1="2" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    Kirim
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- TAB: PROFIL SAYA -->
                    <div x-show="tab === 'profile'" class="rounded-3xl bg-white border border-border p-8 shadow-soft max-w-xl animate-scale-in">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-rose text-primary-foreground font-serif text-2xl font-bold shadow-petal">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-serif text-2xl font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-muted-foreground">{{ $user->email }}</p>
                            </div>
                        </div>

                        <dl class="mt-6 space-y-4 text-sm">
                            <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                                <dt class="text-gray-500 font-medium">Email</dt>
                                <dd class="text-gray-900 font-semibold text-right">{{ $user->email }}</dd>
                            </div>
                            @if ($user->phone)
                                <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                                    <dt class="text-gray-500 font-medium">Telepon</dt>
                                    <dd class="text-gray-900 font-semibold text-right">{{ $user->phone }}</dd>
                                </div>
                            @endif
                            <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                                <dt class="text-gray-500 font-medium">Peran</dt>
                                <dd class="text-gray-900 font-semibold text-right capitalize">{{ $user->role }}</dd>
                            </div>
                        </dl>
                    </div>

                @endif

            </main>

            <!-- Mobile Footer (Logout button visible on mobile for convenience) -->
            <div class="lg:hidden p-4 border-t border-border bg-white mt-auto">
                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" class="w-full text-center rounded-full py-2 bg-rose-50 text-rose-700 font-semibold border border-rose-100 hover:bg-rose-100 transition active:scale-[0.98] text-sm">
                        Keluar Akun
                    </button>
                </form>
            </div>

        </div>

        <!-- ==================== DETAIL MODAL (ADMIN ONLY) ==================== -->
        <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" 
             x-show="detail" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;"
             @click="detail = null">
            
            <div class="bg-white rounded-3xl p-8 max-w-lg w-full shadow-petal border border-border animate-scale-in" 
                 x-show="detail"
                 @click.stopPropagation()>
                
                <h3 class="font-serif text-2xl font-semibold text-gray-900" x-text="'Detail Booking ' + detail.id"></h3>
                
                <dl class="mt-5 space-y-3.5 text-sm max-h-[60vh] overflow-y-auto pr-1">
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">Nama Pemesan</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.name"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">WhatsApp</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.phone"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">Layanan</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.service"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">Tanggal</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.date"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">Lokasi</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.location"></dd>
                    </div>
                    
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2" x-show="detail.notes">
                        <dt class="text-gray-500 font-medium">Catatan</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.notes || '-'"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2" x-show="detail.groom_name">
                        <dt class="text-gray-500 font-medium">Pengantin Pria</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.groom_name || '-'"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2" x-show="detail.bride_name">
                        <dt class="text-gray-500 font-medium">Pengantin Wanita</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.bride_name || '-'"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2" x-show="detail.witness_name">
                        <dt class="text-gray-500 font-medium">Saksi</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.witness_name || '-'"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2" x-show="detail.mahar">
                        <dt class="text-gray-500 font-medium">Mahar</dt>
                        <dd class="text-gray-900 font-semibold text-right" x-text="detail.mahar || '-'"></dd>
                    </div>
                    
                    <div class="flex items-start justify-between gap-4 border-b border-border/50 pb-2">
                        <dt class="text-gray-500 font-medium">Status</dt>
                        <dd class="text-right">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold" :class="statusClass(detail.status)" x-text="detail.status"></span>
                        </dd>
                    </div>
                </dl>
                
                <button @click="detail = null" class="mt-6 rounded-full w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-gray-800 font-semibold active:scale-[0.98] transition">
                    Tutup
                </button>
            </div>
        </div>

    </div>

</body>
</html>
