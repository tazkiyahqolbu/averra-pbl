<form action="{{ route('user.pembayaran.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
    @csrf
    <input type="hidden" name="pemesanan_id" value="{{ $pesanan->id }}">

    <div class="border-t border-gray-100 pt-4">
        <p class="text-sm font-bold uppercase tracking-wider text-gray-600 mb-3">
            📎 {{ $label ?? 'Upload Bukti Pembayaran' }}
        </p>

        @if(isset($sisaBayar))
            <div class="bg-[#FAF3E0] rounded-xl p-3 mb-3 text-sm">
                <span class="text-gray-500">Jumlah pelunasan: </span>
                <span class="font-bold text-[#800000]">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</span>
            </div>
        @endif

        @error('bukti_pembayaran')
            <p class="text-red-600 text-xs mb-2">{{ $message }}</p>
        @enderror

        <div class="flex flex-col sm:flex-row gap-3">
            <input type="file" name="bukti_pembayaran" accept="image/jpeg,image/png,.pdf" required
                   class="flex-1 rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-[#800000] transition bg-white cursor-pointer">
            <button type="submit"
                    class="bg-[#800000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm transition whitespace-nowrap">
                Kirim Bukti
            </button>
        </div>
        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, atau PDF. Maks 5 MB.</p>
    </div>
</form>
