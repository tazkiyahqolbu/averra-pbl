<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen admin-page font-body text-gray-900">
    <div class="flex min-h-screen">
        @include('admin.layouts.sidebar')

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="sticky top-0 z-20 border-b border-[#decba5] bg-[#f7efe2]/90 px-6 py-4 backdrop-blur lg:px-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7a5d58]">Admin Panel</p>
                        <h2 class="admin-title mt-1 text-2xl">@yield('page-title', 'Dashboard')</h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama ?? 'Admin' }}</p>
                            <p class="text-xs text-[#7a5d58]">{{ auth()->user()->email ?? '-' }}</p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="admin-btn-secondary px-4 py-2 text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
