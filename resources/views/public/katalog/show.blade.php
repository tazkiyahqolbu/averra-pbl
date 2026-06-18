<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} — SILART</title>
    
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

<body class="min-h-screen bg-[#4A0F1A] text-cream antialiased">

    @include('public.layouts.navbar')

    <section class="pt-36 pb-20 bg-[#4A0F1A]">
        <div class="mx-auto max-w-5xl px-6">
            
            <a href="{{ route('public.katalog.index') }}" class="inline-flex items-center gap-2 text-sm text-gold-soft hover:text-gold transition-colors font-medium mb-8">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Katalog
            </a>

            <div class="grid gap-12 md:grid-cols-2 items-start">
                
                {{-- Frame Gambar + Galeri --}}
                <div class="space-y-4">
                    <div class="relative group p-3 rounded-2xl border border-gold/20 bg-[#31070F] shadow-2xl">
                        <div class="relative aspect-[3/4] overflow-hidden rounded-xl bg-neutral-900 border border-gold/10">
                            <img src="{{ asset($item->img) }}" alt="{{ $item->name }}" class="w-full h-full object-cover" />
                            <span class="absolute top-4 right-4 rounded-full px-4 py-1.5 text-xs font-semibold bg-emerald-950/90 text-emerald-300 border border-emerald-500/30">
                                {{ $item->available ? 'Tersedia' : 'Penuh' }}
                            </span>
                        </div>
                    </div>

                </div>

                {{-- Detail Info --}}
                <div class="rounded-2xl border border-gold/20 bg-[#31070F] text-cream p-6 md:p-8 shadow-xl space-y-6">
                    <div>
                        <span class="text-xs tracking-[0.2em] text-gold uppercase font-bold block mb-1">— {{ $item->category }} —</span>
                        <h1 class="font-serif text-3xl md:text-4xl font-light text-cream leading-tight">{{ $item->name }}</h1>
                        <div class="h-[1px] bg-gradient-to-r from-gold via-gold/40 to-transparent mt-3 w-24"></div>
                    </div>

                    {{-- Rating Bintang sesuai spek --}}
                    @php
                        $rating = $item->rating ?? 4.8;
                        $ulasan = $item->ulasan ?? 0;
                    @endphp
                    <div class="flex items-center gap-2 text-yellow-400">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($rating))
                                <i data-lucide="star" class="h-4 w-4 fill-current"></i>
                            @else
                                <i data-lucide="star" class="h-4 w-4 opacity-30"></i>
                            @endif
                        @endfor
                        <span class="text-cream/60 text-sm ml-1">{{ number_format($rating, 1) }} ({{ $ulasan }} ulasan)</span>
                    </div>

                    @if(isset($item->price) && $item->price > 0)
                        <div class="p-4 rounded-xl border border-gold/20 bg-maroon-deep">
                            <span class="text-[10px] text-gold-soft uppercase tracking-wider font-bold block">
                                {{ $item->category === 'Sewa Barang' || $item->category === 'Properti' ? 'Harga Sewa' : 'Harga' }}
                            </span>
                            <span class="text-3xl font-serif text-gold font-semibold">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                            @if($item->category === 'Properti' || $item->category === 'Sewa Barang' || $item->category === 'Kostum')
                                <span class="text-xs text-cream/60 ml-2">/ hari</span>
                            @endif
                        </div>
                    @endif

                    @if($item->category !== 'Paket Pernikahan')
                        <div class="border-t border-b border-gold/10 py-3 space-y-2 text-sm font-light text-cream/80">
                            <div class="flex"><span class="w-24 text-gold-soft font-medium">ID Item:</span><span class="font-mono">{{ $item->id }}</span></div>
                            <div class="flex"><span class="w-24 text-gold-soft font-medium">Warna:</span><span>{{ $item->color ?? '-' }}</span></div>
                            <div class="flex"><span class="w-24 text-gold-soft font-medium">Bahan:</span><span>{{ $item->material ?? '-' }}</span></div>
                            @if($item->category === 'Properti' || $item->category === 'Sewa Barang' || $item->category === 'Kostum')
                                <div class="flex"><span class="w-24 text-gold-soft font-medium">Stok:</span><span class="text-emerald-400">Tersedia {{ $item->stok ?? 'beberapa' }} unit</span></div>
                            @endif
                        </div>
                    @endif

                    <div class="space-y-2">
                        <h4 class="font-serif text-lg text-gold font-medium flex items-center gap-2">
                            <i data-lucide="sparkles" class="h-4 w-4"></i>
                            {{ $item->category === 'Paket Pernikahan' ? 'Rincian & Fasilitas Acara' : 'Deskripsi Koleksi' }}
                        </h4>

                        @php
                            // Untuk sewa baju tari: tampilkan pilihan warna sebagai chip kecil.
                            $isSewaTari = $item->category === 'Sewa Barang' && (
                                Str::contains(Str::lower($item->name ?? ''), 'bludru') ||
                                Str::contains(Str::lower($item->name ?? ''), 'manik')
                            );

                            $colors = [];
                            if ($isSewaTari && !empty($item->color) && $item->color !== '-') {
                                $colors = array_values(array_filter(array_map('trim', explode(',', $item->color))));
                            }

                            // Desc tampil normal (tanpa “include” tetap ada di desc).
                            $descText = $item->desc ?? '';
                        @endphp

                        @if($isSewaTari && count($colors) > 0)
                            <div class="bg-maroon-deep/50 p-4 rounded-xl border border-gold/5">
                                <div class="text-xs tracking-[0.2em] text-gold uppercase font-bold mb-2">Pilihan Warna</div>

                                <div class="flex flex-wrap gap-2" id="warna-chip-wrap">
                                    @foreach($colors as $c)
                                        <button type="button"
                                                class="warna-chip px-3 py-1 rounded-full text-xs border border-gold/20 bg-[#31070F] hover:border-gold/50 hover:shadow transition"
                                                data-value="{{ $c }}"
                                                onclick="
                                                    // Hanya boleh pilih 1 warna: reset semua lalu aktifkan yang dipencet
                                                    document.querySelectorAll('.warna-chip').forEach(el => el.style.borderColor = '#C8A84B00');
                                                    this.style.borderColor = '#C8A84B';
                                                ">
                                            <span class="font-medium">{{ $c }}</span>
                                        </button>
                                    @endforeach
                                </div>

                              

                        @else

                            <p class="text-sm text-cream/80 leading-relaxed font-light whitespace-pre-line bg-maroon-deep/50 p-4 rounded-xl border border-gold/5">{{ $item->desc }}</p>
                        @endif
                    </div>

                    {{-- Ketersediaan --}}
                    @if($item->category === 'Paket Pernikahan')
                        <div class="p-3 rounded-xl bg-maroon-deep/70 border border-gold/10 text-xs text-cream/70">
                            <span class="text-gold-soft font-medium">Maks. booking per hari:</span> 2 slot
                        </div>
                    @endif

                    <div class="pt-4 border-t border-gold/10">
                        @if($item->available)
                            <a href="{{ route('user.pemesanan.create', ['item' => $item->id]) }}" class="w-full text-center rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3 px-6 font-serif text-base text-maroon-deep font-semibold shadow-lg transition duration-300 hover:scale-[1.02] transform inline-block">
                                {{ $item->category === 'Sewa Barang' || $item->category === 'Properti' ? 'Sewa Sekarang' : 'Pesan Paket' }}
                            </a>
                        @else
                            <button disabled class="w-full text-center rounded-full bg-neutral-800 text-neutral-400 py-3 px-6 font-serif text-base font-semibold border border-neutral-700 cursor-not-allowed">
                                Jadwal Terbooking (Penuh)
                            </button>
                        @endif
                    </div>

                </div>
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
