<header class="fixed top-0 inset-x-0 z-50 backdrop-blur-md"
        style="background: linear-gradient(to right, #0d0206 0%, #3D0010 35%, #7B1C2E 100%); border-bottom: 1px solid rgba(200,168,75,0.18);">

    <nav class="mx-auto max-w-6xl px-6 lg:px-10 h-20 grid grid-cols-3 items-center">

        {{-- LOGO (Kiri) --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#C8960C]/50 bg-white/5 group-hover:bg-white/10 transition duration-300">
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
                <span class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/katalog') }}"
               class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Katalog
                <span class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/galeri') }}"
               class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Galeri
                <span class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ url('/tentang') }}"
               class="relative text-sm font-medium tracking-wide text-[#E8D7A3] transition duration-200 hover:text-[#FAF3E0] group">
                Tentang
                <span class="absolute -bottom-1 left-0 h-[1px] w-0 bg-[#C8960C] transition-all duration-300 group-hover:w-full"></span>
            </a>
        </div>

        {{-- USER SECTION (Kanan) --}}
        <div class="flex items-center justify-end gap-4">
            @auth
                <div class="relative">
                    <button id="userDropdownButton"
                        class="flex items-center justify-center h-9 w-9 rounded-full border border-[#C8960C]/40 bg-white/10 text-[#FAF3E0] font-bold text-xs hover:bg-[#C8960C] hover:text-[#4A0F1A] transition duration-200">
                        {{ strtoupper(substr(Auth::user()?->nama ?? Auth::user()?->name ?? 'U', 0, 1)) }}
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
                                <div x-show="confirmLogout" x-cloak
                                     x-transition:enter="transition ease-out duration-150"
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
                                            <p class="mt-1 text-sm text-[#4A2E28]/60">Kamu perlu login kembali untuk mengakses akun.</p>
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

    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('userDropdownButton');
    const menu = document.getElementById('userDropdownMenu');

    if (!button || !menu) return;

    button.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
        if (!menu.contains(e.target) && !button.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
});
</script>