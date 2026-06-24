@php
    $routeUrl = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $active = fn ($name) => request()->routeIs($name)
        ? 'bg-[#C8960C]/20 text-[#C8960C] border border-[#C8960C]/25'
        : 'text-white/55 hover:text-white hover:bg-white/6';

    $nav = [
        ['label' => 'Dashboard',   'route' => 'admin.dashboard',      'icon' => 'layout-dashboard'],
    ];
    $transaksi = [
        ['label' => 'Pemesanan',   'route' => 'admin.pemesanan.index', 'icon' => 'clipboard-list',   'badge_key' => 'pemesanan'],
        ['label' => 'Pembayaran',  'route' => 'admin.pembayaran.index','icon' => 'credit-card',       'badge_key' => 'pembayaran'],
        ['label' => 'Pengembalian','route' => 'admin.pengembalian.index','icon' => 'package',         'badge_key' => 'pengembalian'],
    ];
    $katalog = [
        ['label' => 'Jasa',             'route' => 'admin.jasa.index',           'icon' => 'sparkles'],
        ['label' => 'Paket',            'route' => 'admin.paket.index',          'icon' => 'gift'],
        ['label' => 'Barang',           'route' => 'admin.barang.index',         'icon' => 'tag'],
        ['label' => 'Kategori Jasa',    'route' => 'admin.kategori-jasa.index',  'icon' => 'folder'],
        ['label' => 'Kategori Paket',   'route' => 'admin.kategori-paket.index', 'icon' => 'folder'],
        ['label' => 'Kategori Barang',  'route' => 'admin.kategori-barang.index','icon' => 'folder'],
    ];
    $konten = [
        ['label' => 'Galeri',    'route' => 'admin.galeri.index',    'icon' => 'image'],
        ['label' => 'Testimoni', 'route' => 'admin.testimoni.index', 'icon' => 'star'],
    ];
    $laporan = [
        ['label' => 'Laporan & Statistik', 'route' => 'admin.laporan.index', 'icon' => 'bar-chart-2'],
    ];
    $pengaturan = [
        ['label' => 'Zona Lokasi',    'route' => 'admin.zona-lokasi.index',   'icon' => 'map-pin'],
        ['label' => 'Blokir Tanggal', 'route' => 'admin.blokir-tanggal.index','icon' => 'calendar-x'],
        ['label' => 'Profil Admin',   'route' => 'admin.akun.index',          'icon' => 'user'],
    ];

    $badges = [
        'pemesanan'    => \App\Models\Pemesanan::where('status', 'menunggu')->count(),
        'pembayaran'   => \App\Models\Pembayaran::where('status', 'menunggu')->count(),
        'pengembalian' => 0,
    ];
@endphp

<aside class="fixed left-0 top-0 z-40 hidden h-screen w-64 lg:flex flex-col"
       style="background: linear-gradient(to bottom, #5C1520 0%, #4A0F1A 50%, #3A0A12 100%);">

    {{-- Logo --}}
    <div class="shrink-0 border-b border-white/10 px-5 py-5">
        <a href="{{ $routeUrl('admin.dashboard') }}" class="flex items-center gap-2.5 group">
            <div class="flex h-9 w-9 items-center justify-center rounded-full border border-[#C8960C]/50 bg-white/5 group-hover:bg-white/10 transition">
                <span class="font-serif text-base font-bold italic text-[#C8960C]">S</span>
            </div>
            <div>
                <span class="font-serif text-base font-bold tracking-[0.2em] text-[#FAF3E0]">SILART</span>
                <p class="text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/70 leading-none mt-0.5">Admin Panel</p>
            </div>
        </a>
    </div>

    {{-- Admin info --}}
    <div class="shrink-0 border-b border-white/10 px-5 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C8960C]/40 bg-[#C8960C]/15 text-sm font-bold text-[#C8960C]">
                {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-[9px] uppercase tracking-widest text-[#C8960C]/60">Admin</p>
                <p class="text-sm font-semibold text-[#FAF3E0] truncate">
                    {{ Auth::user()->nama ?? Auth::user()->name ?? 'Admin' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5 hide-scrollbar">

        @foreach ($nav as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach

        <p class="px-3 pb-1 pt-4 text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/50">Transaksi</p>
        @foreach ($transaksi as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <span class="flex items-center gap-3">
                    <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                    {{ $n['label'] }}
                </span>
                @if(($badges[$n['badge_key']] ?? 0) > 0)
                    <span class="rounded-full bg-[#C8960C] px-2 py-0.5 text-[10px] font-bold text-[#3A0A12]">
                        {{ $badges[$n['badge_key']] }}
                    </span>
                @endif
            </a>
        @endforeach

        <p class="px-3 pb-1 pt-4 text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/50">Katalog</p>
        @foreach ($katalog as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach

        <p class="px-3 pb-1 pt-4 text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/50">Konten</p>
        @foreach ($konten as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach

        <p class="px-3 pb-1 pt-4 text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/50">Laporan</p>
        @foreach ($laporan as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach

        <p class="px-3 pb-1 pt-4 text-[9px] font-semibold uppercase tracking-[0.25em] text-[#C8960C]/50">Pengaturan</p>
        @foreach ($pengaturan as $n)
            <a href="{{ $routeUrl($n['route']) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition duration-200 {{ $active($n['route']) }}">
                <i data-lucide="{{ $n['icon'] }}" class="h-4 w-4 shrink-0"></i>
                {{ $n['label'] }}
            </a>
        @endforeach

    </nav>

    {{-- Logout --}}
    <div class="shrink-0 border-t border-white/10 px-3 pb-5 pt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-white/45 hover:text-red-400 hover:bg-white/6 transition duration-200">
                <i data-lucide="log-out" class="h-4 w-4 shrink-0"></i>
                Keluar
            </button>
        </form>
    </div>

</aside>
