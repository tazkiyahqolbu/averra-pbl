@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-gray-200 p-6 md:p-8 shadow-sm max-w-5xl mx-auto my-10">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('user.pemesanan.pilihjenis') }}" class="hover:text-red-800 transition">Pilih Jenis</a>
        <span>•</span>
        <span class="text-gray-900 font-medium">Form Sewa Barang</span>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Sewa Barang</h2>

    <form action="{{ route('user.pemesanan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kategori_order" value="sewa">

        <div class="space-y-6">
            {{-- Section Daftar Barang --}}
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-3">Daftar Barang Sewaan</label>
                
                {{-- Container Baris Barang --}}
                <div id="wrapper-barang" class="space-y-4">
                    {{-- Baris Pertama (Template Row) --}}
                    <div class="baris-barang bg-gray-50 border border-gray-200 rounded-2xl p-4 flex flex-col lg:flex-row items-stretch lg:items-end gap-4 relative">
                        
                        {{-- Nama Barang --}}
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Barang</label>
                            <select name="barang_id[]" class="barang-select w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm bg-white text-gray-900 focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none" required>
                                <option value="" data-harga="0">-- Pilih Barang --</option>
                                @foreach($items as $b)
                                    <option value="{{ $b->id }}" data-harga="{{ $b->price }}">
                                        {{ $b->name }} (Rp {{ number_format($b->price, 0, ',', '.') }}/hari)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="w-full lg:w-24">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah</label>
                            <input type="number" name="jumlah[]" min="1" value="1" class="jumlah-input w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-center focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900" required>
                        </div>

                        {{-- Tanggal Ambil --}}
                        <div class="w-full lg:w-44">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Ambil</label>
                            <input type="date" name="tanggal_ambil[]" min="{{ date('Y-m-d') }}" class="tanggal-ambil w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900" required>
                        </div>

                        {{-- Tanggal Kembali --}}
                        <div class="w-full lg:w-44">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali[]" min="{{ date('Y-m-d') }}" class="tanggal-kembali w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900" required>
                        </div>

                        {{-- Subtotal --}}
                        <div class="w-full lg:w-40">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Subtotal</label>
                            <input type="text" class="subtotal-display w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm font-bold text-gray-700 outline-none" value="Rp 0" readonly>
                        </div>

                        {{-- Tombol Hapus Baris --}}
                        <div class="absolute top-2 right-2 lg:static lg:top-auto lg:right-auto flex items-center justify-center">
                            <button type="button" onclick="hapusBarisBarang(this)" class="btn-hapus hidden p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Barang">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tombol Tambah --}}
                <button type="button" onclick="tambahBarisBarang()" class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-red-800 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition">
                    ✨ + Tambah Barang Baru
                </button>
            </div>

            <hr class="border-gray-200 my-6">

            {{-- Alamat & Zona Lokasi --}}
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman (Opsional)</label>
                    <input type="text" name="lokasi" placeholder="Kosongkan jika ambil sendiri ke store" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zona Lokasi Pengantaran (Opsional)</label>
                    <select id="zona_id" name="zona_id" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm bg-white text-gray-900 focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none">
                        <option value="" data-ongkos="0">Ambil Sendiri — Gratis</option>
                        @foreach($zonas as $zona)
                            <option value="{{ $zona->id }}" data-ongkos="{{ $zona->tarif }}">
                                {{ $zona->nama_zona }} — [ Rp {{ number_format($zona->tarif, 0, ',', '.') }} ]
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- No HP & Catatan --}}
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp Aktif</label>
                    <input type="tel" name="no_hp" placeholder="Contoh: 081234567890" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="1" placeholder="Warna kostum, detail ukuran, dll..." class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-red-800/20 focus:border-red-800 outline-none text-gray-900 resize-none"></textarea>
                </div>
            </div>

            {{-- Footer Total Harga --}}
            <div class="border-t border-gray-200 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/50 p-4 rounded-2xl">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Ongkos Lokasi</span>
                    <input type="text" id="ongkos_display" class="text-base font-bold text-gray-800 bg-transparent outline-none" value="Rp 0" readonly>
                    <input type="hidden" id="ongkos_lokasi" name="ongkos_lokasi" value="0">
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <span class="block text-sm font-bold text-red-800 uppercase tracking-wider">Total Keseluruhan</span>
                    <input type="text" id="total_display" class="text-3xl font-black text-red-800 bg-transparent sm:text-right outline-none w-full sm:w-64" value="Rp 0" readonly>
                    <input type="hidden" id="total_harga" name="total_harga" value="0">
                </div>
            </div>

            {{-- Button Submit --}}
            <div class="pt-2">
                <button type="submit" class="w-full sm:w-auto rounded-xl bg-red-800 text-white px-8 py-3.5 font-semibold hover:bg-red-900 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-red-800/50">
                    Buat Pemesanan Sewa
                </button>
            </div>
        </div>
    </form>
