@php
$services = [
    ['icon' => 'heart',    'title' => 'Paket Pernikahan',  'desc' => 'Rangkaian acara adat lengkap dari akad hingga resepsi dengan sentuhan Minangkabau.'],
    ['icon' => 'sparkles', 'title' => 'Hiburan / Acara',   'desc' => 'Konsep hiburan untuk syukuran, ulang tahun, dan perayaan keluarga.'],
    ['icon' => 'mic',      'title' => 'Master of Ceremony','desc' => 'MC dwibahasa berpengalaman, membawa acara dengan elegan dan berwibawa.'],
    ['icon' => 'guitar',   'title' => 'Band & Akustik',    'desc' => 'Iringan musik live, dari akustik intim hingga band full untuk panggung besar.'],
    ['icon' => 'music',    'title' => 'Pertunjukan Tari',  'desc' => 'Tari Piring, Pasambahan, Indang, dan repertoar khas ranah Minang.'],
    ['icon' => 'brush',    'title' => 'Makeup & Busana',   'desc' => 'Tata rias pengantin tradisional dan modern oleh perias profesional.'],
];
$costumes = [
    ['img' => asset('foto/Resepsi.jpeg'),    'name' => 'Resepsi',     'cat' => 'Wedding'],
    ['img' => asset('foto/MC.jpeg'),          'name' => 'MC',          'cat' => 'Stage & MC'],
    ['img' => asset('foto/Busana tari.jpeg'), 'name' => 'Busana Tari', 'cat' => 'Dance Attire'],
    ['img' => asset('foto/Baju adat.jpeg'),   'name' => 'Busana Adat', 'cat' => 'Traditional Attire'],
];
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILART — Sanggar Rantiang Tagok | Layanan Adat Minangkabau</title>
    <meta name="description" content="Sistem Informasi & Layanan Sanggar Rantiang Tagok.">
    <meta property="og:title"       content="SILART — Sanggar Rantiang Tagok">
    <meta property="og:description" content="Kehangatan budaya Minang berbalut kemewahan modern.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased selection:bg-[#C8A84B]/30">

    @include('public.layouts.navbar')

    {{-- ══ HERO ══ --}}
    <section id="home" class="relative isolate flex h-screen items-center justify-center overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#FBF6EC] via-[#F5EBD0] to-[#FAF3E0]"></div>
        <div class="absolute inset-0 -z-10 opacity-[0.06]" aria-hidden="true">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hero-geo" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                        <path d="M40 3 L77 40 L40 77 L3 40 Z" fill="none" stroke="#7B1C2E" stroke-width="1"/>
                        <path d="M40 18 L62 40 L40 62 L18 40 Z" fill="none" stroke="#7B1C2E" stroke-width="0.6"/>
                        <circle cx="40" cy="40" r="1.5" fill="#7B1C2E"/>
                        <circle cx="40" cy="3"  r="1"   fill="#7B1C2E"/>
                        <circle cx="77" cy="40" r="1"   fill="#7B1C2E"/>
                        <circle cx="40" cy="77" r="1"   fill="#7B1C2E"/>
                        <circle cx="3"  cy="40" r="1"   fill="#7B1C2E"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-geo)"/>
            </svg>
        </div>
        <div class="pointer-events-none absolute -top-32 right-0 h-[640px] w-[640px] rounded-full opacity-30"
             style="background: radial-gradient(circle, #e8d5a0 0%, transparent 68%);" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-32 h-[520px] w-[520px] rounded-full opacity-20"
             style="background: radial-gradient(circle, #d4b870 0%, transparent 68%);" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">
            <p class="mb-6 text-xs tracking-[0.45em] text-[#7B1C2E] uppercase font-semibold">
                — SANGGAR RANTIANG TAGOK —
            </p>
            <h1 class="font-serif text-5xl font-light leading-[1.05] text-[#4A0F1A] sm:text-7xl md:text-8xl">
                Menjaga <em class="text-[#C8A84B] not-italic">Warisan</em><br>Ranah Minang
            </h1>
            <p class="mx-auto mt-6 max-w-xl font-serif text-lg leading-relaxed text-[#4A2E28] sm:text-xl">
                Menghadirkan kehangatan adat dan kemewahan modern dalam setiap perayaan istimewa Anda.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('public.katalog.index') }}"
                   class="inline-block rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-8 py-3.5 font-serif text-base font-semibold text-[#4A0F1A] shadow-lg transition duration-300 hover:scale-105">
                    Booking Acara Anda
                </a>
                <a href="#tentang"
                   class="inline-block rounded-full border border-[#7B1C2E]/25 px-8 py-3.5 font-serif text-base text-[#7B1C2E] transition duration-300 hover:bg-[#7B1C2E]/6">
                    Mengenal Kami
                </a>
            </div>
        </div>
        <p class="absolute bottom-8 left-0 right-0 text-center text-[10px] tracking-[0.2em] sm:tracking-[0.45em] text-[#7B1C2E]/70 font-medium uppercase px-4 overflow-hidden">
            Adat Basandi Syarak · Syarak Basandi Kitabullah
        </p>
    </section>

    {{-- ══ LAYANAN KAMI ══ --}}
    <section id="layanan" class="relative isolate py-24 bg-[#FFFDF7]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FAF3E0] to-transparent"></div>

        <div class="mx-auto max-w-6xl px-6 text-center scroll-fade">
            <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— LAYANAN KAMI —</p>
            <h2 class="mt-2 font-serif text-4xl font-light text-[#4A0F1A] sm:text-5xl">Solusi Lengkap Acara Anda</h2>
            <div class="mx-auto mt-3 h-[1px] w-32 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
        </div>

        <div class="mt-14 mx-auto max-w-6xl px-6 flex flex-wrap justify-center gap-8">
            <div class="group w-full md:w-[380px] rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-8 text-center transition-all duration-300 hover:scale-[1.03] hover:border-[#C8A84B]/50 hover:shadow-xl scroll-fade scroll-delay-1">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="gift" class="h-8 w-8"></i>
                </div>
                <h3 class="font-serif text-2xl font-medium text-[#4A0F1A]">PAKET ACARA</h3>
                <p class="mt-3 text-sm leading-relaxed text-[#4A2E28]">
                    Paket Ekonomis, Paket Eksklusif, Paket Hemat, Paket Baralek Gadang,
                    Paket Wedding Minang, Akustik dan berbagai kebutuhan acara lainnya.
                </p>
                <a href="{{ url('/katalog?category=Paket%20Acara') }}"
                   class="mt-5 inline-block text-sm font-semibold text-[#C8A84B] transition hover:text-[#B8983A]">
                    Lihat →
                </a>
            </div>

            <div class="group w-full md:w-[380px] rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-8 text-center transition-all duration-300 hover:scale-[1.03] hover:border-[#C8A84B]/50 hover:shadow-xl scroll-fade scroll-delay-2">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                    <i data-lucide="package" class="h-8 w-8"></i>
                </div>
                <h3 class="font-serif text-2xl font-medium text-[#4A0F1A]">SEWA BARANG</h3>
                <p class="mt-3 text-sm leading-relaxed text-[#4A2E28]">
                    Menyediakan penyewaan baju tari perempuan dan laki-laki,
                    serta alat musik tradisional Minangkabau untuk berbagai acara.
                </p>
                <a href="{{ url('/katalog?category=Sewa%20Barang') }}"
                   class="mt-5 inline-block text-sm font-semibold text-[#C8A84B] transition hover:text-[#B8983A]">
                    Lihat →
                </a>
            </div>
        </div>
    </section>

    {{-- ══ CARA PESAN ══ --}}
    <section id="cara-pesan" class="relative isolate py-24 bg-[#FAF3E0]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FFFDF7] to-transparent"></div>

        <div class="mx-auto max-w-6xl px-6 text-center scroll-fade">
            <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— CARA PESAN —</p>
            <h2 class="mt-2 font-serif text-4xl font-light text-[#4A0F1A] sm:text-5xl">Bagaimana Cara Memesan?</h2>
            <div class="mx-auto mt-3 h-[1px] w-32 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
        </div>

        @php
            $steps = [
                ['num' => '1', 'icon' => 'layers',         'title' => 'Pilih Layanan',      'desc' => 'Jelajahi katalog dan pilih yang sesuai kebutuhan'],
                ['num' => '2', 'icon' => 'clipboard-list', 'title' => 'Isi Form',           'desc' => 'Lengkapi data & pilih tanggal pelaksanaan'],
                ['num' => '3', 'icon' => 'message-circle', 'title' => 'Tunggu Konfirmasi',  'desc' => 'Admin kami akan menghubungi dalam 1x24 jam'],
                ['num' => '4', 'icon' => 'credit-card',    'title' => 'Lakukan Pembayaran', 'desc' => 'Upload bukti DP atau bayar lunas'],
                ['num' => '5', 'icon' => 'calendar-check', 'title' => 'Acara Berjalan',     'desc' => 'Kami siapkan semua kebutuhan Anda'],
                ['num' => '6', 'icon' => 'star',           'title' => 'Selesai & Nilai',    'desc' => 'Berikan penilaian untuk layanan kami'],
            ];
        @endphp

        {{-- Mobile: grid 3x2, Desktop: horizontal timeline --}}
        <div class="mt-16 mx-auto max-w-5xl px-6">
            <div class="hidden lg:flex items-start pt-2">
                @foreach($steps as $i => $s)
                    <div class="flex flex-1 flex-col items-center scroll-fade scroll-delay-{{ $i + 1 }}">
                        <div class="flex w-full items-center">
                            <div class="flex-1 {{ $i === 0 ? 'opacity-0' : 'border-t-2 border-dashed border-[#C8A84B]/40' }}"></div>
                            <div class="relative shrink-0">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#4A0F1A] shadow-lg ring-4 ring-[#FAF3E0] transition-all duration-300 hover:scale-110 hover:shadow-xl">
                                    <i data-lucide="{{ $s['icon'] }}" class="h-7 w-7 text-[#C8A84B]"></i>
                                </div>
                                <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-[#C8A84B] text-[10px] font-bold text-[#4A0F1A]">
                                    {{ $s['num'] }}
                                </span>
                            </div>
                            <div class="flex-1 {{ $i === count($steps) - 1 ? 'opacity-0' : 'border-t-2 border-dashed border-[#C8A84B]/40' }}"></div>
                        </div>
                        <div class="mt-4 px-2 text-center">
                            <h3 class="font-serif text-sm font-semibold text-[#4A0F1A] leading-snug">{{ $s['title'] }}</h3>
                            <p class="mt-1 text-xs leading-relaxed text-[#4A2E28]">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Mobile grid 3x2 --}}
            <div class="grid grid-cols-3 gap-4 lg:hidden">
                @foreach($steps as $s)
                    <div class="flex flex-col items-center text-center p-3 rounded-xl bg-[#FAF3E0] border border-[#E2D4C0]">
                        <div class="relative flex h-12 w-12 items-center justify-center rounded-full bg-[#4A0F1A] shadow-md">
                            <i data-lucide="{{ $s['icon'] }}" class="h-5 w-5 text-[#C8A84B]"></i>
                            <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-[#C8A84B] text-[9px] font-bold text-[#4A0F1A]">{{ $s['num'] }}</span>
                        </div>
                        <h3 class="mt-2 font-serif text-[11px] font-semibold text-[#4A0F1A] leading-tight">{{ $s['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══ PAKET UNGGULAN ══ --}}
    <section id="paket" class="relative isolate py-24 bg-[#FFFDF7]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FAF3E0] to-transparent"></div>

        <div class="mx-auto max-w-6xl px-6 text-center scroll-fade">
            <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— PAKET TERPOPULER —</p>
            <h2 class="mt-2 font-serif text-4xl font-light text-[#4A0F1A] sm:text-5xl">Paket Unggulan</h2>
            <div class="mx-auto mt-3 h-[1px] w-32 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
        </div>

        <div class="mt-14 mx-auto max-w-6xl px-6 grid gap-4 sm:gap-8 grid-cols-2 md:grid-cols-3">
            @foreach($pakets ?? [] as $p)
    <div class="overflow-hidden rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] transition-all duration-300 hover:scale-[1.03] hover:border-[#C8A84B]/50 hover:shadow-xl scroll-fade scroll-delay-{{ $loop->index + 1 }}">
        <div class="aspect-[4/3] overflow-hidden">
            <img src="{{ $p->thumbnail_path ? Storage::url($p->thumbnail_path) : asset('foto/background.png') }}"
                 alt="{{ $p->nama_paket }}" class="h-full w-full object-cover">
        </div>
        <div class="p-6">
            <h3 class="font-serif text-xl font-medium text-[#4A0F1A]">{{ $p->nama_paket }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-[#4A2E28]">{{ Str::limit($p->deskripsi, 100) }}</p>
            <p class="mt-3 font-serif text-lg font-semibold text-[#C8A84B]">
                Mulai Rp {{ number_format($p->harga, 0, ',', '.') }}
            </p>
            <a href="{{ route('katalog.show', 'paket-' . $p->id) }}"
               class="mt-4 inline-block rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-6 py-2 font-serif text-sm font-semibold text-[#4A0F1A] shadow-sm transition hover:scale-105">
                Lihat Detail
            </a>
        </div>
    </div>
@endforeach

        </div>
    </section>

    {{-- ══ TENTANG KAMI ══ --}}
    <section id="tentang" class="relative isolate py-20 bg-[#FAF3E0]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FFFDF7] to-transparent"></div>
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-12 items-center md:grid-cols-2">

                <div class="relative group scroll-fade scroll-delay-1">
                    <div class="absolute -inset-2 rounded-2xl bg-[#C8A84B]/10 blur opacity-70 transition duration-500 group-hover:opacity-100"></div>
                    <div class="relative overflow-hidden rounded-2xl border border-[#E2D4C0] shadow-lg aspect-[4/3] sm:aspect-video md:aspect-[3/4]">
                        <img src="{{ asset('foto/Busana tari.jpeg') }}" alt="Busana Tari Rantiang Tagok"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                </div>

                <div class="space-y-6 scroll-fade scroll-delay-2">
                    <div>
                        <p class="text-xs tracking-[0.3em] text-[#C8A84B] uppercase font-semibold">— SEJAK 2012 —</p>
                        <h2 class="mt-2 font-serif text-4xl font-light text-[#4A0F1A] leading-tight">
                            Merawat Akar Tradisi,<br>Mekar di Era Modern
                        </h2>
                        <div class="mt-3 h-[1px] w-24 bg-gradient-to-r from-[#C8A84B] via-[#C8A84B]/40 to-transparent"></div>
                    </div>
                    <p class="text-sm sm:text-base leading-relaxed text-[#4A2E28]">
                        Berdiri di jantung kota Padang,
                        <strong class="font-semibold text-[#4A0F1A]">Sanggar Seni Rantiang Tagok</strong>
                        lahir dari dedikasi mendalam untuk melestarikan seni, musik, dan adat tradisi khususnya Minangkabau.
                        Beroperasi sejak tahun 2012, sanggar ini terus berkembang menjadi wadah profesional seni budaya Minang.
                    </p>
                    <div class="space-y-3 rounded-2xl border border-[#E2D4C0] bg-[#FFFDF7] p-5">
                        <h4 class="flex items-center gap-2 font-serif text-lg font-medium text-[#4A0F1A]">
                            <i data-lucide="sparkles" class="h-4 w-4 text-[#C8A84B]"></i>
                            Profil & Filosofi Sanggar
                        </h4>
                        <p class="text-sm italic leading-relaxed text-[#4A2E28]">
                            "Mekar nan anggun, kokoh mengakar."
                            Sebelumnya dikenal dengan nama
                            <span class="font-medium text-[#4A0F1A]">Sanggar Rampak Badan</span>,
                            kami berkomitmen menjaga seni autentik Minangkabau dan memadukannya dengan pengelolaan modern.
                        </p>
                        <div class="border-t border-[#E2D4C0] pt-2 text-xs text-[#4A2E28]">
                            <span class="font-semibold text-[#4A0F1A]">Pengelolaan:</span> Tim 7 Anggota Terlatih
                        </div>
                    </div>
                    <p class="text-sm sm:text-base leading-relaxed text-[#4A2E28]">
                        Kini, dengan target audiens umum dan didukung tim profesional, kami fokus menyediakan layanan
                        hiburan, penyewaan kostum adat, hingga pertunjukan budaya berkualitas tinggi untuk menghidupkan
                        kemegahan tradisi Minangkabau maupun daerah lain di Indonesia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ GALERI ══ --}}
    <section id="galeri" class="relative isolate py-20 bg-[#FFFDF7]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FAF3E0] to-transparent"></div>
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-10 text-center scroll-fade">
                <p class="text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— MOMEN INDAH —</p>
                <h2 class="mt-2 font-serif text-4xl font-light text-[#4A0F1A] sm:text-5xl">Dokumentasi Galeri SILART</h2>
                <div class="mx-auto mt-2 h-[1px] w-32 bg-gradient-to-r from-transparent via-[#C8A84B] to-transparent"></div>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($galeriUnggulan as $gal)
                    <div class="group relative rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-3 shadow-sm transition-all duration-300 hover:scale-[1.03] hover:border-[#C8A84B]/50 hover:shadow-lg scroll-fade scroll-delay-{{ $loop->index + 1 }}">
                        <div class="aspect-square overflow-hidden rounded-xl">
                            @if($gal->jenis_media === 'video')
                                <video class="h-full w-full object-cover" muted preload="metadata">
                                    <source src="{{ $gal->media_url }}">
                                </video>
                            @else
                                <img src="{{ $gal->media_url }}" alt="{{ $gal->judul }}"
                                     class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="pb-2 pt-4 text-center">
                            <span class="font-serif text-xl font-medium tracking-wide text-[#4A0F1A]">{{ $gal->judul }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 py-10 text-center text-sm text-[#4A0F1A]/40">
                        Belum ada galeri unggulan yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ══ TESTIMONI (auto-slide) ══ --}}
    <section id="testimoni"
        class="relative isolate py-20 bg-[#FAF3E0]"
        x-data="{
            activeSlide: 0,
            totalSlides: {{ count($testimonials ?? []) ?: 3 }},
            timer: null,
            start() {
                this.timer = setInterval(() => this.next(), 5000);
            },
            stop()  { clearInterval(this.timer); },
            next()  { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; },
            prev()  { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides; },
            go(n)   { this.activeSlide = n; this.stop(); this.start(); }
        }"
        x-init="start()"
        @mouseenter="stop()"
        @mouseleave="start()">

        <div class="pointer-events-none absolute inset-x-0 top-0 h-24 -z-10 bg-gradient-to-b from-[#FFFDF7] to-transparent"></div>

        <div class="relative z-10 mx-auto max-w-3xl px-6 text-center scroll-fade">

            <div class="mb-2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#C8A84B]/10 text-[#C8A84B]">
                <i data-lucide="quote" class="h-5 w-5 rotate-180"></i>
            </div>
            <p class="mb-6 text-[10px] tracking-[0.25em] uppercase text-[#C8A84B] font-bold">— KATA MEREKA —</p>

            <div class="relative flex min-h-[140px] items-center justify-center">

                @if(isset($testimonials) && count($testimonials) > 0)
                    @foreach($testimonials as $index => $t)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-x-8"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-8"
                             class="absolute w-full">
                            <blockquote class="mx-auto max-w-2xl font-serif text-xl font-light leading-relaxed text-[#4A0F1A] sm:text-2xl">
                                &ldquo;{{ $t->quote }}&rdquo;
                            </blockquote>
                            <div class="mt-4">
                                <h4 class="text-sm font-semibold text-[#7B1C2E] sm:text-base">{{ $t->name }}</h4>
                                <p class="text-xs text-[#4A2E28]">{{ $t->role }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div x-show="activeSlide === 0"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="absolute w-full">
                        <blockquote class="mx-auto max-w-2xl font-serif text-xl font-light leading-relaxed text-[#4A0F1A] sm:text-2xl">
                            &ldquo;Tari Pasambahan dari Rantiang Tagok membuat momen pernikahan kami terasa sakral dan istimewa.&rdquo;
                        </blockquote>
                        <div class="mt-4">
                            <h4 class="text-sm font-semibold text-[#7B1C2E] sm:text-base">Ananda & Reza</h4>
                            <p class="text-xs text-[#4A2E28]">Pernikahan Adat, Padang</p>
                        </div>
                    </div>
                    <div x-show="activeSlide === 1"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="absolute w-full">
                        <blockquote class="mx-auto max-w-2xl font-serif text-xl font-light leading-relaxed text-[#4A0F1A] sm:text-2xl">
                            &ldquo;Penampilan mereka menjadi sorotan malam itu — kostumnya megah dan koreografinya rapi.&rdquo;
                        </blockquote>
                        <div class="mt-4">
                            <h4 class="text-sm font-semibold text-[#7B1C2E] sm:text-base">Bp. Hendra</h4>
                            <p class="text-xs text-[#4A2E28]">PT Sinar Mentari</p>
                        </div>
                    </div>
                    <div x-show="activeSlide === 2"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="absolute w-full">
                        <blockquote class="mx-auto max-w-2xl font-serif text-xl font-light leading-relaxed text-[#4A0F1A] sm:text-2xl">
                            &ldquo;Anak saya ikut kelas tari di sini dan belajar adat Minang dengan sangat baik.&rdquo;
                        </blockquote>
                        <div class="mt-4">
                            <h4 class="text-sm font-semibold text-[#7B1C2E] sm:text-base">Ibu Sari</h4>
                            <p class="text-xs text-[#4A2E28]">Orang tua siswa</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Navigasi & dot indicator --}}
            <div class="mt-10 flex items-center justify-center gap-4">
                <button @click="prev(); stop(); start()"
                        class="grid h-8 w-8 place-items-center rounded-full border border-[#7B1C2E]/20 text-[#7B1C2E] transition hover:bg-[#7B1C2E]/8">
                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                </button>

                {{-- Dot indicators --}}
                <div class="flex gap-2">
                    @for($d = 0; $d < (isset($testimonials) && count($testimonials) > 0 ? count($testimonials) : 3); $d++)
                        <button @click="go({{ $d }})"
                                class="h-2 rounded-full transition-all duration-300"
                                :class="activeSlide === {{ $d }} ? 'w-6 bg-[#C8A84B]' : 'w-2 bg-[#7B1C2E]/20'">
                        </button>
                    @endfor
                </div>

                <button @click="next(); stop(); start()"
                        class="grid h-8 w-8 place-items-center rounded-full border border-[#7B1C2E]/20 text-[#7B1C2E] transition hover:bg-[#7B1C2E]/8">
                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section id="cta" class="relative py-24 bg-[#FAF3E0]">
        <div class="absolute inset-0 opacity-[0.04]" aria-hidden="true">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="cta-geo" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                        <path d="M30 2 L58 30 L30 58 L2 30 Z" fill="none" stroke="#7B1C2E" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#cta-geo)"/>
            </svg>
        </div>

        <div class="relative z-10 mx-auto max-w-3xl px-6 text-center scroll-fade">
            <p class="mb-4 text-xs tracking-[0.4em] text-[#C8A84B] uppercase font-semibold">— MULAI SEKARANG —</p>
            <h2 class="font-serif text-4xl font-light leading-tight text-[#4A0F1A] sm:text-5xl">
                Siap Mulai Merencanakan<br>Acaramu?
            </h2>
            <p class="mt-4 text-lg font-light text-[#4A2E28]/60">
                Hubungi kami sekarang atau langsung buat pemesanan.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('public.katalog.index') }}"
                   class="inline-block rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-8 py-3.5 font-serif text-base font-semibold text-[#4A0F1A] shadow-lg transition duration-300 hover:scale-105">
                    Buat Pemesanan
                </a>
                <a href="https://wa.me/6282261177926" target="_blank" rel="noopener noreferrer"
                   class="inline-block rounded-full border border-[#4A0F1A]/30 px-8 py-3.5 font-serif text-base text-[#4A0F1A] transition duration-300 hover:bg-[#4A0F1A]/8">
                    WhatsApp Kami
                </a>
            </div>
        </div>
    </section>

    @include('public.layouts.footer')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('in-view');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.scroll-fade').forEach(el => observer.observe(el));
    </script>
</body>
</html>
