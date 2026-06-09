<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avera SILART — Dashboard Pelanggan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

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
</head>
<body class="min-h-screen bg-cream text-maroon antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- PANGGIL KODE SIDEBAR MODULAR -->
        @include('user.layouts.sidebar')

        <!-- AREA UTAMA KANAN (Header Mobile + Main Content) -->
        <div class="flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            
            <!-- Header Ringkas ketika dibuka via Smartphone -->
            <header class="flex h-16 items-center justify-between bg-maroon px-4 text-cream md:hidden shadow-md">
                <span class="font-serif text-xl tracking-[0.2em] text-gold font-bold">SILART</span>
                <button @click="sidebarOpen = !sidebarOpen" class="rounded-xl p-2 hover:bg-maroon-deep text-cream">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </header>

            <!-- Wrapper Pengisi Yield Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>