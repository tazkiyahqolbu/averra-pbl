@php
    $authUser = auth()->user();
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'user.dashboard.index', 'icon' => 'layout-dashboard'],
        ['label' => 'Pemesanan', 'route' => 'user.pemesanan.index', 'icon' => 'clipboard-list'],
        ['label' => 'Profil', 'route' => 'user.profile.index', 'icon' => 'user'],
    ];
@endphp

{{-- Spacer desktop --}}
<div class="hidden lg:block w-56 flex-shrink-0"></div>

{{-- Mobile Overlay --}}
<div x-show="sidebarOpen" x-cloak
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>

<aside class="w-56 flex flex-col h-screen fixed top-0 left-0 overflow-y-auto z-40 transition-transform duration-300 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    style="background: linear-gradient(to bottom, #5C1520 0%, #4A0F1A 50%, #3A0A12 100%);">

    {{-- Logo --}}
        <div class="px-5 py-6 border-b border-white/10 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group min-w-0">
            
            <img 
                src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" 
                alt="Logo Rantiang Tagok" 
                class="h-9 w-9 rounded-full object-cover shrink-0 border border-[#C8960C]/50">

            <div class="min-w-0">
                <span class="block font-serif text-sm font-bold leading-tight text-[#FAF3E0] truncate">Sanggar Rantiang</span>
                <span class="block font-serif text-sm font-bold leading-tight text-[#FAF3E0] truncate">Tagok</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = false" class="lg:hidden flex h-8 w-8 items-center justify-center rounded-lg text-white/50 hover:bg-white/10 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- User info --}}
    <div class="px-5 py-4 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div
                class="h-9 w-9 shrink-0 rounded-full border border-[#C8960C]/40 overflow-hidden bg-[#C8960C]/15 flex items-center justify-center">
                @if ($authUser->foto_profil)
                    <img src="{{ asset('storage/' . $authUser->foto_profil) }}" alt="Foto Profil"
                        class="h-full w-full object-cover">
                @else
                    <span
                        class="text-sm font-bold text-[#C8960C]">{{ strtoupper(substr($authUser->nama ?? ($authUser->name ?? 'U'), 0, 1)) }}</span>
                @endif
            </div>

            <div class="overflow-hidden">
                <p class="text-[9px] uppercase tracking-widest text-[#C8960C]/60">Akun Saya</p>
                <p class="text-sm font-semibold text-[#FAF3E0] truncate">
                    {{ $authUser->nama ?? ($authUser->name ?? 'Tamu') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">
        @foreach ($navItems as $n)
            @php $active = request()->routeIs($n['route']); @endphp
            <a href="{{ route($n['route']) }}"
                @click="sidebarOpen = false"
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

            <template x-teleport="body">
            <div x-show="confirmLogout" x-cloak x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4"
                x-on:click.self="confirmLogout = false">
                <div class="w-full max-w-xs rounded-2xl bg-white border border-[#E2D4C0] shadow-2xl p-6">
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 border border-red-200 mb-4">
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

</aside>
