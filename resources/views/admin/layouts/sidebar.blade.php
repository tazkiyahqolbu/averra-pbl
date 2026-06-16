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

        <nav class="mt-2 flex-1 overflow-y-auto hide-scrollbar text-sm">
            <a href="{{ $routeUrl('admin.dashboard') }}" class="{{ $menuClass }}">
                <span>📊 Dashboard</span>
            </a>

            <p class="{{ $sectionClass }}">Transaksi</p>
            <a href="{{ $routeUrl('admin.pemesanan.index') }}" class="{{ $menuClass }}">
                <span>📋 Pemesanan</span>
                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-[#5A0B1A]">{{ $badges['pemesanan'] }}</span>
            </a>
            <a href="{{ $routeUrl('admin.pembayaran.index') }}" class="{{ $menuClass }}">
                <span>💳 Pembayaran</span>
                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-[#5A0B1A]">{{ $badges['pembayaran'] }}</span>
            </a>
            <a href="{{ $routeUrl('admin.pengembalian.index') }}" class="{{ $menuClass }}">
                <span>📦 Pengembalian</span>
                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-xs font-bold text-[#5A0B1A]">{{ $badges['pengembalian'] }}</span>
            </a>

            <p class="{{ $sectionClass }}">Katalog</p>
            <a href="{{ $routeUrl('admin.jasa.index') }}" class="{{ $menuClass }}"><span>🛎️ Jasa</span></a>
            <a href="{{ $routeUrl('admin.paket.index') }}" class="{{ $menuClass }}"><span>📦 Paket</span></a>
            <a href="{{ $routeUrl('admin.barang.index') }}" class="{{ $menuClass }}"><span>🏷️ Barang</span></a>
            <a href="{{ $routeUrl('admin.kategori-jasa.index') }}" class="{{ $menuClass }}"><span>🗂️ Kategori Jasa</span></a>
            <a href="{{ $routeUrl('admin.kategori-paket.index') }}" class="{{ $menuClass }}"><span>🗂️ Kategori Paket</span></a>
            <a href="{{ $routeUrl('admin.kategori-barang.index') }}" class="{{ $menuClass }}"><span>🗂️ Kategori Barang</span></a>

            <p class="{{ $sectionClass }}">Konten</p>
            <a href="{{ $routeUrl('admin.galeri.index') }}" class="{{ $menuClass }}"><span>🖼️ Galeri</span></a>
            <a href="{{ $routeUrl('admin.testimoni.index') }}" class="{{ $menuClass }}"><span>⭐ Testimoni</span></a>

            <p class="{{ $sectionClass }}">Laporan</p>
            <a href="{{ $routeUrl('admin.laporan.index') }}" class="{{ $menuClass }}"><span>📈 Laporan & Statistik</span></a>

            <p class="{{ $sectionClass }}">Pengaturan</p>
            <a href="{{ $routeUrl('admin.zona-lokasi.index') }}" class="{{ $menuClass }}"><span>📍 Zona Lokasi</span></a>
            <a href="{{ $routeUrl('admin.blokir-tanggal.index') }}" class="{{ $menuClass }}"><span>🚫 Blokir Tanggal</span></a>
            <a href="{{ $routeUrl('admin.akun.index') }}" class="{{ $menuClass }}"><span>👤 Profil Admin</span></a>
        </nav>

        <div class="mt-3 shrink-0 border-t border-white/10 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg px-4 py-2 text-left text-sm font-semibold hover:bg-white/10">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
