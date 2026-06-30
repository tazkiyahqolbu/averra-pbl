@php
$cats       = ['Semua', 'Jasa', 'Paket Acara', 'Sewa Barang'];
$currentCat = request('category', 'Semua');
$search     = request('search', '');
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Layanan & Koleksi — SILART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30">

    @include('public.layouts.navbar')

    {{-- ══ HEADER ══ --}}
    <section class="relative pt-36 pb-14 overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#FAF3E0] to-[#EDE0C2]"></div>
        <div class="absolute inset-0 -z-10 opacity-[0.05]" aria-hidden="true">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="kat-geo" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                        <path d="M40 3 L77 40 L40 77 L3 40 Z" fill="none" stroke="#7B1C2E" stroke-width="1"/>
                        <circle cx="40" cy="40" r="1.5" fill="#7B1C2E"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#kat-geo)"/>
            </svg>
        </div>

        <div class="relative mx-auto max-w-3xl px-6 text-center">
            <p class="text-xs tracking-[0.45em] text-[#7B1C2E] uppercase font-semibold">— PRICE LIST & KATALOG —</p>
            <h1 class="mt-3 font-serif text-4xl font-light text-[#4A0F1A] sm:text-6xl">
                Koleksi & <em class="text-[#C8A84B] not-italic">Paket Layanan</em>
            </h1>
            <div class="mx-auto mt-4 h-[1px] w-28 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
        </div>
    </section>

    {{-- ══ SEARCH + FILTER ══ --}}
    <section class="py-8 bg-[#FAF3E0]">
        <div class="mx-auto max-w-3xl px-6 space-y-5">

            {{-- Search bar compact --}}
            <form method="GET" action="{{ route('public.katalog.index') }}"
                  class="flex items-center gap-0 rounded-full border border-[#E2D4C0] bg-[#FFFDF7] shadow-sm overflow-hidden focus-within:border-[#C8A84B]/60 transition">
                <input type="hidden" name="category" value="{{ $currentCat === 'Semua' ? '' : $currentCat }}">
                <div class="pl-4 shrink-0 text-[#C8A84B]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari layanan atau koleksi…"
                       class="flex-1 px-3 py-3 text-sm bg-transparent text-[#4A0F1A] placeholder-[#4A0F1A]/35 focus:outline-none">
                @if($search)
                    <a href="{{ route('public.katalog.index', ['category' => $currentCat === 'Semua' ? null : $currentCat]) }}"
                       class="mr-1 grid h-7 w-7 place-items-center rounded-full text-[#4A0F1A]/40 hover:text-[#4A0F1A] transition">
                        <i data-lucide="x" class="h-3.5 w-3.5"></i>
                    </a>
                @endif
                <button type="submit"
                        class="m-1.5 rounded-full bg-[#4A0F1A] px-5 py-2 text-xs font-semibold text-[#FAF3E0] hover:bg-[#7B1C2E] transition shrink-0">
                    Cari
                </button>
            </form>

            {{-- Filter kategori + sort dalam satu baris --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap gap-2">
                    @foreach ($cats as $c)
                        <a href="{{ route('public.katalog.index', array_merge(request()->only(['search', 'sort']), ['category' => $c === 'Semua' ? null : $c])) }}"
                           class="rounded-full px-4 py-1.5 text-sm font-medium transition-all duration-200
                               {{ $currentCat === $c
                                   ? 'bg-[#4A0F1A] text-[#FAF3E0] shadow-sm'
                                   : 'border border-[#E2D4C0] text-[#4A0F1A] hover:border-[#C8A84B]/50 hover:bg-[#C8A84B]/8' }}">
                            {{ $c }}
                        </a>
                    @endforeach
                </div>

                {{-- Sort --}}
                <form id="sort-form" method="GET" action="{{ route('public.katalog.index') }}">
                    <input type="hidden" name="category" value="{{ $currentCat === 'Semua' ? '' : $currentCat }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="sort" onchange="this.form.submit()"
                            class="rounded-full border border-[#E2D4C0] bg-[#FFFDF7] px-4 py-1.5 text-sm text-[#4A0F1A] focus:outline-none focus:border-[#C8A84B]/50 cursor-pointer">
                        <option value="terbaru"  {{ ($sort ?? 'terbaru') === 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ ($sort ?? '') === 'termurah' ? 'selected' : '' }}>Termurah</option>
                        <option value="termahal" {{ ($sort ?? '') === 'termahal' ? 'selected' : '' }}>Termahal</option>
                    </select>
                </form>
            </div>

        </div>
    </section>

    {{-- ══ GRID PRODUK ══ --}}
    <section id="product-section" class="pb-20 bg-[#FAF3E0]">
        <div class="mx-auto max-w-6xl px-6">

            @php
                $items = $katalogs ?? $items ?? collect();
                $items = $items
                    ->filter(fn($i) => $i)
                    ->unique(fn($i) => ($i->category ?? '') . '|' . ($i->name ?? ''))
                    ->values()
                    ->map(function ($i) {
                        $name = strtolower($i->name ?? '');
                        if (str_contains($name, 'paket wedding organizer')) $i->category = 'Jasa';
                        if (str_contains($name, 'bludru') || str_contains($name, 'manik') || str_contains($name, 'alat musik tradisional')) {
                            $i->category = 'Sewa Barang';
                        }
                        return $i;
                    });
            @endphp

            @if($items->isEmpty())
                <div class="py-24 text-center scroll-fade">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#E2D4C0]/50 text-[#C8A84B]">
                        <i data-lucide="search-x" class="h-7 w-7"></i>
                    </div>
                    <p class="font-serif text-xl text-[#4A0F1A]">Tidak ada item ditemukan</p>
                    <p class="mt-1 text-sm text-[#4A2E28]">Coba ubah kata kunci atau pilih kategori lain.</p>
                </div>
            @else
                <div class="grid gap-4 grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($items as $item)
                        <article class="group flex flex-col overflow-hidden rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] shadow-sm transition-all duration-300 hover:scale-[1.025] hover:border-[#C8A84B]/50 hover:shadow-xl scroll-fade scroll-delay-{{ min($loop->index % 4 + 1, 4) }}">

                            {{-- Gambar --}}
                            <a href="{{ route('katalog.show', $item->id) }}"
                               class="relative block aspect-[3/4] overflow-hidden bg-[#EDE0C2]">
                                <img src="{{ asset($item->img) }}" alt="{{ $item->name }}" loading="lazy"
                                     class="h-full w-full object-cover">

                                {{-- Badge status --}}
                                <span class="absolute right-3 top-3 rounded-full px-2.5 py-1 text-[10px] font-semibold
                                    {{ $item->available
                                        ? 'bg-green-50 text-green-700 border border-green-200'
                                        : 'bg-red-50 text-red-600 border border-red-200' }}">
                                    {{ $item->available ? 'Tersedia' : 'Penuh' }}
                                </span>

                                {{-- Category chip --}}
                                <span class="absolute left-3 top-3 rounded-full bg-[#4A0F1A]/80 px-2.5 py-1 text-[10px] font-semibold tracking-wide text-[#FAF3E0] backdrop-blur-sm">
                                    {{ $item->category }}
                                </span>
                            </a>

                            {{-- Konten --}}
                            <div class="flex flex-1 flex-col p-4">
                                <a href="{{ route('katalog.show', $item->id) }}" class="hover:text-[#C8A84B] transition-colors">
                                    <h3 class="font-serif text-lg font-medium text-[#4A0F1A] leading-snug">{{ $item->name }}</h3>
                                </a>

                                {{-- Rating --}}
                                @php $rating = $item->rating ?? 4.5; $ulasan = $item->ulasan ?? 0; @endphp
                                <div class="mt-1.5 flex items-center gap-1 text-[#C8A84B]">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i data-lucide="star" class="h-3 w-3 {{ $s <= floor($rating) ? 'fill-current' : 'opacity-25' }}"></i>
                                    @endfor
                                    <span class="ml-1 text-[10px] text-[#4A2E28]">{{ number_format($rating, 1) }} ({{ $ulasan }})</span>
                                </div>

                                <p class="mt-2 text-xs leading-relaxed text-[#4A2E28] line-clamp-2 flex-1">{{ $item->desc }}</p>

                                {{-- Warna & bahan --}}
                                @if($item->category !== 'Paket Pernikahan' && $item->category !== 'Jasa' && isset($item->color) && $item->color !== '-')
                                    <div class="mt-2 flex flex-wrap gap-x-3 text-[10px] text-[#4A2E28] border-t border-[#E2D4C0] pt-2">
                                        <span><span class="font-semibold text-[#4A0F1A]">Warna:</span> {{ $item->color }}</span>
                                        @if(isset($item->material) && $item->material !== '-')
                                            <span><span class="font-semibold text-[#4A0F1A]">Bahan:</span> {{ $item->material }}</span>
                                        @endif
                                    </div>
                                @endif

                                {{-- Harga & tombol --}}
                                <div class="mt-4 flex items-end justify-between gap-2 border-t border-[#E2D4C0] pt-3">
                                    <div>
                                        @if(isset($item->price) && $item->price > 0)
                                            <p class="text-[10px] uppercase tracking-wider text-[#4A2E28]">
                                                {{ in_array($item->category, ['Kostum', 'Properti', 'Sewa Barang']) ? 'Sewa' : 'Mulai dari' }}
                                            </p>
                                            <p class="font-serif text-base font-semibold text-[#C8A84B]">
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                    <a href="{{ route('katalog.show', $item->id) }}"
                                       class="shrink-0 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-4 py-1.5 font-serif text-xs font-semibold text-[#4A0F1A] shadow-sm transition hover:scale-105">
                                        Detail
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    @include('public.layouts.footer')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('in-view'); observer.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));

        // Setelah load dengan filter aktif, scroll ke grid produk agar tidak kembali ke atas
        if (window.location.search) {
            const grid = document.getElementById('product-section');
            if (grid) {
                setTimeout(() => {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 80);
            }
        }
    </script>
</body>
</html>
