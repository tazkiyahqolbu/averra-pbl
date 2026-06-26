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

    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile Header -->
        <header class="sticky top-0 z-30 border-b border-white/10 bg-[#4A0F1A] px-4 py-3 lg:hidden flex items-center justify-between shadow-md">
            <button @click="sidebarOpen = true" class="rounded-lg p-2 text-[#FAF3E0] hover:bg-white/10 transition">
                <i data-lucide="menu" class="h-6 w-6"></i>
            </button>
            <h1 class="font-serif font-semibold tracking-wider text-[#FAF3E0] text-lg">SILART</h1>
            <div class="w-10"></div>
        </header>

        @include('user.layouts.sidebar')

        <main class="min-h-screen lg:ml-56 transition-all duration-300">
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
