<header x-data="{ mobileOpen: false }" class="fixed top-0 inset-x-0 z-50 backdrop-blur-md"
    style="background: linear-gradient(to right, #0d0206 0%, #3D0010 35%, #7B1C2E 100%); border-bottom: 1px solid rgba(200,168,75,0.18);">

    <nav class="mx-auto max-w-6xl px-6 lg:px-10 h-20 flex items-center justify-between lg:grid lg:grid-cols-3">

        {{-- LOGO (Kiri) --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div
                class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#C8960C]/50 bg-white/5 group-hover:bg-white/10 transition duration-300">
                <span class="font-serif text-lg font-bold italic text-[#C8960C]">S</span>
                <div class="absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300"
                    style="box-shadow: 0 0 12px rgba(200,168,75,0.4);"></div>
            </div>
            <h1 class="text-lg font-bold tracking-[0.2em] text-[#FAF3E0]"
                style="font-family:'Cormorant Garamond', serif;">SILART</h1>
        </a>

        {{-- MENU DESKTOP (Tengah — benar-benar center) --}}
        <div class="hidden lg:flex items-center justify-center gap-8">
            <a href="{{ url('/') }}"
                class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Beranda
                <span
                    class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/katalog') }}"
                class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Katalog
                <span
                    class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/galeri') }}"
                class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Galeri
                <span
                    class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/tentang') }}"
                class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Tentang
                <span
                    class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
        </div>

        {{-- USER SECTION (Kanan) --}}
        <div class="hidden lg:flex items-center justify-end gap-4">
            @auth
                <div class="relative">
                    <button id="userDropdownButton"
                        class="flex items-center justify-center h-9 w-9 rounded-full border border-[#C8960C]/40 bg-white/10 overflow-hidden hover:ring-2 hover:ring-[#C8960C] transition duration-200">
                        @if (Auth::user()?->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil"
                                class="h-full w-full object-cover">
                        @else
                            <span
                                class="text-[#FAF3E0] font-bold text-xs">{{ strtoupper(substr(Auth::user()?->nama ?? (Auth::user()?->name ?? 'U'), 0, 1)) }}</span>
                        @endif
                    </button>


                    <div id="userDropdownMenu"
                        class="hidden absolute right-0 mt-3 w-56 rounded-xl shadow-2xl border border-[#C8960C]/20 py-2 z-[9999]"
                        style="background: linear-gradient(to bottom, #3D0010, #1e050d);">

                        <a href="{{ route('user.dashboard.index') }}"
                            class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                            Dashboard
                        </a>
                        <a href="{{ route('user.pemesanan.index') }}"
                            class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                            Pemesanan
                        </a>
                        <a href="{{ route('user.profile.index') }}"
                            class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                            Profil
                        </a>

                        <div class="my-1 border-t border-[#C8960C]/15"></div>

                        <div x-data="{ confirmLogout: false }">
                            <button x-on:click="confirmLogout = true"
                                class="w-full text-left px-4 py-2.5 text-xs font-medium text-[#C8960C] hover:bg-white/5 transition">
                                Keluar
                            </button>

                            <template x-teleport="body">
                                <div x-show="confirmLogout" x-cloak x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
                                    x-on:click.self="confirmLogout = false">
                                    <div
                                        class="w-full max-w-xs rounded-2xl bg-white border border-[#E2D4C0] shadow-2xl p-6">
                                        <div class="flex flex-col items-center text-center">
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 border border-red-200 mb-4">
                                                <i data-lucide="log-out" class="h-5 w-5 text-red-500"></i>
                                            </div>
                                            <h3 class="font-serif text-lg font-light text-[#4A0F1A]">Yakin ingin keluar?
                                            </h3>
                                            <p class="mt-1 text-sm text-[#4A2E28]/60">Kamu perlu login kembali untuk
                                                mengakses akun.</p>
                                        </div>
                                        <div class="mt-5 flex gap-2">
                                            <button x-on:click="confirmLogout = false"
                                                class="flex-1 rounded-full border border-[#E2D4C0] bg-white py-2.5 text-sm font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                                                Batal
                                            </button>
                                            <form method="POST" action="/logout" class="flex-1">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full rounded-full bg-gradient-to-br from-red-600 to-red-800 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-red-700 hover:to-red-900 transition">
                                                    Ya, Keluar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                <a href="/login"
                    class="text-sm font-medium tracking-wide text-[#E8D7A3] hover:text-white transition duration-200">
                    Masuk
                </a>
                <a href="/register"
                    class="rounded-full border border-[#C8960C]/60 bg-[#C8960C]/15 px-5 py-2 text-sm font-semibold text-[#C8960C] hover:bg-[#C8960C] hover:text-[#4A0F1A] transition duration-200">
                    Daftar
                </a>
            @endauth
        </div>

        <!-- Hamburger Mobile -->
        <button @click="mobileOpen = !mobileOpen" class="lg:hidden rounded-lg p-2 text-[#FAF3E0] hover:bg-white/10 transition focus:outline-none">
            <i data-lucide="menu" x-show="!mobileOpen" class="h-6 w-6"></i>
            <i data-lucide="x" x-show="mobileOpen" class="h-6 w-6" x-cloak></i>
        </button>

    </nav>

    <!-- Mobile Menu Panel -->
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-cloak
         class="lg:hidden absolute top-full inset-x-0 border-t border-[#C8960C]/20 bg-[#2D000B]/95 backdrop-blur-lg px-6 py-6 shadow-2xl space-y-4">
        <div class="flex flex-col gap-3.5">
            <a href="{{ url('/') }}" class="text-sm font-medium tracking-wide text-[#FAF3E0] hover:text-[#C8960C] transition py-1.5 border-b border-white/5">
                Beranda
            </a>
            <a href="{{ url('/katalog') }}" class="text-sm font-medium tracking-wide text-[#FAF3E0] hover:text-[#C8960C] transition py-1.5 border-b border-white/5">
                Katalog
            </a>
            <a href="{{ url('/galeri') }}" class="text-sm font-medium tracking-wide text-[#FAF3E0] hover:text-[#C8960C] transition py-1.5 border-b border-white/5">
                Galeri
            </a>
            <a href="{{ url('/tentang') }}" class="text-sm font-medium tracking-wide text-[#FAF3E0] hover:text-[#C8960C] transition py-1.5 border-b border-white/5">
                Tentang
            </a>
        </div>

        <div class="pt-2">
            @auth
                <div class="flex items-center gap-3 mb-4 px-2 py-1.5 bg-white/5 rounded-xl border border-white/5 font-sans">
                    <div class="h-9 w-9 shrink-0 rounded-full border border-[#C8960C]/40 overflow-hidden bg-white/10 flex items-center justify-center">
                        @if (Auth::user()?->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" class="h-full w-full object-cover">
                        @else
                            <span class="text-[#FAF3E0] font-bold text-xs">{{ strtoupper(substr(Auth::user()?->nama ?? (Auth::user()?->name ?? 'U'), 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] uppercase tracking-wider text-[#C8960C]/80">Masuk sebagai</p>
                        <p class="text-sm font-semibold text-[#FAF3E0] truncate">{{ Auth::user()?->nama ?? (Auth::user()?->name ?? 'User') }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 font-sans">
                    <a href="{{ route('user.dashboard.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                        <i data-lucide="layout-dashboard" class="h-4 w-4 shrink-0 text-[#C8960C]"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('user.pemesanan.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                        <i data-lucide="clipboard-list" class="h-4 w-4 shrink-0 text-[#C8960C]"></i>
                        Pemesanan
                    </a>
                    <a href="{{ route('user.profile.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                        <i data-lucide="user" class="h-4 w-4 shrink-0 text-[#C8960C]"></i>
                        Profil
                    </a>
                    <div x-data="{ confirmLogout: false }" class="mt-2 pt-2 border-t border-white/5">
                        <button @click="confirmLogout = true" class="w-full flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#C8960C] hover:bg-white/5 transition">
                            <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                            Keluar
                        </button>
                        <template x-teleport="body">
                            <div x-show="confirmLogout" x-cloak x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
                                x-on:click.self="confirmLogout = false">
                                <div class="w-full max-w-xs rounded-2xl bg-white border border-[#E2D4C0] shadow-2xl p-6">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 border border-red-200 mb-4">
                                            <i data-lucide="log-out" class="h-5 w-5 text-red-500"></i>
                                        </div>
                                        <h3 class="font-serif text-lg font-light text-[#4A0F1A]">Yakin ingin keluar?</h3>
                                        <p class="mt-1 text-sm text-[#4A2E28]/60 font-sans">Kamu perlu login kembali untuk mengakses akun.</p>
                                    </div>
                                    <div class="mt-5 flex gap-2 font-sans">
                                        <button x-on:click="confirmLogout = false" class="flex-1 rounded-full border border-[#E2D4C0] bg-white py-2.5 text-sm font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                                            Batal
                                        </button>
                                        <form method="POST" action="/logout" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full rounded-full bg-gradient-to-br from-red-600 to-red-800 py-2.5 text-sm font-semibold text-white shadow-sm hover:from-red-700 hover:to-red-900 transition">
                                                Ya, Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 pt-2">
                    <a href="/login" class="flex-1 text-center py-2.5 rounded-xl text-sm font-medium text-[#E8D7A3] hover:text-white border border-[#C8960C]/30 hover:bg-white/5 transition duration-200">
                        Masuk
                    </a>
                    <a href="/register" class="flex-1 text-center py-2.5 rounded-xl bg-[#C8960C] text-sm font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition duration-200">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>

    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('userDropdownButton');
        const menu = document.getElementById('userDropdownMenu');

        if (!button || !menu) return;

        button.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !button.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
</script>
