<!-- resources/views/user/layouts/sidebar.blade.php -->

<aside class="w-64 bg-[#5D001E] text-white min-h-screen flex flex-col p-5">

    {{-- Profile User --}}
    <div class="flex flex-col items-center mb-8 pt-4">

        {{-- Avatar / Foto Profile --}}
        <div class="h-16 w-16 rounded-full overflow-hidden shadow-md border-2 border-[#D4AF37] mb-3 bg-[#FAF3E0]">

            @if(auth()->user()->profile_photo)
                <img
                    src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                    alt="Foto Profil"
                    class="h-full w-full object-cover">
            @else
                <div class="h-full w-full flex items-center justify-center text-[#5D001E] text-2xl font-extrabold">

                    {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->name ?? 'U', 0, 1)) }}

                </div>
            @endif

        </div>

        {{-- Nama User --}}
        <h4 class="font-bold text-sm text-white text-center px-2">
            {{ auth()->user()->nama ?? auth()->user()->name ?? 'Pengguna' }}
        </h4>

        {{-- Email User --}}
        <p class="text-[11px] text-gray-300 text-center mt-1 break-all">
            {{ auth()->user()->email }}
        </p>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-1">

        {{-- AKUN --}}
        <p class="text-[10px] uppercase text-[#D4AF37] font-bold px-4 mb-2 mt-4 tracking-wider">
            Akun
        </p>

        {{-- Profil Saya --}}
        <a href="{{ route('user.profile.index') }}"
           class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm transition
           {{ request()->routeIs('user.profile.*')
               ? 'bg-[#4A0F1A] text-white shadow-sm'
               : 'hover:bg-[#4A0F1A]' }}">

            <i data-lucide="user" class="w-4 h-4"></i>

            <span class="font-medium">
                Profil Saya
            </span>
        </a>

        {{-- TRANSAKSI --}}
        <p class="text-[10px] uppercase text-[#D4AF37] font-bold px-4 mb-2 mt-5 tracking-wider">
            Transaksi
        </p>

        {{-- Pemesanan --}}
        <a href="{{ route('user.pemesanan.index') }}"
           class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm transition
           {{ request()->routeIs('user.pemesanan.*')
               ? 'bg-[#4A0F1A] text-white shadow-sm'
               : 'hover:bg-[#4A0F1A]' }}">

            <i data-lucide="shopping-cart" class="w-4 h-4"></i>

            <span class="font-medium">
                Pemesanan
            </span>
        </a>

        {{-- Pembayaran --}}
        <a href="{{ route('user.pembayaran.upload') }}"
           class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm transition
           {{ request()->routeIs('user.pembayaran.*')
               ? 'bg-[#4A0F1A] text-white shadow-sm'
               : 'hover:bg-[#4A0F1A]' }}">

            <i data-lucide="credit-card" class="w-4 h-4"></i>

            <span class="font-medium">
                Pembayaran
            </span>
        </a>

    </nav>

    {{-- Footer --}}
    <div class="pt-5 border-t border-white/10">

        <a href="{{ route('Beranda') }}"
           class="flex items-center gap-3 py-2 px-4 text-xs text-[#D4AF37] hover:underline transition">

            <i data-lucide="arrow-left" class="w-4 h-4"></i>

            <span>
                Kembali ke Beranda
            </span>
        </a>

    </div>

</aside>