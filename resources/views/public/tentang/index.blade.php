<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Sanggar Seni Rantiang Tagok</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            DEFAULT: '#7B1C2E',
                            deep: '#4A0F1A',
                        },
                        gold: '#C8A84B',
                        cream: '#FAF3E0',
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30 pt-20">

@include('public.layouts.navbar')

{{-- HERO TENTANG --}}
<section class="relative py-24 px-6 text-center bg-gradient-to-b from-[#7B1C2E] to-[#4A0F1A] text-white overflow-hidden">
    <div class="max-w-4xl mx-auto">
        <p class="uppercase tracking-[0.4em] text-[#C8A84B] text-xs font-semibold">
            — TENTANG KAMI —
        </p>
        <h1 class="mt-4 font-serif text-5xl md:text-6xl font-light">
            Sanggar Seni Rantiang Tagok
        </h1>
        <p class="mt-6 text-sm md:text-base text-white/80 max-w-2xl mx-auto leading-relaxed">
            Melestarikan budaya, menghadirkan seni, dan menciptakan pengalaman pertunjukan
            yang berkesan untuk setiap generasi.
        </p>
    </div>
</section>

{{-- PROFIL KAMI --}}
<section class="py-24 px-6 sm:px-12 lg:px-24 max-w-7xl mx-auto bg-[#FFFDF7] border-y border-[#E2D4C0]/50 relative isolate">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FAF3E0] to-transparent"></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="relative group mx-auto max-w-lg w-full">
            <div class="absolute -inset-2 rounded-2xl bg-[#C8A84B]/10 blur opacity-70 transition duration-500 group-hover:opacity-100"></div>

            <div class="relative aspect-[3/4] overflow-hidden rounded-2xl border border-[#E2D4C0] shadow-lg">
                <img
                    src="{{ asset('foto/Busana tari.jpeg') }}"
                    alt="Tim Sanggar"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                >
            </div>
        </div>

        <div class="space-y-4 text-sm sm:text-base leading-relaxed text-[#4A2E28] text-justify">
            <p>
                Perjalanan Sanggar Rantiang Tagok dimulai pada tahun 2012 sebagai sanggar sekolah.
                Seiring berjalannya waktu, kami berevolusi menjadi sanggar yang profesional.
                Meski dulunya dikenal dengan nama Sanggar Rampak Bandantiang,
                kami telah menggunakan nama Sanggar Rantiang Tagok sejak tahun 2020 hingga hari ini.
            </p>

            <div class="space-y-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-5 mt-6">
                <h4 class="flex items-center gap-2 font-serif text-lg font-medium text-[#4A0F1A]">
                    <i data-lucide="info" class="h-4 w-4 text-[#C8A84B]"></i>
                    Profil Ringkas
                </h4>

                <ul class="space-y-2 text-sm text-[#4A2E28]">
                    <li class="flex gap-2">
                        <strong class="font-semibold text-[#4A0F1A] min-w-[120px]">Pemilik Sanggar:</strong>
                        <span>Desi Angreni</span>
                    </li>

                    <li class="flex gap-2">
                        <strong class="font-semibold text-[#4A0F1A] min-w-[120px]">Pengelolaan:</strong>
                        <span>Tim beranggotakan tujuh orang</span>
                    </li>

                    <li class="flex gap-2">
                        <strong class="font-semibold text-[#4A0F1A] min-w-[120px]">Target Audiens:</strong>
                        <span>Umum dengan tim terlatih dari berbagai latar belakang.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KEGIATAN UTAMA --}}
<section class="py-24 px-6 bg-[#FAF3E0]">
    <div class="max-w-7xl mx-auto text-center">
        <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">
            — LAYANAN KAMI —
        </p>

        <h3 class="mt-2 text-4xl font-serif font-light text-[#4A0F1A] mb-14">
            Kegiatan Utama Sanggar
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] p-8 text-left">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="music" class="h-8 w-8"></i>
                </div>

                <h4 class="font-serif text-2xl text-[#4A0F1A] font-medium mb-3">
                    Entertain
                </h4>

                <p class="text-[#4A2E28] text-sm leading-relaxed">
                    Menyediakan hiburan memukau untuk berbagai acara dan perayaan,
                    seperti MC, Wedding Organizer, Jasa Tari, Akustik, dan lainnya.
                </p>
            </div>

            <div class="rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] p-8 text-left">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="shirt" class="h-8 w-8"></i>
                </div>

                <h4 class="font-serif text-2xl text-[#4A0F1A] font-medium mb-3">
                    Penyewaan Kostum & Alat Musik
                </h4>

                <p class="text-[#4A2E28] text-sm leading-relaxed">
                    Fokus pada penyewaan berbagai pakaian, kostum, serta alat musik
                    terbaik untuk keperluan penampilan.
                </p>
            </div>
        </div>
    </div>
</section>

@include('public.layouts.footer')

<script>
    window.addEventListener('load', () => lucide.createIcons());
</script>

</body>
</html>