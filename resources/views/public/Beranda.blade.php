@php
// 1. DATA LAYANAN (SERVICES)
$services = [
    ['icon' => 'heart', 'title' => 'Paket Pernikahan', 'desc' => 'Rangkaian acara adat lengkap dari akad hingga resepsi dengan sentuhan Minangkabau.'],
    ['icon' => 'sparkles', 'title' => 'Hiburan / Acara', 'desc' => 'Konsep hiburan untuk syukuran, ulang tahun, dan perayaan keluarga.'],
    ['icon' => 'mic', 'title' => 'Master of Ceremony', 'desc' => 'MC dwibahasa berpengalaman, membawa acara dengan elegan dan berwibawa.'],
    ['icon' => 'guitar', 'title' => 'Band & Akustik', 'desc' => 'Iringan musik live, dari akustik intim hingga band full untuk panggung besar.'],
    ['icon' => 'music', 'title' => 'Pertunjukan Tari', 'desc' => 'Tari Piring, Pasambahan, Indang, dan repertoar khas ranah Minang.'],
    ['icon' => 'brush', 'title' => 'Makeup & Busana', 'desc' => 'Tata rias pengantin tradisional dan modern oleh perias profesional.'],
];

// 2. DATA KATALOG KOSTUM
$costumes = [
    ['img' => asset('foto/Resepsi.jpeg'), 'name' => 'Resepsi', 'cat' => 'Wedding'],
    ['img' => asset('foto/Mc.jpeg'), 'name' => 'MC', 'cat' => 'Stage & MC'],
    ['img' => asset('foto/Busana tari.jpeg'), 'name' => 'Busana Tari', 'cat' => 'Dance Attire'],
    ['img' => asset('foto/Baju adat.jpeg'), 'name' => 'Busana Adat', 'cat' => 'Traditional Attire'],
];

// 3. DATA GALERI
$gallery = [
    ['img' => asset('foto/Akad & resepsi.jpeg'), 'span' => 'row-span-2', 'label' => 'Akad & Resepsi'],
    ['img' => asset('foto/Tari piring.jpeg'), 'span' => 'row-span-2', 'label' => 'Tari Piring'],
    ['img' => asset('foto/Tari Pasambahan.jpeg'), 'span' => 'row-span-2', 'label' => 'Tari Pasambahan'],
    ['img' => asset('foto/Stage & MC.jpeg'), 'span' => 'row-span-2', 'label' => 'Stage & MC'],
];  
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILART — Sanggar Rantiang Tagok | Layanan Adat Minangkabau</title>
    <meta name="description" content="Sistem Informasi & Layanan Sanggar Rantiang Tagok. Paket pernikahan, hiburan, MC, band, tari, dan makeup bernuansa Minangkabau elegan.">
    
    <meta property="og:title" content="SILART — Sanggar Rantiang Tagok">
    <meta property="og:description" content="Kehangatan budaya Minang berbalut kemewahan modern.">

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

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<body class="min-h-screen bg-[#FAF3E0] text-maroon antialiased selection:bg-gold/30">

    @include('public.layouts.navbar')

    <section id="home" class="relative isolate flex h-screen items-center justify-center overflow-hidden">
        <div class="absolute inset-0 -z-20 bg-cover bg-center h-full w-full" style="background-image: linear-gradient(to bottom, rgba(29,21,21,0.85), rgba(32,22,22,0.75), rgba(29,21,21,0.95)), url('{{ asset('foto/background.png') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;"></div>
        
        <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">
            <div class="mx-auto mb-6 flex items-center justify-center gap-4">
                <span class="text-xs tracking-[0.4em] text-gold uppercase font-semibold">— SANGGAR RANTIANG TAGOK —</span>
            </div>
            
            <h1 class="font-serif text-5xl font-light leading-[1.05] text-cream sm:text-7xl md:text-8xl">
                Menjaga <em class="text-gold not-italic">Warisan</em><br>Ranah Minang
            </h1>
            
            <p class="mx-auto mt-6 max-w-xl font-serif text-lg leading-relaxed text-white/90 sm:text-xl">
                Menghadirkan kehangatan adat dan kemewahan modern dalam setiap perayaan istimewa Anda.
            </p>
            
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="#booking" class="rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-8 py-3.5 font-serif text-base text-maroon-deep shadow-lg transition duration-300 hover:scale-105 transform inline-block font-semibold">
                    Booking Acara Anda
                </a>
                <a href="#tentang" class="rounded-full border border-gold/60 px-8 py-3.5 font-serif text-base text-cream transition duration-300 hover:bg-cream/10 inline-block">
                    Mengenal Kami
                </a>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-[10px] tracking-[0.4em] text-gold-soft whitespace-nowrap font-medium uppercase opacity-90">
            Adat Basandi Syarak · Syarak Basandi Kitabullah
        </div>
    </section>

   <!-- 2. SECTION TENTANG KAMI & FILOSOFI  -->
