@extends('user.layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-scale-in">
    
    {{-- Header Judul --}}
    <div class="border-b border-maroon-deep/10 pb-4">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold">KONFIRMASI</p>
        <h2 class="font-serif text-3xl font-bold text-maroon-deep">Upload Bukti Pembayaran</h2>
    </div>

    {{-- Card Form Utama --}}
    <div class="rounded-3xl bg-white border border-maroon-deep/5 p-8 shadow-soft relative overflow-hidden">
        <form action="{{ route('user.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            {{-- Input Kode Booking --}}
            <div>
                <label neighborhoods for="booking_id" class="block text-xs font-bold uppercase tracking-wider text-maroon-deep/70 mb-2">
                    Kode Booking / ID Pemesanan
                </label>
                <input type="text" 
                       id="booking_id" 
                       name="booking_id" 
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none transition" 
                       placeholder="Contoh: ORD-1 atau P1" 
                       required>
            </div>

            {{-- Input File Bukti --}}
            <div>
                <label for="payment_proof" class="block text-xs font-bold uppercase tracking-wider text-maroon-deep/70 mb-2">
                    Dokumen Bukti Transaksi
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-maroon-deep transition cursor-pointer relative bg-gray-50/50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h20a4 4 0 004-4V20m-6-6V8m0 6h6M14 22h20M14 26h20M14 30h12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="payment_proof" class="relative cursor-pointer rounded-md font-medium text-maroon-deep hover:underline">
                                <span>Pilih file gambar/PDF</span>
                                <input id="payment_proof" name="payment_proof" type="file" class="sr-only" required onchange="updateFileName(this)">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500" id="file-name-text">PNG, JPG, JPEG up to 2MB</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-2 flex items-center justify-between gap-4">
                <a href="{{ route('user.dashboard') }}" class="text-xs font-medium text-gray-500 hover:text-maroon-deep transition">
                    ← Batal
                </a>
                <button type="submit" class="rounded-full bg-maroon-deep text-cream px-6 py-2.5 text-sm font-semibold hover:opacity-90 transition shadow-sm border border-gold/20">
                    Kirim Bukti Bayar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Script interaktif sederhana untuk mengubah teks nama file saat dipilih
function updateFileName(input) {
    const textPlace = document.getElementById('file-name-text');
    if (input.files && input.files[0]) {
        textPlace.innerText = "Terpilih: " + input.files[0].name;
        textPlace.classList.add('text-maroon-deep', 'font-medium');
    }
}
</script>
@endsection