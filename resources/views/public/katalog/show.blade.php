<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30">

    @include('public.layouts.navbar')

    <div class="mx-auto max-w-6xl px-6 pt-32 pb-8">

        {{-- Breadcrumb --}}
        <div class="mb-8 flex items-center gap-2 text-sm scroll-fade">
            <a href="{{ route('public.katalog.index') }}"
               class="inline-flex items-center gap-1.5 text-[#C8A84B] hover:text-[#B8983A] font-medium transition">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Katalog
            </a>
            <span class="text-[#4A2E28]/40">/</span>
            <span class="text-[#4A2E28]">{{ $item->category }}</span>
            <span class="text-[#4A2E28]/40">/</span>
            <span class="text-[#4A0F1A] font-medium truncate max-w-[200px]">{{ $item->name }}</span>
        </div>

        {{-- ══ MAIN GRID ══ --}}
        @php
            // Bangun array URL slide untuk slider Alpine
            $thumbUrl  = $item->img;
            $extraUrls = $fotos->map(fn($f) => $f->foto_url)->values()->all();
            $slideUrls = count($extraUrls) > 0
                ? array_values(array_unique(array_merge([$thumbUrl], $extraUrls)))
                : [$thumbUrl];
            $isMulti   = count($slideUrls) > 1;
        @endphp

        <div class="grid gap-10 lg:grid-cols-[1fr_1.1fr] items-start">

            {{-- ── KIRI: Gambar / Slider ── --}}
            <div x-data="{ cur: 0, slides: @js($slideUrls) }" class="scroll-fade scroll-delay-1">

                {{-- Panel gambar utama --}}
                <div class="relative rounded-2xl card-fade-border shadow-lg bg-[#EDE0C2] overflow-hidden"
                     style="aspect-ratio: 3/4;">

                    {{-- Gambar aktif --}}
                    <img x-bind:src="slides[cur]" alt="{{ $item->name }}"
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300">

                    {{-- Badge status --}}
                    <span class="absolute right-4 top-4 rounded-full px-3 py-1.5 text-xs font-semibold shadow-sm
                        {{ $item->available
                            ? 'bg-green-50 text-green-700 border border-green-200'
                            : 'bg-red-50 text-red-600 border border-red-200' }}">
                        {{ $item->available ? '● Tersedia' : '● Penuh' }}
                    </span>

                    {{-- Badge kategori --}}
                    <span class="absolute left-4 top-4 rounded-full bg-[#4A0F1A]/75 px-3 py-1.5 text-[11px] font-semibold tracking-wide text-[#FAF3E0] backdrop-blur-sm">
                        {{ $item->category }}
                    </span>

                    @if($isMulti)
                        {{-- Tombol Prev --}}
                        <button x-on:click="cur = (cur - 1 + slides.length) % slides.length"
                                class="absolute left-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur-sm hover:bg-black/50 transition z-10">
                            <i data-lucide="chevron-left" class="h-5 w-5"></i>
                        </button>
                        {{-- Tombol Next --}}
                        <button x-on:click="cur = (cur + 1) % slides.length"
                                class="absolute right-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur-sm hover:bg-black/50 transition z-10">
                            <i data-lucide="chevron-right" class="h-5 w-5"></i>
                        </button>
                        {{-- Dot indicators --}}
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                            <template x-for="(_, i) in slides" x-bind:key="i">
                                <button x-on:click="cur = i"
                                        x-bind:class="cur === i ? 'w-5 bg-white' : 'w-2 bg-white/50'"
                                        class="h-2 rounded-full transition-all duration-300"></button>
                            </template>
                        </div>
                        {{-- Counter --}}
                        <div class="absolute right-4 bottom-4 rounded-full bg-black/40 px-2.5 py-1 text-[10px] font-medium text-white backdrop-blur-sm z-10">
                            <span x-text="cur + 1"></span>/<span x-text="slides.length"></span>
                        </div>
                    @endif
                </div>

                {{-- Strip thumbnail (Shopee style) --}}
                @if($isMulti)
                    <div class="mt-3 flex gap-2 overflow-x-auto pb-1 hide-scrollbar">
                        <template x-for="(foto, i) in slides" x-bind:key="i">
                            <button x-on:click="cur = i"
                                    x-bind:class="cur === i
                                        ? 'ring-2 ring-[#C8A84B] border-[#C8A84B] opacity-100'
                                        : 'border-[#E2D4C0]/30 opacity-55 hover:opacity-90'"
                                    class="shrink-0 h-[72px] w-[72px] overflow-hidden rounded-xl border-2 transition-all duration-200">
                                <img x-bind:src="foto" class="h-full w-full object-cover">
                            </button>
                        </template>
                    </div>
                @endif

                {{-- Trust badges --}}
                <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-xl card-fade-border bg-[#FFFDF7] py-3 px-2">
                        <i data-lucide="shield-check" class="mx-auto h-5 w-5 text-[#C8A84B]"></i>
                        <p class="mt-1 text-[10px] font-medium text-[#4A2E28]">Terverifikasi</p>
                    </div>
                    <div class="rounded-xl card-fade-border bg-[#FFFDF7] py-3 px-2">
                        <i data-lucide="clock" class="mx-auto h-5 w-5 text-[#C8A84B]"></i>
                        <p class="mt-1 text-[10px] font-medium text-[#4A2E28]">Respons Cepat</p>
                    </div>
                    <div class="rounded-xl card-fade-border bg-[#FFFDF7] py-3 px-2">
                        <i data-lucide="award" class="mx-auto h-5 w-5 text-[#C8A84B]"></i>
                        <p class="mt-1 text-[10px] font-medium text-[#4A2E28]">Top Rated</p>
                    </div>
                </div>

            </div>{{-- end kiri --}}

            {{-- ── KANAN: Detail ── --}}
            <div class="space-y-5 scroll-fade scroll-delay-2">

                {{-- Nama & kategori --}}
                <div>
                    <p class="text-xs tracking-[0.3em] text-[#C8A84B] uppercase font-semibold">
                        — {{ $item->category }} —
                    </p>
                    <h1 class="mt-1 font-serif text-3xl font-light text-[#4A0F1A] leading-tight md:text-4xl">
                        {{ $item->name }}
                    </h1>
                    <div class="mt-3 h-[1px] w-20 bg-gradient-to-r from-[#C8A84B] to-transparent"></div>
                </div>

                {{-- Rating --}}
                @php
                    $rating = $item->rating ?? 4.8;
                    $ulasan = $item->ulasan ?? 0;
                @endphp
                <div class="flex items-center gap-1.5">
                    @for ($s = 1; $s <= 5; $s++)
                        <i data-lucide="star"
                           class="h-4 w-4 text-[#C8A84B] {{ $s <= floor($rating) ? 'fill-current' : 'opacity-25' }}"></i>
                    @endfor
                    <span class="ml-1 text-sm font-semibold text-[#4A0F1A]">{{ number_format($rating, 1) }}</span>
                    <span class="text-sm text-[#4A2E28]">
                        ({{ $ulasan > 0 ? $ulasan . ' ulasan' : 'Belum ada ulasan' }})
                    </span>
                    @if($ulasan > 0)
                        <a href="#ulasan" class="ml-1 text-xs text-[#C8A84B] underline underline-offset-2 hover:text-[#B8983A] transition">
                            Lihat semua
                        </a>
                    @endif
                </div>

                {{-- Harga --}}
                @if(isset($item->price) && $item->price > 0)
                    <div class="rounded-2xl card-fade-border bg-[#FFFDF7] px-5 py-4">
                        <p class="text-[10px] uppercase tracking-widest text-[#4A2E28] font-medium">
                            {{ in_array($item->category, ['Sewa Barang', 'Properti', 'Kostum']) ? 'Harga Sewa' : 'Harga Paket' }}
                        </p>
                        <div class="mt-1 flex items-end gap-2">
                            <span class="font-serif text-3xl font-semibold text-[#C8A84B]">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </span>
                            @if(in_array($item->category, ['Sewa Barang', 'Properti', 'Kostum']))
                                <span class="mb-1 text-sm text-[#4A2E28]">/ hari</span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Spesifikasi (tanpa ID Item) --}}
                @if($item->category !== 'Paket Pernikahan')
                    @php
                        $showSpecs = ($item->color && $item->color !== '-')
                            || ($item->material && $item->material !== '-')
                            || in_array($item->category, ['Sewa Barang', 'Properti', 'Kostum']);
                    @endphp
                    @if($showSpecs)
                        <div class="rounded-2xl card-fade-border bg-[#FFFDF7] divide-y divide-[#E2D4C0] overflow-hidden">
                            @if(isset($item->color) && $item->color && $item->color !== '-')
                                <div class="flex items-center px-5 py-3 text-sm">
                                    <span class="w-28 shrink-0 font-semibold text-[#4A0F1A]">Warna</span>
                                    <span class="text-[#4A2E28]">{{ $item->color }}</span>
                                </div>
                            @endif
                            @if(isset($item->material) && $item->material && $item->material !== '-')
                                <div class="flex items-center px-5 py-3 text-sm">
                                    <span class="w-28 shrink-0 font-semibold text-[#4A0F1A]">Bahan</span>
                                    <span class="text-[#4A2E28]">{{ $item->material }}</span>
                                </div>
                            @endif
                            @if(in_array($item->category, ['Sewa Barang', 'Properti', 'Kostum']))
                                <div class="flex items-center px-5 py-3 text-sm">
                                    <span class="w-28 shrink-0 font-semibold text-[#4A0F1A]">Stok</span>
                                    <span class="font-semibold text-green-700">
                                        Tersedia {{ $item->stok ?? 'beberapa' }} unit
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif

                {{-- Pilihan warna (khusus sewa tari) --}}
                @php
                    $isSewaTari = $item->category === 'Sewa Barang' && (
                        Str::contains(Str::lower($item->name ?? ''), 'bludru') ||
                        Str::contains(Str::lower($item->name ?? ''), 'manik')
                    );
                    $colors = [];
                    if ($isSewaTari && !empty($item->color) && $item->color !== '-') {
                        $colors = array_values(array_filter(array_map('trim', explode(',', $item->color))));
                    }
                @endphp

                @if($isSewaTari && count($colors) > 0)
                    <div class="rounded-2xl card-fade-border bg-[#FFFDF7] p-5">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.2em] text-[#4A0F1A]">Pilih Warna</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colors as $c)
                                <button type="button"
                                        class="warna-chip rounded-full card-fade-border px-4 py-1.5 text-xs font-medium text-[#4A0F1A] transition hover:border-[#C8A84B] hover:bg-[#C8A84B]/10"
                                        onclick="document.querySelectorAll('.warna-chip').forEach(el => { el.classList.remove('border-[#C8A84B]','bg-[#C8A84B]/10','font-semibold'); }); this.classList.add('border-[#C8A84B]','bg-[#C8A84B]/10','font-semibold')">
                                    {{ $c }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div class="rounded-2xl card-fade-border bg-[#FFFDF7] p-5">
                    <h4 class="mb-3 flex items-center gap-2 font-serif text-base font-medium text-[#4A0F1A]">
                        <i data-lucide="sparkles" class="h-4 w-4 text-[#C8A84B]"></i>
                        {{ $item->category === 'Paket Pernikahan' ? 'Rincian & Fasilitas' : 'Deskripsi' }}
                    </h4>
                    <p class="text-sm leading-relaxed text-[#4A2E28] whitespace-pre-line">{{ $item->desc }}</p>

                    @if($item->category === 'Paket Pernikahan')
                        <div class="mt-4 rounded-xl card-fade-border bg-[#FAF3E0] px-4 py-3 text-xs text-[#4A2E28]">
                            <span class="font-semibold text-[#4A0F1A]">Maks. booking per hari:</span> 2 slot
                        </div>
                    @endif
                </div>

                {{-- Daftar Item Paket --}}
                @if($item->type === 'paket' && isset($item->details) && $item->details->isNotEmpty())
                    @php
                        $itemWajib     = $item->details->where('tipe', 'wajib');
                        $itemOpsional  = $item->details->where('tipe', 'opsional');
                    @endphp
                    <div class="rounded-2xl card-fade-border bg-[#FFFDF7] p-5 space-y-4">
                        <h4 class="flex items-center gap-2 font-serif text-base font-medium text-[#4A0F1A]">
                            <i data-lucide="package-check" class="h-4 w-4 text-[#C8A84B]"></i>
                            Sudah Termasuk dalam Paket
                        </h4>
                        <ul class="space-y-2">
                            @foreach($itemWajib as $detail)
                                <li class="flex items-center gap-3 text-sm text-[#4A2E28]">
                                    <i data-lucide="check-circle" class="h-4 w-4 shrink-0 text-[#C8A84B]"></i>
                                    <span>
                                        {{ $detail->nama_item ?? $detail->jasa?->nama_jasa ?? '-' }}
                                        @if($detail->jumlah > 1)
                                            <span class="text-[#4A2E28]/60">× {{ $detail->jumlah }} orang</span>
                                        @endif
                                    </span>
                                    @if($detail->keterangan)
                                        <span class="text-xs text-[#4A2E28]/50 italic">— {{ $detail->keterangan }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        @if($itemOpsional->isNotEmpty())
                            <div class="border-t border-[#E2D4C0]/30 pt-4">
                                <h5 class="mb-2 flex items-center gap-2 text-sm font-semibold text-[#4A0F1A]">
                                    <i data-lucide="plus-circle" class="h-4 w-4 text-[#C8A84B]"></i>
                                    Item Opsional (Biaya Tambahan)
                                </h5>
                                <ul class="space-y-2">
                                    @foreach($itemOpsional as $detail)
                                        <li class="flex items-center justify-between text-sm text-[#4A2E28]">
                                            <span class="flex items-center gap-3">
                                                <i data-lucide="circle-plus" class="h-4 w-4 shrink-0 text-[#4A2E28]/40"></i>
                                                {{ $detail->nama_item ?? $detail->jasa?->nama_jasa ?? '-' }}
                                                @if($detail->jumlah > 1)
                                                    <span class="text-[#4A2E28]/60">× {{ $detail->jumlah }}</span>
                                                @endif
                                            </span>
                                            @if($detail->harga_tambahan > 0)
                                                <span class="font-semibold text-[#C8A84B]">
                                                    +Rp{{ number_format($detail->harga_tambahan, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- CTA --}}
                <div class="pt-1">
                    @if($item->available)
                        @php
                            $pesanRoute = in_array($item->type, ['paket', 'jasa'])
                                ? route('user.pemesanan.create.acara', ['item' => $item->id])
                                : route('user.pemesanan.create.sewa', ['item' => $item->id]);
                            $labelPesan = in_array($item->category, ['Sewa Barang', 'Properti', 'Kostum']) ? 'Sewa Sekarang' : 'Pesan Paket Ini';
                        @endphp
                        @auth
                            @if(Auth::user()->hasRole('admin'))
                                <button type="button" onclick="document.getElementById('modal-admin-only').classList.remove('hidden')"
                                        class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3.5 px-6 font-serif text-base font-semibold text-[#4A0F1A] shadow-md transition duration-300 hover:scale-[1.02] hover:shadow-lg">
                                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                                    {{ $labelPesan }}
                                </button>
                            @else
                                <a href="{{ $pesanRoute }}"
                                   class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3.5 px-6 font-serif text-base font-semibold text-[#4A0F1A] shadow-md transition duration-300 hover:scale-[1.02] hover:shadow-lg">
                                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                                    {{ $labelPesan }}
                                </a>
                            @endif
                        @else
                            <button type="button" onclick="document.getElementById('modal-login-required').classList.remove('hidden')"
                                    class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3.5 px-6 font-serif text-base font-semibold text-[#4A0F1A] shadow-md transition duration-300 hover:scale-[1.02] hover:shadow-lg">
                                <i data-lucide="calendar-check" class="h-4 w-4"></i>
                                {{ $labelPesan }}
                            </button>
                        @endauth
                        <p class="mt-2 text-center text-xs text-[#4A2E28]">
                            Konfirmasi dalam 1×24 jam setelah pemesanan
                        </p>
                    @else
                        <button disabled
                                class="w-full rounded-full card-fade-border bg-[#FFFDF7] py-3.5 px-6 font-serif text-base font-semibold text-[#4A2E28]/50 cursor-not-allowed">
                            Jadwal Terbooking — Penuh
                        </button>
                    @endif
                </div>

            </div>{{-- end kanan --}}
        </div>{{-- end main grid --}}

    </div>{{-- end max-w wrapper --}}

    {{-- ══ SECTION ULASAN ══ --}}
    <section id="ulasan" class="py-16 bg-[#FAF3E0]">
            <div class="mx-auto max-w-6xl px-6">

                {{-- Heading --}}
                <div class="mb-10 text-center scroll-fade">
                    <p class="text-xs tracking-[0.35em] text-[#C8A84B] uppercase font-semibold">— ULASAN PELANGGAN —</p>
                    <h2 class="mt-2 font-serif text-3xl font-light text-[#4A0F1A]">Apa Kata Mereka?</h2>
                    <div class="mx-auto mt-3 h-[1px] w-20 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
                </div>

                @php
                    $total = $testimonis->count();
                    $avg   = $total > 0 ? $testimonis->avg('rating') : 0;
                    $dist  = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                    foreach ($testimonis as $t) {
                        if (isset($dist[$t->rating])) $dist[$t->rating]++;
                    }
                @endphp

                @if($total > 0)

                    {{-- Ringkasan rating (Shopee style) --}}
                    <div class="mb-8 flex flex-col sm:flex-row items-center gap-8 rounded-2xl card-fade-border bg-[#FFFDF7] p-6 scroll-fade">
                        {{-- Angka besar --}}
                        <div class="text-center shrink-0">
                            <p class="font-serif text-7xl font-light leading-none text-[#4A0F1A]">{{ number_format($avg, 1) }}</p>
                            <div class="flex items-center justify-center gap-0.5 mt-2">
                                @for ($s = 1; $s <= 5; $s++)
                                    <i data-lucide="star"
                                       class="h-4 w-4 text-[#C8A84B] {{ $s <= round($avg) ? 'fill-current' : 'opacity-25' }}"></i>
                                @endfor
                            </div>
                            <p class="mt-1 text-xs text-[#4A2E28]">{{ $total }} ulasan</p>
                        </div>

                        {{-- Bar distribusi --}}
                        <div class="flex-1 w-full space-y-2.5">
                            @foreach ([5, 4, 3, 2, 1] as $star)
                                @php
                                    $count = $dist[$star] ?? 0;
                                    $pct   = $total > 0 ? round($count / $total * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="shrink-0 w-3 text-right text-[#4A2E28] font-medium">{{ $star }}</span>
                                    <i data-lucide="star" class="h-3 w-3 shrink-0 text-[#C8A84B] fill-current"></i>
                                    <div class="flex-1 h-2 rounded-full bg-[#E2D4C0] overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-[#D6B35C] to-[#C8A84B] transition-all duration-700"
                                             style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="shrink-0 w-8 text-[#4A2E28]">{{ $pct }}%</span>
                                    <span class="shrink-0 w-5 text-[#4A2E28]/60">({{ $count }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kartu ulasan individual --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($testimonis as $idx => $t)
                            @php
                                $namaUser    = $t->user->nama ?? $t->user->name ?? 'Pengguna';
                                $inisial     = strtoupper(substr($namaUser, 0, 1));
                                $panjang     = mb_strlen($namaUser);
                                $namaDisplay = $panjang <= 2
                                    ? $inisial . str_repeat('*', 2)
                                    : $inisial . str_repeat('*', max(2, $panjang - 2)) . strtoupper(substr($namaUser, -1));
                                $bgColors    = ['#4A0F1A', '#7B1C2E', '#3D0010', '#5C1420', '#2E0A12'];
                                $avatarBg    = $bgColors[$idx % count($bgColors)];
                                $hasFoto     = $t->fotos->isNotEmpty();
                            @endphp
                            <div class="rounded-2xl card-fade-border bg-[#FFFDF7] p-5 scroll-fade scroll-delay-{{ ($idx % 4) + 1 }} {{ $hasFoto ? 'cursor-pointer hover:shadow-md hover:border-[#C8A84B] transition-all duration-200' : '' }}"
                                 @if($hasFoto) onclick="bukaModalTestimoni({{ $t->id }})" @endif>
                                <div class="flex items-start gap-3">
                                    {{-- Avatar --}}
                                    <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-[#FAF3E0]"
                                         style="background-color: {{ $avatarBg }}">
                                        {{ $inisial }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        {{-- Nama + tanggal --}}
                                        <div class="flex items-start justify-between gap-2">
                                            <p class="text-sm font-semibold text-[#4A0F1A]">{{ $namaDisplay }}</p>
                                            <span class="shrink-0 text-[10px] text-[#4A2E28]/60 pt-0.5">
                                                {{ $t->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        {{-- Bintang --}}
                                        <div class="flex items-center gap-0.5 mt-1">
                                            @for ($s = 1; $s <= 5; $s++)
                                                <i data-lucide="star"
                                                   class="h-3 w-3 text-[#C8A84B] {{ $s <= $t->rating ? 'fill-current' : 'opacity-20' }}"></i>
                                            @endfor
                                            <span class="ml-1 text-[10px] text-[#4A2E28] font-medium">{{ $t->rating }}.0</span>
                                        </div>
                                        {{-- Isi testimoni --}}
                                        <p class="mt-2 text-sm leading-relaxed text-[#4A2E28]">{{ $t->isi_testimoni }}</p>
                                        {{-- Foto testimoni (thumbnail) --}}
                                        @if($hasFoto)
                                            <div class="mt-3 flex gap-2 flex-wrap">
                                                @foreach($t->fotos->take(3) as $foto)
                                                    <img src="{{ Storage::url($foto->foto_path) }}"
                                                         alt="foto testimoni"
                                                         class="h-16 w-16 rounded-lg object-cover card-fade-border">
                                                @endforeach
                                                @if($t->fotos->count() > 3)
                                                    <div class="h-16 w-16 rounded-lg bg-[#E2D4C0] flex items-center justify-center text-xs font-semibold text-[#4A0F1A]">
                                                        +{{ $t->fotos->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="mt-2 text-[10px] text-[#C8A84B] font-medium flex items-center gap-1">
                                                <i data-lucide="zoom-in" class="h-3 w-3"></i> Klik untuk perbesar
                                            </p>
                                        @endif
                                        {{-- Balasan admin --}}
                                        @if($t->dibalas)
                                            <div class="mt-3 rounded-xl card-fade-border bg-[#FAF3E0] px-4 py-3 text-xs text-[#4A2E28]">
                                                <p class="mb-1 flex items-center gap-1.5 font-semibold text-[#4A0F1A]">
                                                    <i data-lucide="reply" class="h-3 w-3 text-[#C8A84B]"></i>
                                                    Balasan Sanggar
                                                </p>
                                                {{ $t->dibalas }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Modal foto untuk testimoni ini --}}
                            @if($hasFoto)
                                <div id="modal-testimoni-{{ $t->id }}"
                                     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4"
                                     onclick="tutupModalTestimoni({{ $t->id }})">
                                    <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
                                        <button onclick="tutupModalTestimoni({{ $t->id }})"
                                                class="absolute top-3 right-3 text-[#4A2E28]/50 hover:text-[#4A0F1A]">
                                            <i data-lucide="x" class="h-5 w-5"></i>
                                        </button>
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="h-10 w-10 shrink-0 flex items-center justify-center rounded-full text-sm font-bold text-[#FAF3E0]"
                                                 style="background-color: {{ $avatarBg }}">{{ $inisial }}</div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#4A0F1A]">{{ $namaDisplay }}</p>
                                                <div class="flex items-center gap-0.5 mt-0.5">
                                                    @for ($s = 1; $s <= 5; $s++)
                                                        <i data-lucide="star" class="h-3 w-3 text-[#C8A84B] {{ $s <= $t->rating ? 'fill-current' : 'opacity-20' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-[#4A2E28] mb-4">{{ $t->isi_testimoni }}</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach($t->fotos as $foto)
                                                <img src="{{ Storage::url($foto->foto_path) }}"
                                                     alt="foto testimoni"
                                                     class="w-full rounded-xl object-cover card-fade-border">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <script>
                        function bukaModalTestimoni(id) {
                            const modal = document.getElementById('modal-testimoni-' + id);
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        }
                        function tutupModalTestimoni(id) {
                            const modal = document.getElementById('modal-testimoni-' + id);
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }
                    </script>

                @else
                    {{-- Empty state ulasan --}}
                    <div class="py-16 text-center rounded-2xl card-fade-border bg-[#FFFDF7] scroll-fade">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#E2D4C0]/50">
                            <i data-lucide="message-circle" class="h-7 w-7 text-[#C8A84B]"></i>
                        </div>
                        <p class="font-serif text-xl text-[#4A0F1A]">Belum ada ulasan</p>
                        <p class="mt-1 text-sm text-[#4A2E28]">Jadilah yang pertama memberikan penilaian setelah memesan.</p>
                    </div>
                @endif

            </div>
        </section>

    <div class="pb-12"></div>

    @include('public.layouts.footer')

    {{-- Modal: Harus Login Dulu --}}
    @guest
    <div id="modal-login-required" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="w-full max-w-sm rounded-3xl bg-white card-fade-border shadow-2xl p-8 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#FAF3E0] border-2 border-[#C8A84B]/40">
                    <i data-lucide="lock" class="h-6 w-6 text-[#C8960C]"></i>
                </div>
            </div>
            <h3 class="font-serif text-xl font-medium text-[#4A0F1A] mb-2">Masuk Terlebih Dahulu</h3>
            <p class="text-sm text-[#4A2E28]/70 mb-6">Kamu perlu login atau daftar akun untuk melakukan pemesanan.</p>
            <div class="space-y-3">
                <a href="{{ route('login') }}"
                   class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3 px-6 font-serif font-semibold text-[#4A0F1A] shadow-sm transition hover:scale-[1.02]">
                    <i data-lucide="log-in" class="h-4 w-4"></i>
                    Masuk Sekarang
                </a>
                <a href="{{ route('register') }}"
                   class="flex w-full items-center justify-center gap-2 rounded-full border border-[#4A0F1A]/20 py-3 px-6 text-sm font-semibold text-[#4A0F1A] transition hover:border-[#4A0F1A] hover:bg-[#4A0F1A]/5">
                    Daftar Akun Baru
                </a>
                <button onclick="document.getElementById('modal-login-required').classList.add('hidden')"
                        class="w-full text-sm text-[#4A2E28]/50 hover:text-[#4A0F1A] transition py-1">
                    Kembali
                </button>
            </div>
        </div>
    </div>
    @endguest

    {{-- Modal: Admin Tidak Bisa Pesan --}}
    @auth
    @if(Auth::user()->hasRole('admin'))
    <div id="modal-admin-only" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="w-full max-w-sm rounded-3xl bg-white card-fade-border shadow-2xl p-8 text-center">
            <div class="mb-4 flex justify-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#FAF3E0] border-2 border-[#C8A84B]/40">
                    <i data-lucide="shield-alert" class="h-6 w-6 text-[#C8960C]"></i>
                </div>
            </div>
            <h3 class="font-serif text-xl font-medium text-[#4A0F1A] mb-2">Akses Terbatas</h3>
            <p class="text-sm text-[#4A2E28]/70 mb-6">Anda login sebagai <strong>Admin</strong>. Pemesanan hanya dapat dilakukan oleh akun pelanggan.</p>
            <div class="space-y-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-3 px-6 font-serif font-semibold text-[#4A0F1A] shadow-sm transition hover:scale-[1.02]">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Kembali ke Panel Admin
                </a>
                <button onclick="document.getElementById('modal-admin-only').classList.add('hidden')"
                        class="w-full text-sm text-[#4A2E28]/50 hover:text-[#4A0F1A] transition py-1">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
    @endauth

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('in-view'); observer.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));

        // Tutup modal saat klik di luar card
        document.getElementById('modal-login-required')?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>
</body>
</html>