</div>

{{-- JAVASCRIPT PERHITUNGAN OTOMATIS BERSIH & FIX BUG --}}
<script>
function hitungSemua() {
    let totalBarang = 0;
    const baris = document.querySelectorAll('.baris-barang');

    baris.forEach(row => {
        const select = row.querySelector('.barang-select');
        const jumlahInput = row.querySelector('.jumlah-input');
        const tglAmbil = row.querySelector('.tanggal-ambil');
        const tglKembali = row.querySelector('.tanggal-kembali');
        const subtotalDisplay = row.querySelector('.subtotal-display');

        const harga = parseInt(select.options[select.selectedIndex].getAttribute('data-harga')) || 0;
        const qty = parseInt(jumlahInput.value) || 1;

        // Hitung durasi hari sewa
        let jumlahHari = 1;
        if (tglAmbil && tglAmbil.value && tglKembali && tglKembali.value) {
            const date1 = new Date(tglAmbil.value);
            const date2 = new Date(tglKembali.value);
            const selisihWaktu = date2.getTime() - date1.getTime();
            if (selisihWaktu > 0) {
                jumlahHari = Math.ceil(selisihWaktu / (1000 * 3600 * 24));
            }
        }

        const subtotal = harga * qty * jumlahHari;
        totalBarang += subtotal;
        subtotalDisplay.value = "Rp " + subtotal.toLocaleString('id-ID');
    });

    const zonaSelect = document.getElementById('zona_id');
    const ongkos = parseInt(zonaSelect.options[zonaSelect.selectedIndex].getAttribute('data-ongkos')) || 0;
    
    const totalAkhir = totalBarang + ongkos;

    document.getElementById('ongkos_display').value = "Rp " + ongkos.toLocaleString('id-ID');
    document.getElementById('ongkos_lokasi').value = ongkos;

    document.getElementById('total_display').value = "Rp " + totalAkhir.toLocaleString('id-ID');
    document.getElementById('total_harga').value = totalAkhir;
}

function tambahBarisBarang() {
    const wrapper = document.getElementById('wrapper-barang');
    const barisArr = document.querySelectorAll('.baris-barang');
    
    // Klone dari baris index pertama
    const barisBaru = barisArr[0].cloneNode(true);

    // Bersihkan nilai inputan dalam kloningan baru
    barisBaru.querySelectorAll('input').forEach(input => {
        if(input.classList.contains('jumlah-input')) {
            input.value = '1';
        } else if(!input.classList.contains('subtotal-display')) {
            input.value = '';
        }
    });
    
    // Reset drop-down
    barisBaru.querySelector('.barang-select').selectedIndex = 0;
    barisBaru.querySelector('.subtotal-display').value = 'Rp 0';

    // Munculkan ikon tong sampah pembatal khusus baris tambahan baru
    const btnHapus = barisBaru.querySelector('.btn-hapus');
    btnHapus.classList.remove('hidden');

    wrapper.appendChild(barisBaru);
    
    // Kaitkan ulang event listener ke element yang baru terbuat
    pasangEvent();
    hitungSemua();
}

function hapusBarisBarang(btn) {
    btn.closest('.baris-barang').remove();
    hitungSemua();
}

function pasangEvent() {
    document.querySelectorAll('.barang-select, .jumlah-input, .tanggal-ambil, .tanggal-kembali').forEach(el => {
        // Hilangkan event lama agar tidak menumpuk duplikasi memori, lalu pasang ulang
        el.removeEventListener('change', hitungSemua);
        el.removeEventListener('input', hitungSemua);
        el.addEventListener('change', hitungSemua);
        el.addEventListener('input', hitungSemua);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('zona_id').addEventListener('change', hitungSemua);
    pasangEvent();
    hitungSemua();
});
</script>
@endsection