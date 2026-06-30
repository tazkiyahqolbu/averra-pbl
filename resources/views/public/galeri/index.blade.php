<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri | SILART — Sanggar Rantiang Tagok</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    <style>
        [x-cloak] { display:none !important; }
        .scroll-fade { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .scroll-fade.in-view { opacity: 1; transform: translateY(0); }
    </style>
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30 pt-20">

@include('public.layouts.navbar')

{{-- HERO --}}
<section class="relative isolate py-20 px-6 text-center overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#F5EBD0] to-[#FAF3E0]"></div>
    
    <div class="absolute inset-0 -z-10 opacity-[0.06]">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-geo-gallery" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M40 3 L77 40 L40 77 L3 40 Z" fill="none" stroke="#7B1C2E" stroke-width="1"/>
                    <path d="M40 18 L62 40 L40 62 L18 40 Z" fill="none" stroke="#7B1C2E" stroke-width="0.6"/>
                    <circle cx="40" cy="40" r="1.5" fill="#7B1C2E"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-geo-gallery)"/>
        </svg>
    </div>

    <div class="pointer-events-none absolute -top-32 right-0 h-[500px] w-[500px] rounded-full opacity-30" style="background: radial-gradient(circle, #e8d5a0 0%, transparent 68%);"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-32 h-[420px] w-[420px] rounded-full opacity-20" style="background: radial-gradient(circle, #d4b870 0%, transparent 68%);"></div>

    <h1 class="font-serif text-3xl md:text-5xl font-light mb-4 text-[#4A0F1A]">
        Dokumentasi <em class="text-[#C8A84B] not-italic font-medium">Galeri</em>
    </h1>
    <p class="text-sm md:text-lg font-serif text-[#4A2E28] max-w-xl mx-auto">Momen berharga yang telah kami abadikan bersama.</p>
</section>

@php
    $galeriJson = $galeris->map(fn($g) => [
        'media' => $g->media_url,
        'type'  => $g->jenis_media,
        'label' => $g->judul,
        'cat'   => $g->kategori ?? '',
    ]);
@endphp

{{-- GALERI --}}
<section class="py-24 px-6 sm:px-12 lg:px-24 max-w-7xl mx-auto bg-[#FFFDF7] border-y border-[#E2D4C0]/50"
    x-data="{ items: {{ $galeriJson->toJson() }}, open: false, idx: 0, get active(){ return this.items[this.idx] ?? {} }, show(i){ this.idx = i; this.open = true; }, prev(){ this.idx = (this.idx - 1 + this.items.length) % this.items.length; }, next(){ this.idx = (this.idx + 1) % this.items.length; } }"
    @keydown.escape.window="open=false">

    <div class="text-center mb-16 scroll-fade in-view">
        <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— MOMEN INDAH —</p>
        <h2 class="mt-2 text-4xl font-serif font-light text-[#4A0F1A]">Koleksi Momen</h2>
        <div class="mx-auto mt-3 h-[1px] w-24 bg-gradient-to-r from-[#C8A84B] to-transparent"></div>
    </div>

    @if($galeris->isEmpty())
        <p class="text-center text-[#4A0F1A]/50 py-16">Belum ada dokumentasi.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galeris as $i => $item)
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-lg h-[400px] border border-[#E2D4C0] scroll-fade"
                     style="transition-delay: {{ $i * 0.1 }}s"
                     @click="show({{ $i }})">

                    @if($item->jenis_media === 'video')
                        <video class="w-full h-full object-cover" muted preload="metadata"><source src="{{ $item->media_url }}"></video>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-colors">
                            <i data-lucide="play-circle" class="w-16 h-16 text-white/80"></i>
                        </div>
                    @else
                        <img src="{{ $item->media_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @endif

                    {{-- Gradasi Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#4A0F1A]/90 via-[#4A0F1A]/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>

                    <div class="absolute bottom-0 left-0 w-full p-8 translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                        @if($item->kategori)
                            <span class="inline-block px-3 py-1 mb-2 text-[10px] tracking-[0.2em] text-[#4A0F1A] bg-[#C8A84B] uppercase font-bold rounded-full">{{ $item->kategori }}</span>
                        @endif
                        <h3 class="text-2xl font-serif text-white">{{ $item->judul }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- LIGHTBOX --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-[#4A0F1A]/95 backdrop-blur-sm">
        <button @click="open=false" class="absolute top-6 right-6 text-white hover:text-[#C8A84B]"><i data-lucide="x" class="w-8 h-8"></i></button>
        <div class="w-full max-w-5xl px-20 flex flex-col items-center">
            <template x-if="active.type === 'video'"><video :src="active.media" controls autoplay class="max-h-[70vh] rounded-xl"></video></template>
            <template x-if="active.type !== 'video'"><img :src="active.media" class="max-h-[70vh] rounded-xl object-contain"></template>
            <div class="mt-6 text-center"><h3 class="text-3xl font-serif text-white mt-2" x-text="active.label"></h3></div>
        </div>
    </div>
</section>

@include('public.layouts.footer')

<script>
    window.addEventListener('load', () => {
        lucide.createIcons();
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in-view'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));
    });
</script>
</body>
</html>