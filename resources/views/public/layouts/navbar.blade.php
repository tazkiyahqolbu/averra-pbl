<header class="fixed top-0 inset-x-0 z-50 backdrop-blur-md"
    style="background: linear-gradient(to right, #0d0206 0%, #3D0010 35%, #7B1C2E 100%); border-bottom: 1px solid rgba(200,168,75,0.18);">

    <nav class="mx-auto max-w-6xl px-6 lg:px-10 h-20 flex items-center justify-between lg:grid lg:grid-cols-3">

        {{-- LOGO (Kiri) --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="relative shrink-0">
                <img 
                    src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" 
                    alt="Logo Rantiang Tagok" 
                    class="h-10 w-10 rounded-full object-cover border border-[#C8960C]/50">
                <div class="absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300"
                    style="box-shadow: 0 0 12px rgba(200,168,75,0.4);"></div>
            </div>
            
            <h1 class="text-base font-bold tracking-[0.1em] text-[#FAF3E0] leading-tight"
                style="font-family:'Cormorant Garamond', serif;">Sanggar Rantiang Tagok</h1>
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
            <a href="{{ route('public.galeri.index') }}"
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
        <div class="flex items-center justify-end gap-2 lg:gap-4">
            {{-- Hamburger (mobile only) --}}
            <button id="mobileMenuButton" class="flex lg:hidden h-9 w-9 items-center justify-center rounded-lg text-[#E8D7A3] hover:bg-white/10 transition">
                <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
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

                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.pemesanan.index') }}"
                                class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                                Pemesanan
                            </a>
                            <a href="{{ route('admin.akun.index') }}"
                                class="block px-4 py-2.5 text-xs font-medium text-[#FAF3E0] hover:bg-white/5 hover:text-[#C8960C] transition">
                                Profil
                            </a>
                        @else
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
                        @endif

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
                                        class="w-full max-w-xs rounded-2xl bg-white card-fade-border shadow-2xl p-6">
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
                                                class="flex-1 rounded-full card-fade-border bg-white py-2.5 text-sm font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
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
                    class="hidden lg:block text-sm font-medium tracking-wide text-[#E8D7A3] hover:text-white transition duration-200">
                    Masuk
                </a>
                <a href="/register"
                    class="hidden lg:inline-flex rounded-full border border-[#C8960C]/60 bg-[#C8960C]/15 px-5 py-2 text-sm font-semibold text-[#C8960C] hover:bg-[#C8960C] hover:text-[#4A0F1A] transition duration-200">
                    Daftar
                </a>
            @endauth
        </div>

    </nav>

    {{-- Mobile Menu Panel --}}
    <div id="mobileMenu" class="hidden lg:hidden border-t border-[#C8960C]/20"
         style="background: linear-gradient(to bottom, #3D0010, #1e050d);">
        <div class="px-6 py-4 space-y-1">
            <a href="{{ url('/') }}" class="block py-2.5 text-sm font-medium text-[#E8D7A3] hover:text-white transition">Beranda</a>
            <a href="{{ url('/katalog') }}" class="block py-2.5 text-sm font-medium text-[#E8D7A3] hover:text-white transition">Katalog</a>
            <a href="{{ route('public.galeri.index') }}" class="block py-2.5 text-sm font-medium text-[#E8D7A3] hover:text-white transition">Galeri</a>
            <a href="{{ url('/tentang') }}" class="block py-2.5 text-sm font-medium text-[#E8D7A3] hover:text-white transition">Tentang</a>
            @guest
            <div class="pt-3 border-t border-[#C8960C]/20 flex gap-3">
                <a href="/login" class="flex-1 text-center py-2 text-sm font-medium text-[#E8D7A3] border border-[#C8960C]/40 rounded-full hover:bg-white/10 transition">Masuk</a>
                <a href="/register" class="flex-1 text-center py-2 text-sm font-semibold text-[#C8960C] border border-[#C8960C]/60 bg-[#C8960C]/15 rounded-full hover:bg-[#C8960C] hover:text-[#4A0F1A] transition">Daftar</a>
            </div>
            @endguest
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userBtn = document.getElementById('userDropdownButton');
        const userMenu = document.getElementById('userDropdownMenu');
        const mobileBtn = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const hamburgerIcon = document.getElementById('hamburgerIcon');
        const closeIcon = document.getElementById('closeIcon');

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', function() {
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                hamburgerIcon.classList.toggle('hidden', !isOpen);
                closeIcon.classList.toggle('hidden', isOpen);
            });
        }
    });
</script>
