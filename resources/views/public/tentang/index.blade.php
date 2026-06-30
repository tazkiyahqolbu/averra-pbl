<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Sanggar Seni Rantiang Tagok</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<<<<<<< HEAD
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
=======
    <style>
        /* Animasi Scroll Fade */
        .scroll-fade { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .scroll-fade.in-view { opacity: 1; transform: translateY(0); }
        .scroll-delay-1 { transition-delay: 0.1s; }
        .scroll-delay-2 { transition-delay: 0.2s; }
        
        /* Font Styling */
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap');
    </style>
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: { DEFAULT: '#7B1C2E', deep: '#4A0F1A' },
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
<<<<<<< HEAD

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30 pt-20">
=======
<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased pt-20">
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)

@include('public.layouts.navbar')

<<<<<<< HEAD
<!-- HERO -->
<section class="relative isolate py-20 px-6 text-center overflow-hidden">

    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#F5EBD0] to-[#FAF3E0]"></div>

    <div class="absolute inset-0 -z-10 opacity-[0.06]">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-geo-about" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M40 3 L77 40 L40 77 L3 40 Z"
                          fill="none" stroke="#7B1C2E" stroke-width="1"/>
                    <path d="M40 18 L62 40 L40 62 L18 40 Z"
                          fill="none" stroke="#7B1C2E" stroke-width="0.6"/>
                    <circle cx="40" cy="40" r="1.5" fill="#7B1C2E"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-geo-about)"/>
        </svg>
    </div>

    <div class="pointer-events-none absolute -top-32 right-0 h-[500px] w-[500px] rounded-full opacity-30"
         style="background: radial-gradient(circle, #e8d5a0 0%, transparent 68%);"></div>

    <div class="pointer-events-none absolute -bottom-32 -left-32 h-[420px] w-[420px] rounded-full opacity-20"
         style="background: radial-gradient(circle, #d4b870 0%, transparent 68%);"></div>

    <h1 class="font-serif text-5xl md:text-7xl font-light mb-6 text-[#4A0F1A]">
        Mengenal
        <em class="text-[#C8A84B] not-italic font-medium">
            Sanggar Rantiang Tagok
        </em>
    </h1>

    <p class="text-lg md:text-xl font-serif text-[#4A2E28] max-w-2xl mx-auto">
        Beroperasi sejak tahun 2012, berevolusi dari sanggar sekolah ke bentuk profesional.
    </p>
</section>

<!-- PROFIL -->
<section class="py-24 px-6 sm:px-12 lg:px-24 max-w-7xl mx-auto bg-[#FFFDF7] border-y border-[#E2D4C0]/50 relative isolate">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

        <div class="relative group mx-auto max-w-lg w-full">
            <div class="absolute -inset-2 rounded-2xl bg-[#C8A84B]/10 blur opacity-70"></div>
            <div class="relative aspect-[3/4] overflow-hidden rounded-2xl border border-[#E2D4C0] shadow-lg">
                <img
                    src="{{ asset('foto/Busana tari.jpeg') }}"
                    alt="Tim Sanggar"
                    class="w-full h-full object-cover"
                >
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <p class="text-xs tracking-[0.3em] text-[#C8A84B] uppercase font-semibold mb-2">
                    — PROFIL KAMI —
                </p>

                <h3 class="text-3xl md:text-4xl font-serif text-[#4A0F1A] mb-6 leading-tight font-light">
                    Sejarah dan Profil
                    <br>
                    <em class="text-[#C8A84B] not-italic">Sanggar</em>
                </h3>

                <div class="h-[1px] bg-gradient-to-r from-[#C8A84B] to-transparent mb-6 w-24"></div>
            </div>

            <div class="space-y-4 text-sm sm:text-base leading-relaxed text-[#4A2E28] text-justify">
                <p>
                    Perjalanan Sanggar Rantiang Tagok dimulai pada tahun 2012 sebagai sanggar sekolah.
                    Seiring waktu, kami berkembang menjadi sanggar profesional.
                </p>

                <div class="space-y-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-5 mt-6">
                    <h4 class="flex items-center gap-2 font-serif text-lg font-medium text-[#4A0F1A]">
                        <i data-lucide="info" class="h-4 w-4 text-[#C8A84B]"></i>
                        Profil Ringkas
                    </h4>

                    <ul class="space-y-2 text-sm text-[#4A2E28]">
                        <li><strong>Pemilik Sanggar:</strong> Desi Angreni</li>
                        <li><strong>Pengelolaan:</strong> Tim beranggotakan tujuh orang</li>
                        <li><strong>Target Audiens:</strong> Umum</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KEGIATAN -->
