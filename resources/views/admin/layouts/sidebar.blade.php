@php
    $menuClass = 'block rounded-xl px-4 py-3 text-sm font-medium transition hover:bg-white/10';
    $activeClass = 'bg-white text-[#5A0B1A] shadow-sm';
@endphp

{{-- Overlay Mobile --}}
<div
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    @click="sidebarOpen = false"
    x-cloak
></div>

{{-- Sidebar --}}
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed left-0 top-0 z-50 flex h-screen w-72 transform flex-col overflow-y-auto bg-[#5A0B1A] text-white transition-transform duration-300 lg:w-64 lg:translate-x-0"
>

    <div class="flex h-full flex-col px-4 py-4">

        {{-- Mobile Close --}}
        <div class="mb-3 flex justify-end lg:hidden">
            <button
                @click="sidebarOpen=false"
                class="rounded-lg p-2 hover:bg-white/10"
            >
                ✕
            </button>
        </div>

        {{-- Logo --}}
        <div class="mb-4 flex flex-col items-center">
            <img
                src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}"
                alt="Logo"
                class="h-20 w-20 rounded-full bg-white p-1 object-cover"
            >
        </div>

        {{-- Admin Card --}}
        <div class="mb-5 rounded-2xl bg-white/10 p-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white font-bold text-[#5A0B1A]">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="text-xs text-white/60">Login sebagai</p>
                    <p class="truncate text-sm font-semibold">
                        {{ Auth::user()->name ?? 'Admin Sanggar' }}
                    </p>
                    <p class="truncate text-xs text-white/60">
                        {{ Auth::user()->email ?? 'admin@rantiang.com' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? "$menuClass $activeClass" : $menuClass }}">
                Dashboard
            </a>

            <a href="#"
               class="{{ $menuClass }}">
                Pemesanan
            </a>

            <a href="#"
               class="{{ $menuClass }}">
                Pembayaran
            </a>

            <a href="{{ route('admin.jasa.index') }}"
               class="{{ request()->routeIs('admin.jasa.*') ? "$menuClass $activeClass" : $menuClass }}">
                Jasa
            </a>

            <a href="{{ route('admin.paket.index') }}"
               class="{{ request()->routeIs('admin.paket.*') ? "$menuClass $activeClass" : $menuClass }}">
                Paket
            </a>

            <a href="{{ route('admin.barang.index') }}"
               class="{{ request()->routeIs('admin.barang.*') ? "$menuClass $activeClass" : $menuClass }}">
                Barang
            </a>

            <a href="#" class="{{ $menuClass }}">
                Kategori Barang
            </a>

            <a href="#" class="{{ $menuClass }}">
                Kategori Paket
            </a>

            <a href="#" class="{{ $menuClass }}">
                Galeri
            </a>

            <a href="#" class="{{ $menuClass }}">
                Testimoni
            </a>

            <a href="#" class="{{ $menuClass }}">
                Laporan
            </a>

            <a href="#" class="{{ $menuClass }}">
                Zona Lokasi
            </a>
        </nav>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="pt-4">
            @csrf
            <button
                class="w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold hover:bg-red-700"
            >
                Logout
            </button>
        </form>
    </div>
</aside>
