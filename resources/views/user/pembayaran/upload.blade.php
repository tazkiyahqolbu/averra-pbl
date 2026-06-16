@extends('user.layouts.app')

@section('content')

<style>
    .font-dashboard {
        font-family: Inter, ui-sans-serif, system-ui, sans-serif;
    }
</style>

<div class="max-w-2xl mx-auto my-8 px-4 font-dashboard animate-fade-in">

    {{-- Header --}}
    <div class="border-b border-gray-200 pb-4 mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">
            KONFIRMASI
        </p>

        <h2 class="text-3xl font-bold text-[#5D001E] tracking-tight mt-1">
            Upload Bukti Pembayaran
        </h2>

        <p class="text-sm text-gray-500 font-medium mt-1">
            Silakan unggah bukti pembayaran untuk verifikasi transaksi Anda
        </p>
    </div>

    {{-- Card --}}
    <div class="rounded-[28px] bg-white border border-gray-100 shadow-sm overflow-hidden p-8">

        <form action="{{ route('user.pembayaran.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            {{-- Input Booking --}}
            <div>
                <label for="booking_id"
                       class="block text-sm font-medium text-gray-500 mb-2">
                    Kode Booking / ID Pemesanan
                </label>

                <input
                    type="text"
                    id="booking_id"
                    name="booking_id"
                    placeholder="Contoh: ORD-1 atau P1"
                    required
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-800 outline-none transition focus:border-[#5D001E] focus:ring-2 focus:ring-[#5D001E]/10">
            </div>

            {{-- Upload File --}}
            <div>
                <label for="payment_proof"
                       class="block text-sm font-medium text-gray-500 mb-2">
                    Dokumen Bukti Transaksi
                </label>

                <div
                    class="relative rounded-[24px] border-2 border-dashed border-gray-300 bg-gray-50/50 px-6 py-10 hover:border-[#5D001E] transition">

                    <div class="text-center">

                        {{-- Icon --}}
                        <svg class="mx-auto h-12 w-12 text-gray-400"
                             stroke="currentColor"
                             fill="none"
                             viewBox="0 0 48 48">

                            <path
                                d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h20a4 4 0 004-4V20m-6-6V8m0 6h6M14 22h20M14 26h20M14 30h12"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                        <div class="mt-4">
                            <label for="payment_proof"
                                   class="cursor-pointer inline-flex items-center rounded-full border border-[#5D001E] bg-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-[#5D001E] hover:bg-[#5D001E] hover:text-white transition shadow-sm">

                                Pilih File
                            </label>

                            <input
                                id="payment_proof"
                                name="payment_proof"
                                type="file"
                                class="hidden"
                                required
                                onchange="updateFileName(this)">
                        </div>

                        <p id="file-name-text"
                           class="text-sm text-gray-500 font-medium mt-4">
                            PNG, JPG, JPEG, PDF (maksimal 2MB)
                        </p>

                    </div>
                </div>
            </div>

            {{-- Button Action --}}
            <div class="flex items-center justify-between pt-2">

                <a href="{{ route('user.profile.index') }}"
                   class="text-sm font-medium text-gray-500 hover:text-[#5D001E] transition">

                    ← Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center rounded-full bg-[#5D001E] text-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider hover:bg-[#4A0F1A] transition shadow-md border border-[#D4AF37]">

                    Kirim Bukti
                </button>

            </div>

        </form>

    </div>
</div>

<script>
function updateFileName(input) {
    const textPlace = document.getElementById('file-name-text');

    if (input.files && input.files[0]) {
        textPlace.innerText = "Terpilih: " + input.files[0].name;
        textPlace.classList.add(
            'text-[#5D001E]',
            'font-semibold'
        );
    }
}
</script>

@endsection