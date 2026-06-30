<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Sanggar Seni Rantiang Tagok</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Animasi Scroll Fade */
        .scroll-fade { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .scroll-fade.in-view { opacity: 1; transform: translateY(0); }
        .scroll-delay-1 { transition-delay: 0.1s; }
        .scroll-delay-2 { transition-delay: 0.2s; }
        
        /* Font Styling */
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap');
    </style>

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
<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased pt-20">

    @include('public.layouts.navbar')

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
                </div>
            </div>
        </div>
    </section>

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
</body>
</html>