<!-- SECTION TENTANG -->
<section id="tentang" class="relative py-20 bg-maroon-deep text-cream overflow-hidden">
    <div class="mx-auto max-w-6xl px-6">
        <div class="grid gap-12 md:grid-cols-2 items-center">

            <!-- FOTO -->
            <div class="relative group">
                <div class="absolute -inset-2 rounded-lg bg-gold/10 blur opacity-75 group-hover:opacity-100 transition duration-500"></div>

                <div class="relative aspect-[4/3] sm:aspect-video md:aspect-[3/4] overflow-hidden rounded-lg border border-gold/20 bg-neutral-900 shadow-2xl">

                    <img src="{{ asset('foto/Busana tari.jpeg') }}"
                        alt="Busana Tari Rantiang Tagok"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>

            <!-- TEXT -->
            <div class="space-y-6">

                <div>
                    <p class="text-xs tracking-[0.3em] text-gold uppercase font-semibold">
                        — SEJAK 2012 —
                    </p>

                    <h2 class="mt-2 text-4xl font-light text-cream font-serif leading-tight">
                        Merawat Akar Tradisi, Mekar di Era Modern
                    </h2>

                    <div class="h-[1px] bg-gradient-to-r from-gold via-gold/40 to-transparent mt-3 w-24"></div>
                </div>

                <p class="text-sm sm:text-base text-cream/80 leading-relaxed font-light">
                    Berdiri di jantung kota Padang,
                    <strong class="font-medium text-gold">
                        Sanggar Seni Rantang Teago
                    </strong>
                    lahir dari dedikasi mendalam untuk melestarikan
                    seni, musik, dan adat tradisi khusunya Minangkabau.
                    Beroperasi sejak tahun 2012, sanggar ini terus berkembang
                    menjadi wadah profesional seni budaya Minang.
                </p>

                <!-- BOX FILOSOFI -->
                <div class="p-5 rounded-xl border border-gold/20 bg-maroon backdrop-blur-sm space-y-3">

                    <div class="space-y-1">
                        <h4 class="font-serif text-lg text-gold font-medium flex items-center gap-2">
                            <i data-lucide="sparkles" class="h-4 w-4"></i>
                            Profil & Filosofi Sanggar
                        </h4>

                        <p class="text-sm text-cream/70 leading-relaxed italic font-light">
                            "Mekar nan anggun, kokoh mengakar."
                            Sebelumnya dikenal dengan nama
                            <span class="font-medium text-gold-soft">
                                Sanggar Rampak Badan
                            </span>,
                            kami berkomitmen menjaga seni autentik Minangkabau
                            dan memadukannya dengan pengelolaan modern.
                        </p>
                    </div>

                    <div class="pt-2 border-t border-gold/10 grid grid-cols-2 gap-2 text-xs text-cream/80 font-light">

                        <div>
                            <span class="font-medium text-gold">
                                Pengelolaan:
                            </span>
                            Tim 7 Anggota Terlatih
                        </div>
                    </div>
                </div>

                <p class="text-sm sm:text-base text-cream/80 leading-relaxed font-light">
                    Kini, dengan target audiens umum dan didukung tim profesional,
                    kami fokus menyediakan layanan hiburan,
                    penyewaan kostum adat,
                    hingga pertunjukan budaya berkualitas tinggi
                    untuk menghidupkan kemegahan tradisi Minangkabau maupun daerah lain di Indonesia.
                </p>

            </div>
        </div>
    </div>
