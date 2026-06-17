@php
// Kategori sesuai dokumen AVERRA: Semua, Jasa, Paket Acara, Sewa Barang
$cats = ['Semua', 'Jasa', 'Paket Acara', 'Sewa Barang'];
$currentCat = request('category', 'Semua');
$search = request('search', '');
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Layanan & Koleksi — SILART</title>
    
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
                        background: '#4A0F1A',
                        foreground: '#FAF3E0',
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

<body class="min-h-screen bg-[#4A0F1A] text-cream antialiased selection:bg-gold/30">

    @include('public.layouts.navbar')

    {{-- Hero Section --}}
    <section class="relative isolate flex pt-36 pb-12 items-center justify-center overflow-hidden bg-[#4A0F1A]">
        <div class="absolute inset-0 opacity-[0.04] bg-cover bg-center" style="background-image: url('{{ asset('image/background.png') }}'); filter: grayscale(100%);"></div>
        <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">
            <p class="text-xs tracking-[0.4em] text-gold uppercase font-bold">— PRICE LIST & KATALOG —</p>
            <h1 class="mt-3 font-serif text-4xl sm:text-6xl font-light text-cream">
                Koleksi & <em class="text-gold not-italic">Paket Layanan</em>
            </h1>
            <div class="h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mt-4 w-32"></div>
        </div>
    </section>

    {{-- Search & Filter sesuai dokumen AVERRA --}}
    <section class="py-6 bg-[#4A0F1A] border-b border-gold/10 z-20">
        <div class="mx-auto max-w-7xl px-6 space-y-4">
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('public.katalog.index') }}" class="flex gap-3">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="🔍 Cari nama layanan/barang..." 
                       class="flex-1 rounded-full px-5 py-2.5 text-sm bg-[#31070F] border border-gold/20 text-cream placeholder-cream/40 focus:outline-none focus:border-gold/60">
                <input type="hidden" name="category" value="{{ $currentCat }}">
                <button type="submit" class="rounded-full bg-gold px-6 py-2.5 text-xs font-semibold text-maroon-deep hover:bg-gold-soft transition">Cari</button>
            </form>

            {{-- Filter Kategori --}}
            <div class="flex flex-wrap gap-3 justify-center">
                @foreach ($cats as $c)
                    <a href="{{ route('public.katalog.index', array_merge(request()->only(['search', 'sort']), ['category' => $c === 'Semua' ? null : $c])) }}"
                       class="rounded-full px-6 py-2 text-sm sm:text-base transition-all duration-300 border text-center min-w-[100px] font-serif tracking-wide
                       {{ $currentCat === $c 
                           ? 'bg-gold text-maroon-deep border-gold shadow-lg font-semibold' 
                           : 'bg-[#7B1C2E] border-gold/20 text-cream/90 hover:border-gold/50' }}">
                        {{ $c }}
                    </a>
                @endforeach
            </div>

            {{-- Filter Tambahan: Kategori & Urutkan --}}
            <div class="flex flex-wrap items-center justify-center gap-4 text-sm">
                <select name="sort" form="sort-form" class="rounded-full px-4 py-2 bg-[#31070F] border border-gold/20 text-cream/80 focus:outline-none focus:border-gold/60" onchange="this.form.submit()">
                    <option value="terbaru" {{ ($sort ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                    <option value="termurah" {{ ($sort ?? '') === 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ ($sort ?? '') === 'termahal' ? 'selected' : '' }}>Termahal</option>
                </select>
            </div>
            <form id="sort-form" method="GET" action="{{ route('public.katalog.index') }}" class="hidden">
                <input type="hidden" name="category" value="{{ $currentCat }}">
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
            </form>
        </div>
    </section>

    {{-- Grid Produk & Paket --}}
    <section class="py-12 bg-[#4A0F1A]">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @php
                    $items = $katalogs ?? $items ?? collect();

                    $items = $items
                        ->filter(fn($i) => $i)
                        ->unique(fn($i) => ($i->category ?? '') . '|' . ($i->name ?? ''))
                        ->values();

                    $items = $items->map(function ($i) {
                        $name = strtolower($i->name ?? '');

                        if (str_contains($name, 'paket wedding organizer')) {
                            $i->category = 'Jasa';
                        }

                        $isSewaBarang = str_contains($name, 'bludru')
                            || str_contains($name, 'manik')
                            || str_contains($name, 'alat musik tradisional');

                        // Pastikan item sewa barang benar masuk tab “Sewa Barang”.
                        if ($isSewaBarang) {
                            $i->category = 'Sewa Barang';
                        }


                        return $i;
                    });
                @endphp

                @forelse ($items as $item)

                    <article class="group relative rounded-2xl overflow-hidden border border-gold/20 bg-[#31070F] text-cream p-4 shadow-2xl transition-all duration-300 hover:-translate-y-1 hover:border-gold/40 flex flex-col justify-between">
                        
                        <div>
                            {{-- Container Gambar --}}
                            <a href="{{ route('katalog.show', $item->id) }}" class="block relative aspect-[3/4] overflow-hidden rounded-xl bg-neutral-900 border border-gold/10">
                                <img src="{{ asset($item->img) }}" alt="{{ $item->name }}" loading="lazy" 
                                     class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />
                                
                                <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-medium bg-emerald-950/80 text-emerald-300 border border-emerald-500/30">
                                    {{ $item->available ? 'Tersedia' : 'Penuh' }}
                                </span>
                            </a>

                        {{-- Keterangan Teks --}}
                            <div class="pt-4 pb-2">
                                <span class="text-[10px] uppercase tracking-[0.2em] text-gold font-bold block mb-1">{{ $item->category }}</span>
                                <a href="{{ route('katalog.show', $item->id) }}" class="hover:text-gold transition-colors">
                                    <h3 class="font-serif text-xl sm:text-2xl text-gold-soft leading-tight font-medium">{{ $item->name }}</h3>
                                </a>
                                {{-- Rating Bintang sesuai spec AVERRA --}}
                                @php
                                    $rating = $item->rating ?? 4.5;
                                    $ulasan = $item->ulasan ?? 0;
                                @endphp
                                <div class="flex items-center gap-1 mt-1 text-yellow-400 text-xs">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($rating))
                                            <i data-lucide="star" class="h-3 w-3 fill-current"></i>
                                        @elseif ($i - 0.5 <= $rating)
                                            <span class="text-xs">★</span>
                                        @else
                                            <i data-lucide="star" class="h-3 w-3 opacity-30"></i>
                                        @endif
                                    @endfor
                                    <span class="text-cream/60 ml-1 font-sans text-[10px]">{{ number_format($rating, 1) }} ({{ $ulasan }} ulasan)</span>
                                </div>
                                <p class="mt-2 text-xs text-cream/70 font-light line-clamp-3 leading-relaxed">{{ $item->desc }}</p>
                                
                                {{-- Atribut Kostum / Properti --}}
                                @if($item->category !== 'Paket Pernikahan' && $item->category !== 'Jasa' && ($item->color !== '-' || $item->material !== '-'))
                                    <div class="mt-3 text-[11px] text-cream/60 space-y-0.5 border-t border-gold/10 pt-2 font-light">
                                        <p><span class="text-gold-soft/80">Warna:</span> {{ $item->color }}</p>
                                        <p><span class="text-gold-soft/80">Bahan:</span> {{ $item->material }}</p>

                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Bagian Harga & Tombol Detail --}}
                        <div class="mt-4 pt-3 border-t border-gold/10">
                            {{-- Menampilkan Harga untuk semua item yang memiliki tarif di atas Rp0 --}}
                            @if(isset($item->price) && $item->price > 0)
                                <div class="mb-3">
                                    <span class="text-[10px] text-cream/50 block uppercase tracking-wider">
                                        {{ $item->category === 'Kostum' || $item->category === 'Properti' ? 'Harga Sewa' : 'Harga Paket' }}
                                    </span>
                                    <span class="text-lg font-serif text-gold font-semibold">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif

                            <a href="{{ route('katalog.show', $item->id) }}" class="w-full text-center rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-2 px-4 font-serif text-sm text-maroon-deep font-semibold shadow-md transition duration-300 hover:scale-[1.02] transform inline-block">
                                Lihat Detail
                            </a>
                        </div>

                    </article>
                @empty
                    <div class="col-span-full text-center py-16 text-cream/60 font-serif text-xl">
                        Belum ada item atau paket pada kategori ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('public.layouts.footer')

    <script>
        window.addEventListener('load', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
