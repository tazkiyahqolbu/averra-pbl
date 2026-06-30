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
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
=======
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
<<<<<<< HEAD
                        maroon: {
                            DEFAULT: '#7B1C2E',
                            deep: '#4A0F1A',
                        },
=======
                        maroon: { DEFAULT: '#7B1C2E', deep: '#4A0F1A' },
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
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
<<<<<<< HEAD

        .animate-fade-in-up {
            animation: fadeInUp .6s ease-out both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
=======
        .scroll-fade { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .scroll-fade.in-view { opacity: 1; transform: translateY(0); }
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
    </style>
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30 pt-20">

@include('public.layouts.navbar')

{{-- HERO --}}
<section class="relative isolate py-20 px-6 text-center overflow-hidden">
<<<<<<< HEAD

    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#F5EBD0] to-[#FAF3E0]"></div>

    <div class="absolute inset-0 -z-10 opacity-[0.06]">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-geo-gallery" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <path d="M40 3 L77 40 L40 77 L3 40 Z"
                          fill="none" stroke="#7B1C2E" stroke-width="1"/>
                    <path d="M40 18 L62 40 L40 62 L18 40 Z"
                          fill="none" stroke="#7B1C2E" stroke-width="0.6"/>
                    <circle cx="40" cy="40" r="1.5" fill="#7B1C2E"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-geo-gallery)"/>
        </svg>
    </div>

    <div class="pointer-events-none absolute -top-32 right-0 h-[500px] w-[500px] rounded-full opacity-30"
         style="background: radial-gradient(circle, #e8d5a0 0%, transparent 68%);"></div>

    <div class="pointer-events-none absolute -bottom-32 -left-32 h-[420px] w-[420px] rounded-full opacity-20"
         style="background: radial-gradient(circle, #d4b870 0%, transparent 68%);"></div>

    <h1 class="font-serif text-3xl md:text-5xl font-light mb-4 text-[#4A0F1A]">
        Dokumentasi
        <em class="text-[#C8A84B] not-italic font-medium">
            Galeri
        </em>
    </h1>

    <p class="text-sm md:text-lg font-serif text-[#4A2E28] max-w-xl mx-auto">
        Momen berharga yang telah kami abadikan bersama.
    </p>
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
<section
    class="py-24 px-6 sm:px-12 lg:px-24 max-w-7xl mx-auto bg-[#FFFDF7] border-y border-[#E2D4C0]/50 relative isolate"
    x-data="{
        items: {{ $galeriJson->toJson() }},
        open: false,
        idx: 0,
        get active(){ return this.items[this.idx] ?? {} },
        show(i){ this.idx = i; this.open = true; },
        prev(){ this.idx = (this.idx - 1 + this.items.length) % this.items.length; },
        next(){ this.idx = (this.idx + 1) % this.items.length; }
    }"
    @keydown.escape.window="open=false"
    @keydown.arrow-left.window="if(open) prev()"
    @keydown.arrow-right.window="if(open) next()">

    <div class="text-center mb-16">
        <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">
            — MOMEN INDAH —
        </p>

        <h2 class="mt-2 text-4xl font-serif font-light text-[#4A0F1A]">
            Koleksi Momen
        </h2>

=======
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
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
        <div class="mx-auto mt-3 h-[1px] w-24 bg-gradient-to-r from-[#C8A84B] to-transparent"></div>
    </div>

    @if($galeris->isEmpty())
<<<<<<< HEAD
        <p class="text-center text-[#4A0F1A]/50 py-16">
            Belum ada dokumentasi.
        </p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galeris as $i => $item)
                <div class="relative rounded-2xl overflow-hidden group cursor-pointer shadow-lg h-[400px] border border-[#E2D4C0] animate-fade-in-up"
                     style="animation-delay: {{ $i * 0.1 }}s"
                     @click="show({{ $i }})">

                    @if($item->jenis_media === 'video')
                        <video class="w-full h-full object-cover" muted preload="metadata">
                            <source src="{{ $item->media_url }}">
                        </video>

                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <i data-lucide="play-circle" class="w-16 h-16 text-white"></i>
                        </div>
                    @else
                        <img src="{{ $item->media_url }}"
                             alt="{{ $item->judul }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-[#4A0F1A]/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex flex-col justify-end p-8">
                        @if($item->kategori)
                            <span class="inline-block px-3 py-1 mb-2 text-[10px] tracking-[0.2em] text-[#4A0F1A] bg-[#C8A84B] uppercase font-bold rounded-full w-max">
                                {{ $item->kategori }}
                            </span>
                        @endif

                        <h3 class="text-2xl font-serif text-white">
                            {{ $item->judul }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- LIGHTBOX --}}
    <div x-show="open"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-[#4A0F1A]/95 backdrop-blur-sm">

        <button @click="open=false"
                class="absolute top-6 right-6 text-white hover:text-[#C8A84B]">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>

        <button @click.stop="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
            <i data-lucide="chevron-left"></i>
        </button>

        <button @click.stop="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
            <i data-lucide="chevron-right"></i>
        </button>

        <div class="w-full max-w-5xl px-20 flex flex-col items-center">
            <template x-if="active.type === 'video'">
                <video :src="active.media"
                       controls autoplay
                       class="max-h-[70vh] rounded-xl"></video>
            </template>

            <template x-if="active.type !== 'video'">
                <img :src="active.media"
                     class="max-h-[70vh] rounded-xl object-contain">
            </template>

            <div class="mt-6 text-center">
                <span class="text-xs uppercase tracking-[0.2em] text-[#C8A84B]"
                      x-text="active.cat"></span>

                <h3 class="text-3xl font-serif text-white mt-2"
                    x-text="active.label"></h3>
            </div>
        </div>
    </div>
</section>



=======
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

>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
@include('public.layouts.footer')

<script>
    window.addEventListener('load', () => {
        lucide.createIcons();
<<<<<<< HEAD
    });
</script>

=======
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in-view'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));
    });
</script>
>>>>>>> 2da0e63 (feat(galeri & tentang):memperbarui tampilan galeri dan tentang)
</body>
</html>