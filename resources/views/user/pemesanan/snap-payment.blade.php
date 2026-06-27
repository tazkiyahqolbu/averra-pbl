@extends('user.layouts.app')

@section('content')
<div class="flex flex-col items-center justify-start min-h-[60vh] py-4">
<div class="w-full max-w-lg">

<div class="mb-6 text-center">
    <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— PEMBAYARAN —</p>
    <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">Proses Pembayaran</h1>
</div>

<div>
    <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] p-8 text-center space-y-4">

        <div id="loading-state">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 border-4 border-[#C8960C] border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-[#4A2E28] font-medium">Memuat halaman pembayaran...</p>
            <p class="text-sm text-[#4A2E28]/60 mt-1">Silakan tunggu sebentar</p>
        </div>

        <div id="payment-ready" class="hidden space-y-4">
            <p class="font-medium text-[#4A0F1A]">Halaman pembayaran siap dibuka</p>
            <button onclick="openSnap()"
                class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-3.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] transition-all duration-200">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                Buka Halaman Pembayaran
            </button>
        </div>

        <div id="error-state" class="hidden space-y-4">
            <div class="flex justify-center text-red-400">
                <i data-lucide="wifi-off" class="w-10 h-10"></i>
            </div>
            <p class="font-medium text-red-700">Gagal Memuat Pembayaran</p>
            <p id="error-msg" class="text-sm text-[#4A2E28]/60"></p>
            <button onclick="window.location.reload()"
                class="w-full flex items-center justify-center gap-2 rounded-xl border border-[#C8960C] px-6 py-3 text-sm font-semibold text-[#C8960C] hover:bg-[#FAF3E0] transition-all duration-200">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Coba Lagi
            </button>
        </div>

    </div>

    <a href="{{ route('user.pemesanan.show', $pesanan->id) }}"
       class="flex items-center justify-center gap-1.5 text-sm text-[#4A2E28]/60 hover:text-[#4A0F1A] transition mt-4">
        <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
        Kembali ke Detail Pesanan
    </a>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
    const snapToken = @json($snapToken);
    const finishUrl = "{{ route('user.pembayaran.finish') }}";
    const snapJsUrl = "{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}";
    const clientKey = "{{ config('services.midtrans.client_key') }}";

    function openSnap() {
        snap.pay(snapToken, {
            onSuccess: function (result) {
                window.location.href = finishUrl + '?order_id=' + result.order_id;
            },
            onPending: function (result) {
                window.location.href = finishUrl + '?order_id=' + result.order_id;
            },
            onError: function (result) {
                window.location.href = finishUrl + '?order_id=' + result.order_id;
            },
            onClose: function () {
                document.getElementById('loading-state').classList.add('hidden');
                document.getElementById('payment-ready').classList.remove('hidden');
            }
        });
    }

    function showError(msg) {
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('error-state').classList.remove('hidden');
        document.getElementById('error-msg').textContent = msg;
    }

    // Load snap.js dynamically with error handling
    const script = document.createElement('script');
    script.src = snapJsUrl;
    script.setAttribute('data-client-key', clientKey);
    script.onload = function () {
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('payment-ready').classList.remove('hidden');
        openSnap();
    };
    script.onerror = function () {
        showError('Gagal terhubung ke server Midtrans. Periksa koneksi internet kamu, lalu refresh halaman.');
    };

    // Timeout 15 detik jika tidak ada respons
    const timeout = setTimeout(function () {
        if (typeof window.snap === 'undefined') {
            showError('Koneksi ke Midtrans timeout. Periksa koneksi internet kamu, lalu refresh halaman.');
        }
    }, 15000);

    script.onload = function () {
        clearTimeout(timeout);
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('payment-ready').classList.remove('hidden');
        openSnap();
    };

    document.head.appendChild(script);
</script>
@endpush
