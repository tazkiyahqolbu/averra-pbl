<form action="{{ route('user.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="pemesanan_id" value="{{ $pesanan->id }}">

    <div class="border-t border-[#E2D4C0] pt-5 space-y-3">
        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">
            {{ $label ?? 'Upload Bukti Pembayaran' }}
        </p>

        @if(isset($sisaBayar))
            <div class="rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm">
                <span class="text-[#4A2E28]/60">Jumlah pelunasan: </span>
                <span class="font-serif font-semibold text-[#C8960C]">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</span>
            </div>
        @endif

        @error('bukti_pembayaran')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror

        <div class="flex flex-col sm:flex-row gap-3">
            <input type="file" name="bukti_pembayaran" accept="image/jpeg,image/png,.pdf" required
                   class="flex-1 rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-3 py-2.5 text-sm text-[#4A2E28] file:mr-3 file:rounded-full file:border-0 file:bg-[#4A0F1A] file:px-3 file:py-1 file:text-xs file:font-semibold file:text-[#FAF3E0] focus:border-[#C8960C] focus:outline-none transition cursor-pointer">
            <button type="submit"
                    class="shrink-0 rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-5 py-2.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_12px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_16px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                Kirim Bukti
            </button>
        </div>
        <p class="text-[10px] text-[#4A2E28]/40">Format: JPG, PNG, atau PDF. Maks 5 MB.</p>
    </div>
</form>
