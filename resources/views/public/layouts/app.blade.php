<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SILART')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: '#7B1C2E',
                        'maroon-deep': '#4A0F1A',
                        gold: '#C8A84B',
                        cream: '#FAF3E0',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="bg-[#4A0F1A] text-[#FAF3E0]">

    <!-- Navbar -->
    <header
        x-data="{ open: false }"
        class="fixed top-0 inset-x-0 z-50 bg-transparent">

        <nav class="mx-auto max-w-7xl px-6 lg:px-10 h-24 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">

                <div class="flex h-12 w-12 items-center justify-center rounded-full border border-[#C8A84B]/50 bg-transparent transition duration-300 group-hover:scale-105">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-[#C8A84B]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3l1.912 5.813H20l-4.956 3.6L16.912 18 12 14.4 7.088 18l1.868-5.587L4 8.813h6.088L12 3z"/>
                    </svg>
                </div>

                <div class="leading-tight">
                    <h1
                        class="text-xl font-semibold tracking-[0.25em] text-[#FAF3E0]"
                        style="font-family:'Cormorant Garamond', serif;">
                        SILART
                    </h1>

                    <p class="text-[11px] tracking-[0.35em] text-[#C8A84B] uppercase">
                        Rantiang Tagok
                    </p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-8">

                <a href="{{ url('/') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Beranda
                </a>

                <a href="{{ url('/layanan') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Layanan
                </a>

                <a href="{{ url('/katalog') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Katalog
                </a>

                <a href="{{ url('/galeri') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Galeri
                </a>

                <a href="{{ url('/booking') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Pemesanan
                </a>

                <a href="{{ url('/testimoni') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] transition duration-300 text-sm tracking-wide">
                    Testimoni
                </a>
            </div>

            <!-- Desktop Auth -->
            <div class="hidden lg:flex items-center gap-3">

                @guest
                    <a href="/login"
                        class="rounded-full border border-[#C8A84B]/60 bg-transparent px-6 py-2.5 text-[#E8D7A3] hover:bg-[#C8A84B]/15 hover:text-[#FAF3E0] transition duration-300">
                        Masuk
                    </a>

                    <a href="/register"
                        class="rounded-full bg-[#C8A84B] hover:bg-[#D6B35C] text-[#4A0F1A] font-semibold px-6 py-2.5 shadow-md transition duration-300">
                        Daftar
                    </a>
                @endguest

                @auth
                    <a href="/dashboard"
                        class="rounded-full border border-[#C8A84B]/40 bg-[#7B1C2E]/50 px-5 py-2.5 text-[#FAF3E0] hover:bg-[#7B1C2E]/70 transition">

                        {{ explode(' ', Auth::user()->name)[0] }}
                    </a>

                    <form method="POST" action="/logout">
                        @csrf

                        <button type="submit"
                            class="rounded-full border border-[#C8A84B]/60 px-5 py-2.5 text-[#E8D7A3] hover:bg-[#C8A84B] hover:text-[#4A0F1A] transition">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

            <!-- Mobile Button -->
            <button
                @click="open = !open"
                class="lg:hidden flex h-11 w-11 items-center justify-center rounded-full border border-[#C8A84B]/40 bg-transparent transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-[#FAF3E0]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        x-show="!open"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />

                    <path
                        x-show="open"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>
    </header>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak" class="bg-maroon-deep pt-14 pb-6 text-cream border-t border-maroon/30">
        <div class="mx-auto max-w-7xl px-6">

            <div class="grid gap-8 md:grid-cols-3">

                <div>
                    <div class="text-2xl tracking-[0.25em] text-gold font-serif">
                        SILART
                    </div>

                    <p class="mt-2 text-sm text-cream/70">
                        Sanggar Rantiang Tagok
                    </p>

                    <p class="mt-6 max-w-xs text-sm leading-relaxed text-cream/70 font-light">
                        Menjaga warisan, merangkai perayaan.
                        Setiap acara adalah cerita yang patut dikenang.
                    </p>
                </div>

                <div>
                    <h4 class="text-xs tracking-[0.3em] text-gold font-bold uppercase">
                        — KONTAK —
                    </h4>

                    <ul class="mt-6 space-y-4 text-sm text-cream/80 font-light">
                        <li class="flex items-center gap-3">
                            <i data-lucide="phone" class="h-4 w-4 text-gold"></i>
                            +62 82261177926
                        </li>

                        <li class="flex items-center gap-3">
                            <i data-lucide="instagram" class="h-4 w-4 text-gold"></i>
                            @sanggar_rantiangtagok
                        </li>

                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="mt-1 h-4 w-4 text-gold"></i>
                            Jl. Bagindo Aziz Chan, Padang, Sumatera Barat
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs tracking-[0.3em] text-gold font-bold uppercase">
                        — TERHUBUNG —
                    </h4>

                    <p class="mt-6 text-sm text-cream/70 font-light">
                        Sapa kami via WhatsApp untuk konsultasi acara
                        dan reservasi awal.
                    </p>

                    <a href="https://wa.me/6282261177926"
                        target="_blank"
                        rel="noreferrer"
                        class="mt-5 inline-flex items-center gap-2 rounded-full border border-gold px-5 py-2.5 text-sm text-gold transition duration-300 hover:bg-gold hover:text-maroon-deep font-medium">

                        <i data-lucide="phone" class="h-4 w-4"></i>
                        Hubungi WhatsApp
                    </a>
                </div>
            </div>

            <div class="h-[1px] bg-gold/20 my-6 w-full"></div>

            <p class="text-center text-xs text-cream/50 font-light">
                © {{ date('Y') }} SILART · Sanggar Rantiang Tagok.
                Adat Basandi Syarak, Syarak Basandi Kitabullah.
            </p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>
</html>