<section class="py-24 px-6 bg-[#FAF3E0]">
    <div class="max-w-7xl mx-auto text-center">
        <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">
            — LAYANAN KAMI —
        </p>

        <h3 class="mt-2 text-4xl font-serif font-light text-[#4A0F1A] mb-14">
            Kegiatan Utama Sanggar
        </h3>

        <div class="mx-auto mt-3 mb-10 h-[1px] w-32 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <div class="rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] p-8 hover:shadow-xl">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="music" class="h-8 w-8"></i>
=======
    {{-- ══ HERO TENTANG (Gaya Beranda) ══ --}}
    <section class="relative isolate py-24 px-6 text-center overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#F5EBD0] to-[#FAF3E0]"></div>
        
        <!-- Pola Geometris -->
        <div class="absolute inset-0 -z-10 opacity-[0.06]">
            <svg width="100%" height="100%"><pattern id="hero-geo" width="80" height="80" patternUnits="userSpaceOnUse"><path d="M40 3 L77 40 L40 77 L3 40 Z" fill="none" stroke="#7B1C2E" stroke-width="1"/></pattern><rect width="100%" height="100%" fill="url(#hero-geo)"/></svg>
        </div>

        <h1 class="font-serif text-5xl md:text-7xl font-light mb-6 text-[#4A0F1A] scroll-fade in-view">
            Mengenal <em class="text-[#C8A84B] not-italic font-medium">Sanggar Rantiang Tagok</em>
        </h1>
        <p class="text-lg md:text-xl font-serif text-[#4A2E28] max-w-2xl mx-auto scroll-fade in-view scroll-delay-1">
            Beroperasi sejak tahun 2012, berevolusi dari sanggar sekolah ke bentuk profesional.
        </p>
    </section>

    {{-- ══ PROFIL KAMI ══ --}}
    <section class="py-24 px-6 sm:px-12 lg:px-24 max-w-7xl mx-auto scroll-fade">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            
            <div class="relative group mx-auto max-w-lg w-full">
                <div class="absolute -inset-2 rounded-2xl bg-[#C8A84B]/10 blur opacity-70"></div>
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl border border-[#E2D4C0] shadow-lg">
                    <img src="{{ asset('foto/Busana tari.jpeg') }}" alt="Tim Sanggar" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <p class="text-xs tracking-[0.3em] text-[#C8A84B] uppercase font-semibold mb-2">— PROFIL KAMI —</p>
                    <h3 class="text-3xl md:text-4xl font-serif text-[#4A0F1A] mb-6 font-light">Sejarah dan Profil</h3>
                    <div class="h-[1px] bg-gradient-to-r from-[#C8A84B] to-transparent mb-6 w-24"></div>
                </div>
                
                <div class="space-y-4 text-justify text-[#4A2E28]">
                    <p>Perjalanan Sanggar Rantiang Tagok dimulai pada tahun 2012 sebagai sanggar sekolah. Seiring berjalannya waktu, kami berevolusi menjadi sanggar yang profesional. Meski dulunya dikenal dengan nama Sanggar Rampak Bandantiang, kami telah menggunakan nama Sanggar Rantiang Tagok sejak tahun 2020 hingga hari ini.</p>
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
                </div>

                <h4 class="font-serif text-2xl text-[#4A0F1A] font-medium mb-3">
                    Entertain
                </h4>

                <p class="text-[#4A2E28] text-sm leading-relaxed">
                    Menyediakan hiburan untuk berbagai acara seperti MC,
                    Wedding Organizer, Jasa Tari, Akustik, dll.
                </p>
            </div>

            <div class="rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] p-8 hover:shadow-xl">
                <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="shirt" class="h-8 w-8"></i>
                </div>

                <h4 class="font-serif text-2xl text-[#4A0F1A] font-medium mb-3">
                    Penyewaan Kostum & Alat Musik
                </h4>

                <p class="text-[#4A2E28] text-sm leading-relaxed">
                    Penyewaan kostum tari, alat musik tradisional, dan sound system.
                </p>
            </div>

        </div>
    </div>
</section>

<<<<<<< HEAD
@include('public.layouts.footer')

<script>
    window.addEventListener('load', () => {
        lucide.createIcons();
    });
</script>

=======
    {{-- ══ SCRIPT ANIMASI ══ --}}
    @include('public.layouts.footer')
    <script>
        window.addEventListener('load', () => lucide.createIcons());
        
        // Observer untuk animasi scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in-view'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));
    </script>
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
</body>
</html>