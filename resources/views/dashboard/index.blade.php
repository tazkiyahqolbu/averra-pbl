@extends('layouts.app')

@section('title', 'SILART — Sanggar Rantiang Tagok')

@section('content')

<!-- HOME -->
<section id="home"
    class="relative isolate flex h-screen items-center justify-center overflow-hidden">

    <div class="absolute inset-0 -z-20 bg-cover bg-center h-full w-full"
        style="background-image:
        linear-gradient(to bottom,
        rgba(29,21,21,0.85),
        rgba(32,22,22,0.75),
        rgba(29,21,21,0.95)),
        url('{{ asset('image/background.png') }}');
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center;">
    </div>

    <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">

        <div class="mx-auto mb-6 flex items-center justify-center gap-4">
            <span class="text-xs tracking-[0.4em] text-gold uppercase font-semibold">
                — SANGGAR RANTIANG TAGOK —
            </span>
        </div>

        <h1 class="font-serif text-5xl font-light leading-[1.05] text-cream sm:text-7xl md:text-8xl">
            Menjaga <em class="text-gold not-italic">Warisan</em><br>
            Ranah Minang
        </h1>

        <p class="mx-auto mt-6 max-w-xl font-serif text-lg leading-relaxed text-white/90 sm:text-xl">
            Menghadirkan kehangatan adat dan kemewahan modern
            dalam setiap perayaan istimewa Anda.
        </p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">

            <a href="#booking"
                class="rounded-full bg-gradient-to-r
                from-[#D6B35C]
                to-[#B8983A]
                px-8 py-3.5 font-serif text-base
                text-maroon-deep shadow-lg
                transition duration-300
                hover:scale-105">

                Booking Acara Anda
            </a>

            <a href="#tentang"
                class="rounded-full border border-gold/60
                px-8 py-3.5 font-serif text-base
                text-cream transition duration-300
                hover:bg-cream/10">

                Mengenal Kami
            </a>

        </div>
    </div>

</section>


<!-- TENTANG -->
<section id="tentang">
    {{-- isi section tentang --}}
</section>


<!-- LAYANAN -->
<section id="layanan">
    {{-- isi layanan --}}
</section>


<!-- GALERI -->
<section id="galeri">
    {{-- isi galeri --}}
</section>


<!-- TESTIMONI -->
<section id="testimoni">
    {{-- isi testimoni --}}
</section>

@endsection