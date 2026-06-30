<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Averra — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-[#FAF3E0] text-[#4A2E28] antialiased"
      style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        @include('user.layouts.sidebar')

        <main class="flex-1 min-w-0 overflow-auto">
            {{-- Mobile topbar --}}
            <div class="lg:hidden flex items-center justify-between px-4 h-14 border-b border-[#E2D4C0] bg-white sticky top-0 z-20">
                <button @click="sidebarOpen = true" class="flex h-9 w-9 items-center justify-center rounded-lg text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="font-serif text-base font-bold tracking-[0.2em] text-[#4A0F1A]">SILART</span>
                <div class="w-9"></div>
            </div>
            <div class="p-4 sm:p-6 lg:p-10">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });
    </script>
</body>
</html>
