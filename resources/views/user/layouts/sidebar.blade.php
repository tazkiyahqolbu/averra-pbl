<!-- Sidebar Container -->
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-maroon-deep text-cream border-r border-black/10 shadow-xl transition-transform duration-300 md:static md:translate-x-0 shrink-0 h-full">

    <!-- Brand Title Section -->
    <div class="flex h-16 items-center justify-between px-6 border-b border-black/10">
        <div class="flex flex-col">
            <span class="font-serif text-2xl tracking-[0.2em] text-gold font-bold">SILART</span>
            <span class="text-[10px] text-cream/50 tracking-wider uppercase">User </span>
        </div>
        <!-- Button Close di Mobile -->
        <button @click="sidebarOpen = false" class="md:hidden text-cream hover:text-gold transition">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>

    <!-- Navigasi Menu Pelanggan -->
    <nav class="flex-1 space-y-1 px-4 py-6 overflow-y-auto">

        <!-- Menu Dashboard -->
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all group {{ Request::is('user/dashboard') ? 'bg-black/20 text-gold font-semibold shadow-inner' : 'text-cream/80 hover:bg-black/10 hover:text-cream' }}">
            <i data-lucide="layout-dashboard" class="h-4 w-4 {{ Request::is('user/dashboard') ? 'text-gold' : 'text-cream/40 group-hover:text-cream' }}"></i>
            Dashboard
        </a>

        <!-- Menu Profil -->
        <a href="#"
           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all group {{ Request::is('user/profile') ? 'bg-black/20 text-gold font-semibold shadow-inner' : 'text-cream/80 hover:bg-black/10 hover:text-cream' }}">
            <i data-lucide="user" class="h-4 w-4 {{ Request::is('user/profile') ? 'text-gold' : 'text-cream/40 group-hover:text-cream' }}"></i>
            Profil Saya
        </a>

        <!-- Menu Pemesanan -->
        <a href="#"
           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all group {{ Request::is('user/pemesanan*') ? 'bg-black/20 text-gold font-semibold shadow-inner' : 'text-cream/80 hover:bg-black/10 hover:text-cream' }}">
            <i data-lucide="shopping-bag" class="h-4 w-4 {{ Request::is('user/pemesanan*') ? 'text-gold' : 'text-cream/40 group-hover:text-cream' }}"></i>
            Pemesanan
        </a>

        <!-- Menu Pembayaran -->
        <a href="#"
           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all group {{ Request::is('user/pembayaran/upload*') ? 'bg-black/20 text-gold font-semibold shadow-inner' : 'text-cream/80 hover:bg-black/10 hover:text-cream' }}">
            <i data-lucide="credit-card" class="h-4 w-4 {{ Request::is('user/pembayaran/upload*') ? 'text-gold' : 'text-cream/40 group-hover:text-cream' }}"></i>
            Pembayaran
        </a>

        <!-- Pembatas Sempurna -->
        <div class="py-4">
            <div class="h-[1px] bg-black/10 w-full"></div>
        </div>

        <!-- Tombol Keluar Kembali Ke Web Utama -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-cream/60 hover:bg-black/10 hover:text-cream transition-all group">
            <i data-lucide="arrow-left-circle" class="h-4 w-4 text-cream/30 group-hover:text-cream"></i>
            Website Utama
        </a>

    </nav>
</aside>

<!-- Black Transparent Layer di Mobile saat Sidebar terbuka -->
<div @click="sidebarOpen = false" x-show="sidebarOpen" class="fixed inset-0 z-40 bg-black/40 md:hidden"></div>
