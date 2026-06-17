<header class="fixed top-0 inset-x-0 z-50 bg-[#5D001E]/90 backdrop-blur-md border-b border-[#C8A84B]/20">
    <nav class="mx-auto max-w-7xl px-6 lg:px-10 h-20 flex items-center justify-between">
        
        <!-- LOGO (Kiri) -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-[#C8A84B]/50 bg-[#5D001E] group-hover:scale-105 transition duration-300">
                <span class="font-serif font-bold italic text-[#C8A84B]">S</span>
            </div>
            <div class="leading-tight">
                <h1 class="text-xl font-bold tracking-widest text-[#FAF3E0]" style="font-family:'Cormorant Garamond', serif;">SILART</h1>
            </div>
        </a>

        <!-- MENU DESKTOP (Tengah) -->
        <div class="hidden lg:flex items-center gap-8">
            <a href="{{ url('/') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] font-medium text-sm transition">Beranda</a>
            <a href="{{ url('/katalog') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] font-medium text-sm transition">Katalog</a>
            <a href="{{ url('/galeri') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] font-medium text-sm transition">Galeri</a>
            <a href="{{ url('/tentang') }}" class="text-[#E8D7A3] hover:text-[#FAF3E0] font-medium text-sm transition">Tentang</a>
        </div>

        <!-- USER SECTION (Kanan) -->
        <div class="flex items-center gap-4">
            @auth
                
                <!-- Profil Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-center h-9 w-9 rounded-full bg-[#7B1C2E] border border-[#C8A84B]/40 text-[#FAF3E0] font-bold text-xs hover:bg-[#C8A84B] hover:text-[#4A0F1A] transition">
                        {{ strtoupper(substr(Auth::user()?->nama ?? Auth::user()?->name ?? 'U', 0, 1)) }}
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" 
                         x-transition class="absolute right-0 mt-3 w-56 bg-[#5D001E] rounded-xl shadow-2xl border border-[#C8A84B]/20 py-2">
                        <a href="{{ route('user.dashboard.index') }}" class="block px-4 py-2 text-xs font-medium text-[#FAF3E0] hover:bg-[#4A0F1A]">Dashboard</a>
                        <a href="{{ route('user.pemesanan.index') }}" class="block px-4 py-2 text-xs font-medium text-[#FAF3E0] hover:bg-[#4A0F1A]">Pemesanan</a>

                        <a href="{{ route('user.profile.index') }}" class="block px-4 py-2 text-xs font-medium text-[#FAF3E0] hover:bg-[#4A0F1A]">Profil</a>

                        <div class="my-1 border-t border-[#C8A84B]/20"></div>

                        <form method="POST" action="/logout" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-[#C8A84B] hover:bg-[#4A0F1A]">
                                Log out
                            </button>
                        </form>

                    </div>

                </div>
            @else
                <a href="/login" class="text-sm font-medium text-[#E8D7A3] hover:text-white transition">Masuk</a>
                <a href="/register" class="bg-[#C8A84B] text-[#4A0F1A] px-5 py-2 rounded-full text-sm font-semibold hover:bg-[#D6B35C] transition">Daftar</a>
            @endauth
        </div>
    </nav>
</header>   