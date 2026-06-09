<aside class="hidden w-72 shrink-0 border-r border-[#decba5] bg-[#4A0F1A] text-white lg:block">
    <div class="p-6">
        <h1 class="font-['Playfair_Display'] text-2xl font-bold">SILART</h1>
        <p class="mt-1 text-sm text-white/70">Admin Panel</p>
    </div>

    <nav class="space-y-1 px-4 pb-6 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
        <a href="{{ route('admin.pemesanan.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.pemesanan.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Pemesanan</a>
        <a href="{{ route('admin.pembayaran.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Pembayaran</a>
        <a href="{{ route('admin.paket.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.paket.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Paket</a>
        <a href="{{ route('admin.jasa.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.jasa.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Jasa</a>
        <a href="{{ route('admin.barang.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.barang.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Barang</a>
        <a href="{{ route('admin.testimoni.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.testimoni.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Testimoni</a>
        <a href="{{ route('admin.laporan.index') }}" class="block rounded-2xl px-4 py-3 {{ request()->routeIs('admin.laporan.*') ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">Laporan</a>
    </nav>
</aside>
