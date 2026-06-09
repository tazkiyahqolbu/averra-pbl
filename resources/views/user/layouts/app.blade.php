<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SILART')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#FAF3E0',
                        foreground: '#7B1C2E',

                        maroon: {
                            DEFAULT: '#7B1C2E',
                            deep: '#4A0F1A',
                        },

                        gold: {
                            DEFAULT: '#C8A84B',
                            soft: '#D9C07A',
                        },

                        cream: '#FAF3E0',
                    },

                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="bg-maroon-deep text-cream antialiased">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Isi halaman -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <script defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    <!-- Render Lucide -->
    <script>
        window.addEventListener('load', () => {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')

</body>
</html>