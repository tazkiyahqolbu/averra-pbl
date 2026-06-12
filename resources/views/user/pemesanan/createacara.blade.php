@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-border p-6 shadow-soft max-w-3xl mx-auto">
    {{-- Navigasi Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('user.pemesanan.pilihjenis') }}" class="hover:text-maroon-deep">Pilih Jenis</a>
        <span>•</span>
        <span class="text-gray-900 font-medium">Form Booking Acara</span>
    </div>

    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Form Booking Acara</h2>

    <form action="{{ route('user.pemesanan.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kategori_order" value="acara">

        <div class="grid gap-5">
            {{-- 1. Pilihan Paket / Jasa Dinamis dari Database Seeder --}}
           {{-- 1. Pilihan Paket / Jasa Dinamis dari Database Seeder --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jasa atau Paket Acara</label>
    <select id="item_id" name="item_id" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none bg-white text-gray-900" required>
        <option value="" data-harga="0" disabled {{ is_null($selected_item) ? 'selected' : '' }}>
            -- Pilih Paket atau Jasa --
        </option>
        @foreach($items as $item)
            <option value="{{ $item->id }}" 
                data-harga="{{ $item->price }}"
                {{ (!is_null($selected_item) && $selected_item->id == $item->id) ? 'selected' : '' }}>
                {{ $item->name }} — [ Rp {{ number_format($item->price, 0, ',', '.') }} ]
            </option>
        @endforeach
    </select>
</div>

            {{-- 2. Tanggal Acara --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Acara</label>
                <input type="date" name="tanggal_pakai" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none" required>
            </div>

            {{-- 3. Alamat Acara (Input Teks) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Acara</label>
                <input type="text" name="lokasi" placeholder="Contoh: Gedung Serbaguna PNP, Padang" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none" required>
            </div>

           {{-- 4. Zona Lokasi Dinamis dari Database Seeder --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Zona Lokasi</label>
    <select id="zona_id" name="zona_id" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none bg-white text-gray-900" required>
        <option value="" data-ongkos="0" disabled selected>-- Pilih Zona Lokasi Acara --</option>
        @foreach($zonas as $zona)
            <option value="{{ $zona->id }}" data-ongkos="{{ $zona->tarif }}">
                {{ $zona->nama_zona }}
            </option>
        @endforeach
    </select>
</div>
            {{-- 5. Ongkos Lokasi (Read Only - Diisi otomatis via JavaScript) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ongkos Lokasi</label>
                <input type="text" id="ongkos_display" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-500 font-medium outline-none" value="Rp 0" readonly>
                <input type="hidden" id="ongkos_lokasi" name="ongkos_lokasi" value="0">
            </div>

            {{-- 6. No HP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP / WhatsApp Aktif</label>
                <input type="text" name="no_hp" placeholder="Contoh: 081234567890" class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none" required>
            </div>

            {{-- 7. Catatan (Textarea Opsional) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="3" placeholder="Tulis catatan atau instruksi khusus di sini..." class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:border-maroon-deep outline-none"></textarea>
            </div>

            {{-- 8. Total Harga (Read Only - Otomatis dihitung JavaScript) --}}
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-bold text-maroon-deep mb-1">Total Harga Pemesanan</label>
                <input type="text" id="total_display" class="w-full rounded-xl border border-maroon-deep/20 bg-maroon-deep/5 px-4 py-3 text-xl font-bold text-maroon-deep outline-none" value="Rp 0" readonly>
                <input type="hidden" id="total_harga" name="total_harga" value="0">
            </div>

            {{-- Tombol Buat Pemesanan --}}
            <div class="pt-2">
                <button type="submit" class="w-full sm:w-auto rounded-xl bg-maroon-deep text-white px-8 py-3.5 font-medium hover:opacity-90 transition shadow-sm">
                    Buat Pemesanan
                </button>
            </div>
        </div>
    </form>
</div>

{{-- JAVASCRIPT HITUNG OTOMATIS (Sesuai Panduan Dani) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemSelect = document.getElementById('item_id');
    const zonaSelect = document.getElementById('zona_id');
    const ongkosDisplay = document.getElementById('ongkos_display');
    const ongkosHidden = document.getElementById('ongkos_lokasi');
    const totalDisplay = document.getElementById('total_display');
    const totalHidden = document.getElementById('total_harga');

    function hitungTotal() {
        // Mengambil data-harga dari paket yang dipilih
        const hargaItem = parseInt(itemSelect.options[itemSelect.selectedIndex].getAttribute('data-harga')) || 0;
        
        // Mengambil data-ongkos dari zona lokasi yang dipilih
        const ongkosLokasi = parseInt(zonaSelect.options[zonaSelect.selectedIndex].getAttribute('data-ongkos')) || 0;
        
        // Hitung total harga keseluruhan
        const total = hargaItem + ongkosLokasi;

        // Render hasil hitungan ke tampilan dalam format mata uang Rupiah
        ongkosDisplay.value = "Rp " + ongkosLokasi.toLocaleString('id-ID');
        ongkosHidden.value = ongkosLokasi;

        totalDisplay.value = "Rp " + total.toLocaleString('id-ID');
        totalHidden.value = total;
    }

    // Pasang event listener agar berubah secara real-time saat dropdown diganti
    itemSelect.addEventListener('change', hitungTotal);
    zonaSelect.addEventListener('change', hitungTotal);

    // Jalankan fungsi satu kali di awal untuk mendeteksi item jika diklik langsung dari katalog
    hitungTotal();
});
</script>
@endsection