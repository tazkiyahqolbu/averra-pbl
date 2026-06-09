<aside class="hidden w-72 shrink-0 border-r border-[#decba5] bg-[#4A0F1A] text-white lg:flex lg:min-h-screen lg:flex-col">
    <div class="p-6">
        <h1 class="font-heading text-2xl font-bold">SILART</h1>
        <p class="mt-1 text-sm text-white/70">Admin Panel</p>
    </div>

    @php
        $menuItems = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'active' => 'admin.dashboard',
                'fallback' => url('/admin/dashboard'),
            ],
            [
                'label' => 'Pemesanan',
                'route' => 'admin.pemesanan.index',
                'active' => 'admin.pemesanan.*',
                'fallback' => '#',
            ],
            [
                'label' => 'Pembayaran',
                'route' => 'admin.pembayaran.index',
                'active' => 'admin.pembayaran.*',
                'fallback' => '#',
            ],
            [
                'label' => 'Paket',
                'route' => 'admin.paket.index',
                'active' => 'admin.paket.*',
                'fallback' => '#',
            ],
            [
                'label' => 'Jasa',
                'route' => 'admin.jasa.index',
                'active' => 'admin.jasa.*',
                'fallback' => url('/preview/admin/jasa'),
            ],
            [
                'label' => 'Barang',
                'route' => 'admin.barang.index',
                'active' => 'admin.barang.*',
                'fallback' => '#',
            ],
            [
                'label' => 'Testimoni',
                'route' => 'admin.testimoni.index',
                'active' => 'admin.testimoni.*',
                'fallback' => '#',
            ],
            [
                'label' => 'Laporan',
                'route' => 'admin.laporan.index',
                'active' => 'admin.laporan.*',
                'fallback' => '#',
            ],
        ];
    @endphp

    <nav class="flex-1 space-y-1 px-4 pb-6 text-sm font-medium">
        @foreach ($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['active']);
                $href = \Illuminate\Support\Facades\Route::has($item['route'])
                    ? route($item['route'])
                    : $item['fallback'];
            @endphp

            <a href="{{ $href }}"
               class="block rounded-2xl px-4 py-3 transition {{ $isActive ? 'bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="border-t border-white/10 p-4">
        <div class="mb-3 rounded-2xl bg-white/10 px-4 py-3">
            <p class="text-sm font-semibold text-white">{{ auth()->user()->nama ?? 'Admin' }}</p>
            <p class="truncate text-xs text-white/60">{{ auth()->user()->email ?? '-' }}</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center justify-center rounded-2xl border border-white/15 px-4 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10 hover:text-white">
                Logout
            </button>
        </form>
    </div>
</aside>
