<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri | SILART — Sanggar Rantiang Tagok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Instrument+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4A0F1A', // Marun Gelap
                        accent: '#C8A84B',  // Emas
                        paper: '#FAF3E0',   // Krem Utama
                        alt: '#FFFDF7'      // Krem Terang
                    },
                    fontFamily: {
                        serif: ['Cormorant Garamond', 'serif'],
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen bg-paper text-primary antialiased pt-20">

    @include('User.layouts.navbar')

    {{-- HERO SECTION --}}
    <section class="relative bg-paper py-24 px-6 text-center border-b border-primary/10">
        <div class="max-w-4xl mx-auto">
            <p class="text-xs tracking-[0.4em] text-accent uppercase font-semibold mb-4">— DOKUMENTASI —</p>
            <h1 class="font-serif text-5xl md:text-7xl font-light mb-6 text-primary">
                Momen yang Sudah<br><em class="text-accent not-italic font-medium">Diabadikan</em>
            </h1>
        </div>
    </section>

    @php
        $gallery = [
            ['img' => asset('image/Akad & resepsi.jpeg'),   'label' => 'Akad & Resepsi',    'cat' => 'Wedding'],
            ['img' => asset('image/Tari piring.jpeg'),     'label' => 'Tari Piring',       'cat' => 'Pertunjukan'],
            ['img' => asset('image/Tari Pasambahan.jpeg'), 'label' => 'Tari Pasambahan',   'cat' => 'Pertunjukan'],
            ['img' => asset('image/Stage & MC.jpeg'),      'label' => 'Stage & MC',        'cat' => 'Entertainment'],
            ['img' => asset('image/Resepsi.jpeg'),         'label' => 'Resepsi Pernikahan','cat' => 'Wedding'],
            ['img' => asset('image/Mc.jpeg'),              'label' => 'Master of Ceremony','cat' => 'Entertainment'],
            ['img' => asset('image/Busana tari.jpeg'),     'label' => 'Busana Tari',       'cat' => 'Kostum'],
            ['img' => asset('image/Baju adat.jpeg'),       'label' => 'Busana Adat',       'cat' => 'Kostum'],
            ['img' => asset('image/Tari Kreasi.jpeg'),     'label' => 'Tari Kreasi',       'cat' => 'Pertunjukan'], 
        ];
    @endphp

    <section class="py-24 px-6 sm:px-12 lg:px-24 bg-alt" x-data="{ lightboxOpen: false, activeImg: '', activeLabel: '', activeCat: '' }">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16 text-center">
                <h2 class="text-4xl md:text-5xl font-light text-primary font-serif mb-4">Koleksi Momen</h2>
                <div class="mx-auto h-[1px] w-24 bg-accent mb-6"></div>
                <p class="text-sm text-primary/70 max-w-2xl mx-auto font-light">Eksplorasi jejak langkah dan momen tak terlupakan yang telah kami rangkai dengan penuh dedikasi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($gallery as $i => $gal)
                    <div class="relative rounded-2xl overflow-hidden group cursor-pointer animate-fade-in-up shadow-lg h-[400px] border border-primary/10" 
                         style="animation-delay: {{ ($i * 0.1) }}s"
                         @click="lightboxOpen = true; activeImg = '{{ $gal['img'] }}'; activeLabel = '{{ $gal['label'] }}'; activeCat = '{{ $gal['cat'] }}'">
                        
                        <img src="{{ $gal['img'] }}" alt="{{ $gal['label'] }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                            <span class="inline-block px-3 py-1 mb-2 text-[10px] tracking-[0.2em] text-primary bg-accent uppercase font-bold rounded-full w-max">
                                {{ $gal['cat'] }}
                            </span>
                            <h3 class="text-2xl font-serif text-white">{{ $gal['label'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Lightbox --}}
        <div x-show="lightboxOpen" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-primary/95 p-4 sm:p-12 backdrop-blur-sm"
             @keydown.escape.window="lightboxOpen = false" x-cloak>
            
            <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white hover:text-accent transition-colors p-2 z-50">
                <i data-lucide="x" class="w-8 h-8"></i>
            </button>

            <div class="relative w-full max-w-5xl flex flex-col items-center" @click.away="lightboxOpen = false">
                <img :src="activeImg" class="max-h-[70vh] rounded-xl border-4 border-white/10 shadow-2xl">
                <div class="mt-6 text-center">
                    <span class="text-xs tracking-[0.2em] text-accent uppercase font-semibold" x-text="activeCat"></span>
                    <h3 class="text-3xl font-serif text-white mt-1" x-text="activeLabel"></h3>
                </div>
            </div>
        </div>
    </section>

    @include('User.layouts.footer')

    <script>
        window.addEventListener('load', () => lucide.createIcons());
    </script>
</body>
</html>