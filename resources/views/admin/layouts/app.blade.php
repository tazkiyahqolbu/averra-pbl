<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — SILART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAF3E0]" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">
        @include('admin.layouts.sidebar')

        <main class="min-h-screen overflow-y-auto lg:ml-64">
            <div class="p-6 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @include('admin.components.delete-modal')

    @stack('scripts')
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });
    </script>
</body>
</html>
