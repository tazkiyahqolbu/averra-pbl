<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SILART')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#F8F3EA]">
    <div x-data="{ sidebarOpen:false }" class="min-h-screen">

        {{-- Mobile Header --}}
        <header class="sticky top-0 z-30 border-b bg-white px-4 py-3 lg:hidden">
            <div class="flex items-center justify-between">
                <button @click="sidebarOpen = true" class="rounded-lg p-2 hover:bg-gray-100">
                    ☰
                </button>

                <h1 class="font-semibold text-[#5A0B1A]">
                    Admin SILART
                </h1>
            </div>
        </header>

        @include('admin.layouts.sidebar')

        <main class="min-h-screen lg:ml-64">
            <div class="mx-auto max-w-screen-2xl px-4 py-4 md:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
