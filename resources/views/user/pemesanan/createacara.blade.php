<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pemesanan — Sanggar Rantiang Tagok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF3E0] text-[#4A0F1A] antialiased">

    @include('public.layouts.navbar')

    <div class="mx-auto max-w-2xl px-6 pt-32 pb-24">

        {{-- Back --}}
        <div class="mb-8">
            @if($item)
                <a href="{{ route('katalog.show', $item['id']) }}"
                   class="inline-flex items-center gap-1.5 text-sm font-medium text-[#C8960C] hover:text-[#B8983A] transition">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Detail
                </a>
            @else
                <a href="{{ route('public.katalog.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-medium text-[#C8960C] hover:text-[#B8983A] transition">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Katalog
                </a>
            @endif
        </div>

        {{-- Judul --}}
        <div class="mb-8">
            <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— PEMESANAN LAYANAN —</p>
            <h1 class="mt-1 font-serif text-3xl font-light text-[#4A0F1A] md:text-4xl">Formulir Paket Acara</h1>
            <div class="mt-3 h-[1px] w-20 bg-gradient-to-r from-[#C8960C] to-transparent"></div>
        </div>

        {{-- Error --}}
        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-semibold mb-1">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div x-data="orderForm()" x-init="initForm">

            {{-- ── Stepper ── --}}
            <div class="mb-8 px-2">
                <div class="relative flex items-start justify-between">
                    {{-- Garis latar --}}
                    <div class="absolute left-5 right-5 top-5 h-[1px] bg-[#E2D4C0] -translate-y-1/2 z-0"></div>
                    {{-- Garis progres aktif --}}
                    <div class="absolute left-5 top-5 h-[1px] bg-[#C8960C] -translate-y-1/2 z-0 transition-all duration-500"
                         :style="'width: calc(' + ((step - 1) / 2 * 100) + '% - ' + ((step - 1) / 2 * 40) + 'px)'"></div>

                    @foreach ([['Detail Pesanan','1'], ['Lokasi','2'], ['Ringkasan','3']] as [$label, $num])
                        <div class="relative z-10 flex flex-col items-center gap-2 w-20">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 text-sm font-bold transition-all duration-300"
                                 :class="step >= {{ $num }} ? 'bg-[#4A0F1A] text-[#FAF3E0] border-[#4A0F1A] shadow-md' : 'bg-[#FFFDF7] text-[#4A2E28]/40 border-[#E2D4C0]'">
                                <span x-text="step > {{ $num }} ? '✓' : '{{ $num }}'"></span>
                            </div>
                            <span class="font-serif text-[11px] text-center leading-tight transition-colors duration-300"
                                  :class="step >= {{ $num }} ? 'text-[#4A0F1A] font-semibold' : 'text-[#4A2E28]/40'">
                                {{ $label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Form ── --}}
            <form action="{{ route('user.pemesanan.store') }}" method="POST"
                  class="rounded-3xl border border-[#E2D4C0] bg-[#FFFDF7] shadow-sm overflow-hidden">
                @csrf
                <input type="hidden" name="kategori_order" x-model="katalogCategory">
                <input type="hidden" name="total_harga" x-model="grandTotal">

                {{-- ── STEP 1: Detail Pesanan ── --}}
                <div x-show="step === 1" x-transition.opacity>
                    <div class="border-b border-[#E2D4C0] px-7 pt-7 pb-5">
                        <p class="text-[10px] tracking-[0.3em] text-[#C8960C] uppercase font-semibold">Langkah 1 dari 3</p>
                        <h3 class="mt-0.5 font-serif text-xl font-medium text-[#4A0F1A]">Detail Pesanan</h3>
                    </div>

                    <div class="space-y-5 p-7">
                        {{-- Item dipilih --}}
                        @if($item)
                            <input type="hidden" name="katalog_id" value="{{ $item['id'] }}">
                            <div>
                                <p class="mb-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">Layanan Dipilih</p>
                                <div class="flex items-center justify-between gap-4 rounded-2xl border border-[#C8960C]/40 bg-gradient-to-br from-[#FAF3E0] to-[#FBF6EC] px-5 py-4">
                                    <div>
                                        <p class="font-serif text-lg font-medium text-[#4A0F1A]">{{ $item['name'] }}</p>
                                        <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-wider text-[#C8960C]">{{ $item['category'] }}</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="font-serif text-xl font-semibold text-[#C8960C]">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-[#4A2E28]">
                                    Layanan dari katalog. —
                                    <a href="{{ route('public.katalog.index') }}" class="text-[#C8960C] hover:underline">Pilih layanan lain</a>
                                </p>
                            </div>
                        @else
                            <div>
                                <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                    Pilih Paket / Jasa <span class="text-red-400">*</span>
                                </label>
                                <select name="katalog_id" x-model="selectedKatalogId" x-on:change="updateKatalog" required
                                        class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                    <option value="" disabled>Pilih layanan…</option>
                                    <template x-for="k in katalogList.filter(i => i.category !== 'Sewa Barang' && i.category !== 'Properti')" x-bind:key="k.id">
                                        <option x-bind:value="k.id" x-text="k.name + ' — Rp' + formatRupiah(k.price)"></option>
                                    </template>
                                </select>
                            </div>
                        @endif

                        <div x-show="currentOptionalItems.length > 0" x-cloak>
                            <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                Tambahan Opsional
                            </label>
                            <div class="space-y-2">
                                <template x-for="opt in currentOptionalItems" :key="opt.id">
                                    <label class="flex items-center justify-between gap-3 rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm cursor-pointer hover:border-[#C8960C]/50 transition">
                                        <span class="flex items-center gap-2">
                                            <input type="checkbox" name="opsional_ids[]" :value="opt.id" x-model="selectedOpsionalIds"
                                                   class="rounded border-[#E2D4C0] text-[#C8960C] focus:ring-[#C8960C]">
                                            <span x-text="opt.nama_item" class="text-[#4A0F1A]"></span>
                                        </span>
                                        <span class="font-semibold text-[#C8960C]" x-text="'+ Rp' + formatRupiah(opt.harga_tambahan)"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                Tanggal Pelaksanaan <span class="text-red-400">*</span>
                            </label>
                            <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" @change="cekTanggal($event)" required
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                        </div>

                        <div>
                            <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                Keterangan Acara
                                <span class="ml-1 normal-case text-[10px] font-normal text-[#4A2E28]/50">opsional</span>
                            </label>
                            <textarea rows="3" name="keterangan_acara"
                                      class="w-full resize-none rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] placeholder-[#4A2E28]/30 focus:border-[#C8960C] focus:outline-none transition"
                                      placeholder="Ceritakan tentang acara Anda — jenis, tema, dll."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end px-7 pb-7">
                        <button type="button" x-on:click="nextStep()" x-bind:disabled="!selectedKatalogId"
                                class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-7 py-3 font-serif font-semibold text-[#4A0F1A] shadow-sm transition duration-200 hover:scale-[1.02] disabled:opacity-40 disabled:scale-100 disabled:cursor-not-allowed">
                            Lanjut <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                {{-- ── STEP 2: Lokasi ── --}}
                <div x-show="step === 2" x-transition.opacity style="display:none">
                    <div class="border-b border-[#E2D4C0] px-7 pt-7 pb-5">
                        <p class="text-[10px] tracking-[0.3em] text-[#C8960C] uppercase font-semibold">Langkah 2 dari 3</p>
                        <h3 class="mt-0.5 font-serif text-xl font-medium text-[#4A0F1A]">Informasi & Lokasi</h3>
                    </div>

                    <div class="space-y-5 p-7">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                    Nama Pemesan <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="nama_pemesan" required
                                       value="{{ auth()->user()->nama ?? '' }}"
                                       class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                            </div>
                            <div>
                                <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                    No. HP <span class="text-red-400">*</span>
                                </label>
                                <input type="tel" name="no_hp" required
                                       value="{{ auth()->user()->no_hp ?? '' }}"
                                       class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                            </div>
                        </div>

                        <div>
                            <p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">Lokasi Pelaksanaan</p>
                            <div class="space-y-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] p-4">
                                <div>
                                    <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                        Zona Lokasi <span class="text-red-400">*</span>
                                    </label>
                                    <select name="zona_lokasi_id" x-model="selectedZonaId" required
                                            class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                        <option value="" disabled selected>Pilih zona lokasi acara…</option>
                                        <template x-for="z in zonaLokasis" x-bind:key="z.id">
                                            <option
                                            x-bind:value="z.id"
                                            x-text="z.nama_zona + ' (' + z.persentase + '%)'">
                                        </option>
                                        </template>
                                    </select>
                                </div>
                                <textarea name="alamat_lengkap" rows="3" required
                                          class="w-full resize-none rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] placeholder-[#4A2E28]/30 focus:border-[#C8960C] focus:outline-none transition"
                                          placeholder="Alamat lengkap lokasi pelaksanaan…"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-7 pb-7">
                        <button type="button" x-on:click="prevStep()"
                                class="inline-flex items-center gap-1.5 text-sm text-[#4A2E28] hover:text-[#4A0F1A] transition">
                            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                        </button>
                        <button type="button" x-on:click="nextStep()"
                                class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-7 py-3 font-serif font-semibold text-[#4A0F1A] shadow-sm transition duration-200 hover:scale-[1.02]">
                            Lanjut <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                {{-- ── STEP 3: Ringkasan ── --}}
                <div x-show="step === 3" x-transition.opacity style="display:none">
                    <div class="border-b border-[#E2D4C0] px-7 pt-7 pb-5">
                        <p class="text-[10px] tracking-[0.3em] text-[#C8960C] uppercase font-semibold">Langkah 3 dari 3</p>
                        <h3 class="mt-0.5 font-serif text-xl font-medium text-[#4A0F1A]">Ringkasan Pesanan</h3>
                    </div>

                    <div class="space-y-5 p-7">
                        {{-- Ringkasan harga --}}
                        <div class="overflow-hidden rounded-2xl border border-[#E2D4C0]">
                            <div class="flex items-center justify-between px-5 py-3.5 text-sm">
                                <span class="text-[#4A2E28]">Subtotal Layanan</span>
                                <span class="font-semibold text-[#4A0F1A]">Rp <span x-text="formatRupiah(katalogPrice)"></span></span>
                            </div>
                            <div class="flex items-center justify-between border-t border-[#E2D4C0] px-5 py-3.5 text-sm"
                                 x-show="opsionalTotal > 0">
                                <span class="text-[#4A2E28]">Tambahan Opsional</span>
                                <span class="font-semibold text-[#4A0F1A]">Rp <span x-text="formatRupiah(opsionalTotal)"></span></span>
                            </div>
                            <div class="flex items-center justify-between border-t border-[#E2D4C0] px-5 py-3.5 text-sm"
                                 x-show="ongkosKirim > 0">
                                <span class="text-[#4A2E28]">Biaya Transport</span>
                                <span class="font-semibold text-[#4A0F1A]">Rp <span x-text="formatRupiah(ongkosKirim)"></span></span>
                            </div>
                            <div class="flex items-center justify-between border-t border-[#C8960C]/30 bg-[#FAF3E0] px-5 py-4">
                                <span class="font-serif font-semibold text-[#4A0F1A]">Total</span>
                                <span class="font-serif text-2xl font-semibold text-[#C8960C]">Rp <span x-text="formatRupiah(grandTotal)"></span></span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex items-start gap-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-xs text-[#4A2E28]">
                            <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-[#C8960C]"></i>
                            <p>Pesanan akan dikonfirmasi admin dalam <strong>1×24 jam</strong>. Setelah dikonfirmasi, kamu dapat memilih metode pembayaran (DP 50% atau lunas) dan melanjutkan ke Midtrans.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-7 pb-7">
                        <button type="button" x-on:click="prevStep()"
                                class="inline-flex items-center gap-1.5 text-sm text-[#4A2E28] hover:text-[#4A0F1A] transition">
                            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-full bg-[#4A0F1A] px-7 py-3 font-serif font-semibold text-[#FAF3E0] shadow-sm transition duration-200 hover:bg-[#7B1C2E] hover:scale-[1.02]">
                            <i data-lucide="send" class="h-4 w-4"></i> Kirim Pesanan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @include('public.layouts.footer')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });

        const rawKatalogs      = @json($katalogs);
        const rawSelectedItem  = @json($item);
        const rawZonaLokasis   = @json($zonaLokasis);

        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', () => ({
                step: 1,
                blockedDates: [],
                paymentMethod: 'dp',
                katalogList:       rawKatalogs || [],
                zonaLokasis:       rawZonaLokasis || [],
                selectedKatalogId: rawSelectedItem ? rawSelectedItem.id : '',
                katalogPrice:      rawSelectedItem ? parseFloat(rawSelectedItem.price) : 0,
                katalogCategory:   rawSelectedItem ? rawSelectedItem.category : '',
                selectedZonaId:    '',
                selectedOpsionalIds: [],

                async initForm() {
                    if (this.selectedKatalogId)
                        this.updateKatalog();
                    const response = await fetch("{{ route('user.unavailable-dates') }}");
                    this.blockedDates = await response.json();
                },

                updateKatalog() {
                    const k = this.katalogList.find(x => x.id == this.selectedKatalogId);
                    if (k) { this.katalogPrice = parseFloat(k.price); this.katalogCategory = k.category; }
                    this.selectedOpsionalIds = [];
                },

                get currentOptionalItems() {
                    const k = this.katalogList.find(x => x.id === this.selectedKatalogId);
                    return (k && k.optionalItems) ? k.optionalItems : [];
                },
                get opsionalTotal() {
                    return this.selectedOpsionalIds.reduce((sum, id) => {
                        const opt = this.currentOptionalItems.find(o => o.id == id);
                        return sum + (opt ? parseFloat(opt.harga_tambahan) : 0);
                    }, 0);
                },
                get ongkosKirim() {
                const zona = this.zonaLokasis.find(
                    z => z.id == this.selectedZonaId
                );

                if (!zona)
                    return 0;

                return (this.katalogPrice + this.opsionalTotal) * (zona.persentase / 100);
            },
                get grandTotal() { return this.katalogPrice + this.opsionalTotal + this.ongkosKirim; },

                formatRupiah(n) { return new Intl.NumberFormat('id-ID').format(n || 0); },

                cekTanggal(event) {
                const tanggal = event.target.value;
                if (this.blockedDates.includes(tanggal)) {
                    alert("Tanggal ini tidak tersedia.");
                    event.target.value = "";
                }
            },

                nextStep() {

                // STEP 1
                if (this.step === 1) {

                    const tanggal = document.getElementById('tanggal_pelaksanaan').value;

                    if (!tanggal) {
                        alert("Silakan pilih tanggal pelaksanaan.");
                        return;
                    }

                    if (this.blockedDates.includes(tanggal)) {
                        alert("Tanggal tersebut sudah diblokir. Silakan pilih tanggal lain.");
                        return;
                    }
                }

                this.step++;
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            },
                prevStep() { this.step--; window.scrollTo({ top: 0, behavior: 'smooth' }); },
            }));
        });
    </script>

    {{-- ── Modal: Tinggalkan Halaman? ── --}}
    <div id="leave-modal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-xs rounded-2xl bg-white border border-[#E2D4C0] shadow-2xl p-6 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 border border-amber-200">
                <i data-lucide="alert-triangle" class="h-5 w-5 text-amber-500"></i>
            </div>
            <h3 class="font-serif text-lg font-light text-[#4A0F1A]">Tinggalkan halaman?</h3>
            <p class="mt-1 text-sm text-[#4A2E28]/60">Data yang sudah kamu isi akan hilang jika kamu meninggalkan halaman ini.</p>
            <div class="mt-5 flex gap-2">
                <button id="leave-cancel"
                        class="flex-1 rounded-full border border-[#E2D4C0] bg-white py-2.5 text-sm font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                    Tetap di Sini
                </button>
                <button id="leave-confirm"
                        class="flex-1 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] py-2.5 text-sm font-semibold text-[#4A0F1A] transition hover:scale-[1.02]">
                    Ya, Tinggalkan
                </button>
            </div>
        </div>
    </div>

    <script>
    (function () {
        let formDirty = false;
        let leaveTarget = null;
        const modal = document.getElementById('leave-modal');

        // Tandai form "kotor" ketika ada input dari user
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input',  () => { formDirty = true; });
            el.addEventListener('change', () => { formDirty = true; });
        });

        // Reset dirty saat form di-submit
        document.querySelector('form[method="POST"]')
            ?.addEventListener('submit', () => { formDirty = false; });

        // Dialog native browser: tombol back, refresh, tutup tab
        window.addEventListener('beforeunload', function (e) {
            if (!formDirty) return;
            e.preventDefault();
            e.returnValue = '';
        });

        // Intercept klik link navigasi
        document.addEventListener('click', function (e) {
            if (!formDirty) return;
            const link = e.target.closest('a[href]');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

            e.preventDefault();
            leaveTarget = href;
            modal.classList.remove('hidden');
        });

        document.getElementById('leave-cancel')?.addEventListener('click', () => {
            modal.classList.add('hidden');
            leaveTarget = null;
        });

        document.getElementById('leave-confirm')?.addEventListener('click', () => {
            formDirty = false;
            if (leaveTarget) window.location.href = leaveTarget;
        });

        modal?.addEventListener('click', function (e) {
            if (e.target === this) {
                modal.classList.add('hidden');
                leaveTarget = null;
            }
        });
    })();
    </script>
</body>
</html>
