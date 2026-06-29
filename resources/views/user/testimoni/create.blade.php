@extends('user.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-5">

        <div class="flex items-center gap-3">
            <a href="{{ route('user.pemesanan.invoice', $pesanan->id) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-[#4A2E28]/70 hover:text-[#4A0F1A] transition">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Invoice
            </a>
        </div>

        <div class="rounded-3xl bg-white border border-[#E2D4C0] shadow-[0_4px_24px_rgba(74,15,26,0.07)] overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-[#6B1625] via-[#C8960C] to-[#3A0A12]"></div>
            <div class="p-8 sm:p-10">

                <h2 class="font-serif text-2xl font-light text-[#4A0F1A] mb-1">Berikan Ulasan</h2>
                <p class="text-sm text-[#4A2E28]/60 mb-8">Pesanan #{{ $pesanan->kode_pemesanan }}</p>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('testimoni.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    {{-- Rating --}}
                    <div>
                        <label class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-3 block">
                            Rating
                        </label>
                        <div class="flex gap-2" id="star-container">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}"
                                    class="star-btn text-3xl text-[#E2D4C0] hover:text-[#C8960C] transition-colors">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                        @error('rating')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ulasan --}}
                    <div>
                        <label class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-3 block">
                            Ulasan
                        </label>
                        <textarea name="isi_testimoni" rows="5" placeholder="Ceritakan pengalaman kamu..."
                            class="w-full rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-5 py-4 text-sm text-[#4A2E28] placeholder-[#4A2E28]/40 focus:border-[#C8960C] focus:outline-none focus:ring-0 resize-none">{{ old('isi_testimoni') }}</textarea>
                        @error('isi_testimoni')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto (opsional) --}}
                    <div>
                        <label class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#C8960C] mb-3 block">
                            Foto <span class="normal-case tracking-normal text-[#4A2E28]/40">(opsional, maks. 3 foto)</span>
                        </label>
                        <input type="file" name="fotos[]" accept="image/*" multiple
                            class="block w-full text-sm text-[#4A2E28]/70 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border file:border-[#E2D4C0] file:text-xs file:font-semibold file:text-[#4A0F1A] file:bg-white hover:file:bg-[#FAF3E0] file:cursor-pointer">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-7 py-2.5 text-sm font-semibold text-white shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.42)] transition-all duration-200">
                            <i data-lucide="send" class="h-4 w-4"></i>
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');
        let current = parseInt(ratingInput.value) || 0;

        function renderStars(val) {
            stars.forEach(s => {
                s.classList.toggle('text-[#C8960C]', parseInt(s.dataset.value) <= val);
                s.classList.toggle('text-[#E2D4C0]', parseInt(s.dataset.value) > val);
            });
        }

        renderStars(current);

        stars.forEach(star => {
            star.addEventListener('click', () => {
                current = parseInt(star.dataset.value);
                ratingInput.value = current;
                renderStars(current);
            });
            star.addEventListener('mouseenter', () => renderStars(parseInt(star.dataset.value)));
            star.addEventListener('mouseleave', () => renderStars(current));
        });
    </script>
@endsection