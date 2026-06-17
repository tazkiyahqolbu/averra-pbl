<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Averra | Sanggar Rantiang Tagok</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wdth,wght@0,75..100,400..700;1,75..100,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAF3E0] text-[#5D001E] min-h-screen font-sans">
    <div class="flex">
        @include('user.layouts.sidebar')
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>lucide.createIcons();</script>
</body>
</html>
