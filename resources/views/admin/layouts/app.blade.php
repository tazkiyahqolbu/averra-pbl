<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Sanggar Rantiang Tagok</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAF3E0] h-screen overflow-hidden" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        @include('admin.layouts.sidebar')

        <main id="main-content" class="h-screen overflow-y-auto lg:ml-64">
            {{-- Mobile topbar --}}
            <div class="lg:hidden flex items-center justify-between px-4 h-14 border-b border-[#E2D4C0] bg-white sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="flex h-9 w-9 items-center justify-center rounded-lg text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('galeri/logo-rantiang-tagok.jpg') }}" alt="Logo" class="h-7 w-7 rounded-full object-cover border border-[#C8960C]/50">
                    <span class="font-serif text-sm font-bold text-[#4A0F1A]">Sanggar Rantiang Tagok</span>
                </div>
                <div class="w-9"></div>
            </div>
            <div class="p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @include('admin.components.delete-modal')

    @stack('scripts')
    <script>
        window.addEventListener('load', () => {
            lucide.createIcons();

            // Restore sidebar scroll position after page load
            const sidebarNav = document.getElementById('sidebar-nav');
            if (sidebarNav) {
                const savedScroll = sessionStorage.getItem('sidebar-scroll');
                if (savedScroll !== null) {
                    sidebarNav.scrollTop = parseInt(savedScroll, 10);
                }

                // Save scroll position before navigating away
                sidebarNav.addEventListener('scroll', () => {
                    sessionStorage.setItem('sidebar-scroll', sidebarNav.scrollTop);
                });
            }

            // Page transition: fade-in content area only (not body)
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.classList.add('page-content-enter');
                mainContent.addEventListener('animationend', () => {
                    mainContent.classList.remove('page-content-enter');
                }, { once: true });
            }
        });

        // Page transition: fade-out content before navigate
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript') ||
                link.getAttribute('target') === '_blank' || link.hasAttribute('download') ||
                e.ctrlKey || e.metaKey || e.shiftKey) return;
            try {
                const url = new URL(href, window.location.href);
                if (url.origin !== window.location.origin) return;
            } catch(err) { return; }
            e.preventDefault();
            const dest = link.href;
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.classList.add('page-content-leave');
                setTimeout(() => { window.location.href = dest; }, 170);
            } else {
                window.location.href = dest;
            }
        });
    </script>
</body>
</html>
