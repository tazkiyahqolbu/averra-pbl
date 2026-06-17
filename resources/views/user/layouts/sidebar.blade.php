<aside class="w-64 bg-red-950 text-white h-screen sticky top-0 flex-shrink-0 overflow-y-auto">
    <div class="p-6 flex flex-col h-full">
        
        <div class="mb-10 flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-[#5D001E] text-white flex items-center justify-center font-bold shadow-sm">
                {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] text-[#7A001D] uppercase tracking-wider">Akun Saya</p>
                <p class="font-bold truncate text-sm">{{ $user->nama ?? 'Tamu' }}</p>
            </div>
        </div>

        <nav class="flex flex-col gap-1 flex-grow">
            @php
                $menuItems = [
                    ['name' => 'Dashboard', 'route' => 'user.dashboard.index'],
                    ['name' => 'Pemesanan', 'route' => 'user.pemesanan.index'],
                    ['name' => 'Profil', 'route' => 'user.profile.index'],
                ];
            @endphp

            @foreach($menuItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="px-4 py-3 transition-colors duration-200 
                   {{ (request()->route()->getName() === $item['route']) 
                      ? 'text-yellow-500 font-bold' 
                      : 'text-white/60 hover:text-white' }}">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </nav>

        <div class="pt-6 mt-6 border-t border-white/10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-white/50 hover:text-white transition-colors">
                <span class="text-sm">← Kembali ke Beranda</span>
            </a>
        </div>

    </div>
</aside>