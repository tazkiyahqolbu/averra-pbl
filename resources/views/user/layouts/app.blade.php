<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | Sanggar Rantiang Tagok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#FAF3E0] text-[#5D001E] min-h-screen font-sans">
    <div class="flex">
        @include('user.layouts.sidebar')
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>