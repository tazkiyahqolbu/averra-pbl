
<!-- Navbar -->
<header
    x-data="{ open: false }"
    class="fixed top-0 inset-x-0 z-50 bg-transparent">

    <nav class="mx-auto max-w-7xl px-6 lg:px-10 h-24 flex items-center justify-between">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">

            <!-- Logo Icon -->
            <div
                class="flex h-12 w-12 items-center justify-center
                rounded-full
                border border-[#C8A84B]/50
                bg-transparent
                transition duration-300 group-hover:scale-105">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-[#C8A84B]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 3l1.912 5.813H20l-4.956 3.6L16.912 18 12 14.4 7.088 18l1.868-5.587L4 8.813h6.088L12 3z"/>
                </svg>
            </div>

            <!-- Text Logo -->
            <div class="leading-tight">
                <h1
                    class="text-xl font-semibold tracking-[0.25em] text-[#FAF3E0]"
                    style="font-family:'Cormorant Garamond', serif;">

                    SILART
                </h1>

                <p class="text-[11px] tracking-[0.35em] text-[#C8A84B] uppercase">
                    Rantiang Tagok
                </p>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center gap-8">

            <a href="{{ url('/') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Beranda
            </a>

            <a href="{{ url('/layanan') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Layanan
            </a>

            <a href="{{ url('/katalog') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Katalog
            </a>

            <a href="{{ url('/galeri') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Galeri
            </a>

            <a href="{{ url('/booking') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Pemesanan
            </a>

            <a href="{{ url('/testimoni') }}"
                class="text-[#E8D7A3]
                hover:text-[#FAF3E0]
                transition duration-300
                text-sm tracking-wide">

                Testimoni
            </a>
        </div>

        <!-- Desktop Auth -->
        <div class="hidden lg:flex items-center gap-3">

            @guest

                <!-- Login -->
                <a href="/login"
                    class="rounded-full
                    border border-[#C8A84B]/60
                    bg-transparent
                    px-6 py-2.5
                    text-[#E8D7A3]
                    hover:bg-[#C8A84B]/15
                    hover:text-[#FAF3E0]
                    transition duration-300">

                    Masuk
                </a>

                <!-- Register -->
                <a href="/register"
                    class="rounded-full
                    bg-[#C8A84B]
                    hover:bg-[#D6B35C]
                    text-[#4A0F1A]
                    font-semibold
                    px-6 py-2.5
                    shadow-md
                    transition duration-300">

                    Daftar
                </a>

            @endguest


            @auth

                <!-- Dashboard -->
                <a href="/dashboard"
                    class="rounded-full
                    border border-[#C8A84B]/40
                    bg-[#7B1C2E]/50
                    px-5 py-2.5
                    text-[#FAF3E0]
                    hover:bg-[#7B1C2E]/70
                    transition">

                    {{ explode(' ', Auth::user()->name)[0] }}
                </a>

                <!-- Logout -->
                <form method="POST" action="/logout">
                    @csrf

                    <button type="submit"
                        class="rounded-full
                        border border-[#C8A84B]/60
                        px-5 py-2.5
                        text-[#E8D7A3]
                        hover:bg-[#C8A84B]
                        hover:text-[#4A0F1A]
                        transition">

                        Logout
                    </button>
                </form>

            @endauth

        </div>

        <!-- Mobile Button -->
        <button
            @click="open = !open"
            class="lg:hidden flex h-11 w-11 items-center justify-center
            rounded-full
            border border-[#C8A84B]/40
            bg-transparent
            transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-[#FAF3E0]"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <!-- Menu -->
                <path
                    x-show="!open"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />

                <!-- Close -->
                <path
                    x-show="open"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </nav>

    <!-- Mobile Menu -->
    <div
        x-show="open"
        x-transition
        class="lg:hidden
        bg-[#4A0F1A]/95
        border-t border-[#C8A84B]/20
        backdrop-blur-md">

        <div class="px-5 py-5 flex flex-col gap-2">

            <a href="/"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Home
            </a>

            <a href="/layanan"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Layanan
            </a>

            <a href="/katalog"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Katalog
            </a>

            <a href="/galeri"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Galeri
            </a>

            <a href="/booking"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Booking
            </a>

            <a href="/testimoni"
                class="rounded-xl px-4 py-3 text-[#E8D7A3] hover:bg-[#C8A84B]/10 transition">
                Testimoni
            </a>

            <div class="mt-4 border-t border-[#C8A84B]/20 pt-4">

                @guest
                    <div class="flex gap-2">

                        <a href="/login"
                            class="flex-1 text-center rounded-full
                            border border-[#C8A84B]
                            py-2 text-[#E8D7A3]
                            hover:bg-[#C8A84B]
                            hover:text-[#4A0F1A]
                            transition">

                            Masuk
                        </a>

                        <a href="/register"
                            class="flex-1 text-center rounded-full
                            bg-[#C8A84B]
                            text-[#4A0F1A]
                            font-semibold
                            py-2 hover:bg-[#D6B35C]
                            transition">

                            Daftar
                        </a>

                    </div>
                @endguest

                @auth
                    <a href="/dashboard"
                        class="block text-center rounded-full
                        bg-[#7B1C2E]
                        text-[#FAF3E0]
                        py-2 hover:bg-[#8C2236]
                        transition">

                        Dashboard
                    </a>
                @endauth

            </div>
        </div>
    </div>

</header>
