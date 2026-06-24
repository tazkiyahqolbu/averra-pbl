@php
    $authUser = auth()->user();
    $navItems = [
        ['label' => 'Dashboard',  'route' => 'user.dashboard.index', 'icon' => 'layout-dashboard'],
        ['label' => 'Pemesanan',  'route' => 'user.pemesanan.index',  'icon' => 'clipboard-list'],
        ['label' => 'Profil',     'route' => 'user.profile.index',   'icon' => 'user'],
    ];
@endphp

<aside class="w-56 flex-shrink-0 flex flex-col min-h-screen sticky top-0 h-screen overflow-y-auto"
       style="background: linear-gradient(to bottom, #5C1520 0%, #4A0F1A 50%, #3A0A12 100%);">

    {{-- Logo --}}
    <div class="px-5 py-6 border-b border-white/10">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="flex h-9 w-9 items-center justify-center rounded-full border border-[#C8960C]/50 bg-white/5 group-hover:bg-white/10 transition duration-200">
                <span class="font-serif text-base font-bold italic text-[#C8960C]">S</span>
            </div>
            <span class="font-serif text-base font-bold tracking-[0.2em] text-[#FAF3E0]">SILART</span>
        </a>
    </div>

    {{-- User info --}}
    <div class="px-5 py-4 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C8960C]/40 bg-[#C8960C]/15 text-sm font-bold text-[#C8960C]">
                {{ strtoupper(substr($authUser->nama ?? $authUser->name ?? 'U', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-[9px] uppercase tracking-widest text-[#C8960C]/60">Akun Saya</p>
                <p class="text-sm font-semibold text-[#FAF3E0] truncate">
                    {{ $authUser->nama ?? $authUser->name ?? 'Tamu' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">
        @foreach ($navItems as $n)
            @php $active = request()->routeIs($n['route']); @endphp
            <a href="{{ route($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200
                      {{ $active
                          ? 'bg-[#C8960C]/20 text-[#C8960C] border border-[#C8960C]/25'
                          : 'text-white/55 hover:text-white hover:bg-white/6' }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Bottom links --}}
    <div class="px-3 pb-5 pt-3 border-t border-white/10 space-y-0.5">
        <a href="{{ url('/katalog') }}"
           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/45 hover:text-white hover:bg-white/6 transition duration-200">
            <i data-lucide="shopping-bag" class="h-4 w-4 shrink-0"></i>
            Katalog
        </a>
        <a href="{{ url('/') }}"
           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/45 hover:text-white hover:bg-white/6 transition duration-200">
            <i data-lucide="home" class="h-4 w-4 shrink-0"></i>
            Beranda
        </a>
        <div x-data="{ confirmLogout: false }">
            <button x-on:click="confirmLogout = true"
                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/45 hover:text-red-400 hover:bg-white/6 transition duration-200">
                <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                Keluar
            </button>

            <div x-show="confirmLogout" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
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
        </div>
    </div>

</aside>