</section>

    <section id="galeri" class="relative py-20 bg-maroon-deep text-cream border-t border-maroon/30">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-10 text-center">
                <p class="text-xs tracking-[0.4em] text-gold-soft uppercase font-semibold">— MOMEN INDAH —</p>
                <h2 class="mt-2 text-4xl font-light text-cream sm:text-5xl font-serif">Dokumentasi Galeri SILART</h2>
                <div class="h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mt-2 w-32"></div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($gallery as $gal)
                    <div class="group relative rounded-xl overflow-hidden border border-gold/20 bg-maroon/30 backdrop-blur-sm p-3 shadow-md transition-all hover:-translate-y-1 hover:border-gold/40 hover:shadow-xl">
                        <div class="aspect-square overflow-hidden rounded-lg bg-neutral-900">
                            <img src="{{ $gal['img'] }}" alt="{{ $gal['label'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="pt-4 pb-2 text-center">
                            <span class="font-serif text-2xl text-gold-soft font-medium tracking-wide">{{ $gal['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

   <!-- TESTIMONI -->
<section id="testimoni"
    class="relative py-20 bg-maroon-deep text-cream overflow-hidden"
    x-data="{
        activeSlide: 0,
        totalSlides: {{ count($testimonials ?? []) ?: 3 }},
        next() {
            this.activeSlide =
            (this.activeSlide + 1) %
            this.totalSlides
        },
        prev() {
            this.activeSlide =
            (this.activeSlide - 1 +
            this.totalSlides)
            % this.totalSlides
        }
    }">

    <!-- BACKGROUND -->
    <div class="absolute inset-0 opacity-[0.04] bg-cover bg-center"
        style="background-image: url('{{ asset('foto/background.png') }}');
        filter: grayscale(100%);">
    </div>

    <div class="relative z-10 mx-auto max-w-3xl px-6 text-center">

        <!-- ICON -->
        <div class="mb-2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-gold/10 text-gold shadow-inner">
            <i data-lucide="quote" class="h-5 w-5 rotate-180"></i>
        </div>

        <p class="text-[10px] tracking-[0.2em] uppercase text-gold font-bold mb-4">
            — KATA MEREKA —
        </p>

        <!-- SLIDER -->
        <div class="relative min-h-[130px] sm:min-h-[100px] flex items-center justify-center">

            @if(isset($testimonials) && count($testimonials) > 0)

                @foreach($testimonials as $index => $t)

                    <div x-show="activeSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="w-full">

                        <blockquote class="font-serif text-xl sm:text-2xl font-light leading-relaxed max-w-2xl mx-auto text-cream">
                            &ldquo;{{ $t->quote }}&rdquo;
                        </blockquote>

                        <div class="mt-4">
                            <h4 class="font-semibold text-gold-soft tracking-wide text-sm sm:text-base">
                                {{ $t->name }}
                            </h4>

                            <p class="text-xs text-cream/60">
                                {{ $t->role }}
                            </p>
                        </div>
                    </div>

                @endforeach

            @else

                <!-- TESTI 1 -->
                <div x-show="activeSlide === 0" class="w-full">
                    <blockquote class="font-serif text-xl sm:text-2xl font-light leading-relaxed max-w-2xl mx-auto text-cream">
                        &ldquo;Tari Pasambahan dari Rantiang Tagok membuat momen pernikahan kami terasa sakral dan istimewa.&rdquo;
                    </blockquote>

                    <div class="mt-4">
                        <h4 class="font-semibold text-gold-soft text-sm sm:text-base">
                            Ananda & Reza
                        </h4>

                        <p class="text-xs text-cream/60">
                            Pernikahan Adat, Padang
                        </p>
                    </div>
                </div>

                <!-- TESTI 2 -->
                <div x-show="activeSlide === 1" class="w-full">
                    <blockquote class="font-serif text-xl sm:text-2xl font-light leading-relaxed max-w-2xl mx-auto text-cream">
                        &ldquo;Penampilan mereka menjadi sorotan malam itu — kostumnya megah dan koreografinya rapi.&rdquo;
                    </blockquote>

                    <div class="mt-4">
                        <h4 class="font-semibold text-gold-soft text-sm sm:text-base">
                            Bp. Hendra
                        </h4>

                        <p class="text-xs text-cream/60">
                            PT Sinar Mentari
                        </p>
                    </div>
                </div>

                <!-- TESTI 3 -->
                <div x-show="activeSlide === 2" class="w-full">
                    <blockquote class="font-serif text-xl sm:text-2xl font-light leading-relaxed max-w-2xl mx-auto text-cream">
                        &ldquo;Anak saya ikut kelas tari di sini dan belajar adat Minang dengan baik.&rdquo;
                    </blockquote>

                    <div class="mt-4">
                        <h4 class="font-semibold text-gold-soft text-sm sm:text-base">
                            Ibu Sari
                        </h4>

                        <p class="text-xs text-cream/60">
                            Orang tua siswa
                        </p>
                    </div>
                </div>

            @endif
        </div>

        <!-- NAVIGATION -->
        <div class="mt-6 flex items-center justify-center gap-3">

            <button @click="prev()"
                class="w-8 h-8 rounded-full border border-gold/30 hover:bg-gold/10 text-gold grid place-items-center transition">
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
            </button>

            <button @click="next()"
                class="w-8 h-8 rounded-full border border-gold/30 hover:bg-gold/10 text-gold grid place-items-center transition">
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
            </button>

        </div>
    </div>
</section>
@include('public.layouts.footer')
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        window.addEventListener('load', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>