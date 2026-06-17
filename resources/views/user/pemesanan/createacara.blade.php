@extends('user.layouts.app')

@section('content')
<div x-data="orderForm()" x-init="initForm" class="max-w-4xl mx-auto space-y-6 my-10 animate-fade-in px-4 sm:px-0">

    {{-- Header --}}
    <div class="mb-8 border-b border-gray-200 pb-4">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">BUAT PESANAN ACARA</p>
        <h2 class="text-3xl font-bold text-[#800000]">Formulir Paket Acara</h2>
    </div>

    {{-- Stepper Progress --}}
    <div class="mb-8">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#800000] rounded-full z-0 transition-all duration-300"
                 :style="'width: ' + ((step - 1) / 2 * 100) + '%'"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                     :class="step >= 1 ? 'bg-[#800000] text-white border-2 border-[#800000]' : 'bg-white text-gray-400 border-2 border-gray-200'">1</div>
                <span class="mt-2 text-xs font-semibold" :class="step >= 1 ? 'text-[#800000]' : 'text-gray-400'">Detail Pesanan</span>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                     :class="step >= 2 ? 'bg-[#800000] text-white border-2 border-[#800000]' : 'bg-white text-gray-400 border-2 border-gray-200'">2</div>
                <span class="mt-2 text-xs font-semibold" :class="step >= 2 ? 'text-[#800000]' : 'text-gray-400'">Lokasi</span>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                     :class="step >= 3 ? 'bg-[#800000] text-white border-2 border-[#800000]' : 'bg-white text-gray-400 border-2 border-gray-200'">3</div>
                <span class="mt-2 text-xs font-semibold" :class="step >= 3 ? 'text-[#800000]' : 'text-gray-400'">Pembayaran</span>
            </div>
        </div>
    </div>

    <form action="{{ route('user.pemesanan.store') }}" method="POST" class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm">
        @csrf
        <input type="hidden" name="kategori_order" x-model="katalogCategory">
        <input type="hidden" name="total_harga" x-model="grandTotal">

        {{-- STEP 1 --}}
        <div x-show="step === 1" x-transition.opacity>
            <h3 class="text-xl font-bold text-[#800000] mb-6 border-b pb-2">STEP 1: Detail Pesanan</h3>
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Pilih Paket Acara <span class="text-red-500">*</span></h4>
                <select name="katalog_id" x-model="selectedKatalogId" @change="updateKatalog" required class="w-full mb-3 rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition">
                    <option value="" disabled>Pilih Paket dari Katalog</option>
                    <template x-for="k in katalogList.filter(i => i.category !== 'Sewa Barang' && i.category !== 'Properti')" :key="k.id">
                        <option :value="k.id" x-text="k.name + ' - Rp' + formatRupiah(k.price)"></option>
                    </template>
                </select>
            </div>

            <div class="mb-6 pt-6 border-t border-gray-100">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pelaksanaan" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Acara <span class="text-gray-400 font-normal text-xs">(opsional)</span></label>
                    <textarea rows="3" name="keterangan_acara" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition" placeholder="Jenis acara, tema, dll."></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" @click="nextStep()" :disabled="!selectedKatalogId" class="bg-[#800000] text-white px-6 py-2.5 rounded-full font-semibold shadow-md disabled:opacity-50">Lanjut</button>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div x-show="step === 2" x-transition.opacity style="display: none;">
            <h3 class="text-xl font-bold text-[#800000] mb-6 border-b pb-2">STEP 2: Informasi & Lokasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemesan" value="{{ auth()->user()->nama ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP <span class="text-red-500">*</span></label>
                    <input type="tel" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition" required>
                </div>
            </div>

            <div class="mb-6 pt-6 border-t border-gray-100">
                <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Lokasi Pelaksanaan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <label class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer" :class="eventLocation === 'di_tempat_kami' ? 'bg-[#FAF3E0]/30 border-[#800000]' : ''">
                        <input type="radio" name="lokasi_pelaksanaan" value="di_tempat_kami" x-model="eventLocation" class="mt-1 text-[#800000]">
                        <div><span class="block font-bold">Di Sanggar</span><span class="text-xs text-gray-500">Gratis transport</span></div>
                    </label>
                    <label class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer" :class="eventLocation === 'di_luar' ? 'bg-[#FAF3E0]/30 border-[#800000]' : ''">
                        <input type="radio" name="lokasi_pelaksanaan" value="di_luar" x-model="eventLocation" class="mt-1 text-[#800000]">
                        <div><span class="block font-bold">Di Lokasi Luar</span><span class="text-xs text-gray-500">Sesuai zona transport</span></div>
                    </label>
                </div>

                <div x-show="eventLocation === 'di_luar'" class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <select name="zona_lokasi_id" x-model="selectedZonaId" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition">
                        <option value="">Pilih Zona Lokasi...</option>
                        <template x-for="z in zonaLokasis" :key="z.id">
                            <option :value="z.id" x-text="z.nama_zona + ' (Rp' + formatRupiah(z.tarif) + ')'"></option>
                        </template>
                    </select>
                    <textarea name="alamat_lengkap" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#800000] transition" placeholder="Alamat lengkap acara..."></textarea>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" @click="prevStep()" class="text-gray-600 px-6 py-2.5">Kembali</button>
                <button type="button" @click="nextStep()" class="bg-[#800000] text-white px-6 py-2.5 rounded-full font-semibold">Lanjut</button>
            </div>
        </div>

        {{-- STEP 3 --}}
        <div x-show="step === 3" x-transition.opacity style="display: none;">
            <h3 class="text-xl font-bold text-[#800000] mb-6 border-b pb-2">STEP 3: Pembayaran</h3>
            <div class="bg-gray-50 rounded-xl border p-5 mb-6">
                <div class="flex justify-between mb-2"><span>Subtotal Paket</span><span class="font-bold">Rp <span x-text="formatRupiah(katalogPrice)"></span></span></div>
                <div class="flex justify-between mb-2" x-show="ongkosKirim > 0"><span>Biaya Transport</span><span class="font-bold">Rp <span x-text="formatRupiah(ongkosKirim)"></span></span></div>
                <div class="border-t pt-3 flex justify-between font-bold text-[#800000]"><span>TOTAL</span><span class="text-xl">Rp <span x-text="formatRupiah(grandTotal)"></span></span></div>
            </div>

            <div class="space-y-4 mb-6">
                <label class="block p-4 border rounded-xl cursor-pointer" :class="paymentMethod === 'dp' ? 'border-[#800000] bg-[#FAF3E0]/30' : ''">
                    <input type="radio" name="metode_bayar" value="dp" x-model="paymentMethod"> <span class="font-bold">Bayar DP 50%</span>
                </label>
                <label class="block p-4 border rounded-xl cursor-pointer" :class="paymentMethod === 'lunas' ? 'border-[#800000] bg-[#FAF3E0]/30' : ''">
                    <input type="radio" name="metode_bayar" value="lunas" x-model="paymentMethod"> <span class="font-bold">Bayar Lunas</span>
                </label>
            </div>

            <div class="flex justify-between">
                <button type="button" @click="prevStep()" class="text-gray-600 px-6 py-2.5">Kembali</button>
                <button type="submit" class="bg-[#D4AF37] text-[#800000] px-8 py-3 rounded-full font-bold">Kirim Pesanan</button>
            </div>
        </div>
    </form>
</div>

<script>
    const rawKatalogs = @json($katalogs);
    const rawSelectedItem = @json($item);
    const rawZonaLokasis = @json($zonaLokasis);

    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            step: 1,
            eventLocation: 'di_tempat_kami',
            paymentMethod: 'dp',
            katalogList: rawKatalogs || [],
            zonaLokasis: rawZonaLokasis || [],
            selectedKatalogId: rawSelectedItem ? rawSelectedItem.id : '',
            katalogPrice: rawSelectedItem ? parseFloat(rawSelectedItem.price) : 0,
            katalogCategory: rawSelectedItem ? rawSelectedItem.category : '',
            selectedZonaId: '',

            initForm() { if(this.selectedKatalogId) this.updateKatalog(); },
            updateKatalog() {
                const k = this.katalogList.find(x => x.id == this.selectedKatalogId);
                if(k) { this.katalogPrice = parseFloat(k.price); this.katalogCategory = k.category; }
            },
            get ongkosKirim() { return (this.eventLocation === 'di_luar' && this.selectedZonaId) ? parseFloat(this.zonaLokasis.find(z => z.id == this.selectedZonaId)?.tarif || 0) : 0; },
            get grandTotal() { return this.katalogPrice + this.ongkosKirim; },
            formatRupiah(n) { return new Intl.NumberFormat('id-ID').format(n || 0); },
            nextStep() { this.step++; window.scrollTo({top:0, behavior:'smooth'}); },
            prevStep() { this.step--; window.scrollTo({top:0, behavior:'smooth'}); }
        }))
    })
</script>
@endsection