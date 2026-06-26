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

    <div class="flex min-h-screen">
        @include('user.layouts.sidebar')

        <main class="flex-1 min-w-0 overflow-auto">
            <div class="p-8 lg:p-10">
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
