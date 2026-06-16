<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 bg-[#5A0B1A] text-white lg:block">
    @php
        $routeUrl = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

        $badges = [
            'pemesanan' => 3,
            'pembayaran' => 2,
            'pengembalian' => 1,
        ];

        $menuClass = 'flex items-center justify-between rounded-lg px-4 py-2 transition hover:bg-white/10';
        $sectionClass = 'px-4 pb-1 pt-4 text-[11px] font-semibold uppercase tracking-wider text-white/40';
    @endphp

    <div class="flex h-full flex-col px-4 py-4">

        <div class="shrink-0">
            <div class="mb-3 flex flex-col items-center">
                <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}"
                     alt="Logo Rantiang Tagok"
                     class="h-20 w-20 rounded-full bg-white object-cover p-1">
            </div>

            <div class="mb-3 rounded-xl bg-white/10 p-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white font-bold text-[#5A0B1A]">
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
        </div>

        {{-- Menu Sidebar --}}
<nav class="flex-1 space-y-1 text-sm">
    <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Dashboard
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Pemesanan
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Pembayaran
    </a>

    <a href="{{ route('admin.jasa.index') }}" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Jasa
    </a>

    <a href="{{ route('admin.paket.index')}}" class="block rounded-lg px-4 py-2 hover:bg-white/10">
    Paket
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Barang
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Kategori Barang
    </a>

    <a href="{{ route('admin.kategori-paket.index')}}" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Kategori Paket
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Galeri
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Testimoni
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Pengembalian
    </a>

    <a href="#" class="block rounded-lg px-4 py-2 hover:bg-white/10">
        Laporan
    </a>
</nav>

        {{-- Logout --}}
        <div class="mt-3 border-t border-white/10 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg px-4 py-2 text-left text-sm font-semibold hover:bg-white/10">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
