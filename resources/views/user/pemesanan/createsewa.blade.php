<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Barang — Sanggar Rantiang Tagok</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3" defer></script>
</head>
<body class="bg-[#FAF3E0] font-sans">

    @include('public.layouts.header')

    <div class="min-h-screen py-16 px-4">
        <div class="max-w-lg mx-auto">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— FORM PEMESANAN —</p>
                <h1 class="mt-1 font-serif text-3xl font-light text-[#4A0F1A]">Sewa Barang</h1>
                <p class="mt-2 text-sm text-[#4A2E28]/60">Isi detail sewa, kemudian tinjau dan kirim pesanan.</p>
            </div>

            {{-- Progress steps --}}
            <div x-data="sewaForm()" x-init="initForm()">

                {{-- Step indicator --}}
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div class="flex items-center gap-1.5">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold transition"
                             :class="step >= 1 ? 'bg-[#4A0F1A] text-[#FAF3E0]' : 'bg-[#E2D4C0] text-[#4A2E28]'">1</div>
                        <span class="text-xs font-medium" :class="step >= 1 ? 'text-[#4A0F1A]' : 'text-[#4A2E28]/50'">Detail Sewa</span>
                    </div>
                    <div class="h-px w-8 bg-[#E2D4C0] mx-1"></div>
                    <div class="flex items-center gap-1.5">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold transition"
                             :class="step >= 2 ? 'bg-[#4A0F1A] text-[#FAF3E0]' : 'bg-[#E2D4C0] text-[#4A2E28]'">2</div>
                        <span class="text-xs font-medium" :class="step >= 2 ? 'text-[#4A0F1A]' : 'text-[#4A2E28]/50'">Ringkasan</span>
                    </div>
                </div>

                <div class="rounded-3xl border border-[#E2D4C0] bg-white shadow-[0_4px_24px_rgba(74,15,26,0.08)]">
                    <form method="POST" action="{{ route('user.pemesanan.store') }}">
                        @csrf
                        <input type="hidden" name="kategori_order" value="sewa">
                        <input type="hidden" name="total_harga" x-model="grandTotal">

                        {{-- ── STEP 1: Detail Sewa ── --}}
                        <div x-show="step === 1" x-transition.opacity>
                            <div class="border-b border-[#E2D4C0] px-7 pt-7 pb-5">
                                <p class="text-[10px] tracking-[0.3em] text-[#C8960C] uppercase font-semibold">Langkah 1 dari 2</p>
                                <h3 class="mt-0.5 font-serif text-xl font-medium text-[#4A0F1A]">Detail Sewa</h3>
                            </div>

                            <div class="space-y-5 p-7">
                                {{-- Item terpilih --}}
                                @if($item)
                                    <input type="hidden" name="katalog_id" value="{{ $item['id'] }}">
                                    <div>
                                        <p class="mb-2 text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">Barang Dipilih</p>
                                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-[#C8960C]/40 bg-gradient-to-br from-[#FAF3E0] to-[#FBF6EC] px-5 py-4">
                                            <div>
                                                <p class="font-serif text-lg font-medium text-[#4A0F1A]">{{ $item['name'] }}</p>
                                                <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-wider text-[#C8960C]">Sewa Barang</p>
                                            </div>
                                            <div class="shrink-0 text-right">
                                                <p class="font-serif text-xl font-semibold text-[#C8960C]">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs text-[#4A2E28]">/ hari</p>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-xs text-[#4A2E28]">
                                            —
                                            <a href="{{ route('public.katalog.index') }}" class="text-[#C8960C] hover:underline">Pilih barang lain</a>
                                        </p>
                                    </div>
                                @else
                                    <div>
                                        <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                            Pilih Barang <span class="text-red-400">*</span>
                                        </label>
                                        <select name="katalog_id" x-model="selectedKatalogId" x-on:change="updateKatalog" required
                                                class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                            <option value="" disabled>Pilih barang sewa…</option>
                                            <template x-for="k in katalogList" x-bind:key="k.id">
                                                <option x-bind:value="k.id" x-text="k.name + ' — Rp' + formatRupiah(k.price) + '/hari'"></option>
                                            </template>
                                        </select>
                                    </div>
                                @endif

                                {{-- Durasi --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                            Tanggal Ambil <span class="text-red-400">*</span>
                                        </label>
                                        <input type="date" name="tanggal_ambil" x-model="startDate" required
                                               min="{{ date('Y-m-d') }}"
                                               class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                            Tanggal Kembali <span class="text-red-400">*</span>
                                        </label>
                                        <input type="date" name="tanggal_kembali" x-model="endDate"
                                               :min="startDate || ''"
                                               @change="if(startDate && endDate && endDate < startDate){ endDate = ''; }"
                                               required
                                               class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                        <p class="mt-1 text-xs text-red-500"
                                           x-show="startDate && endDate && endDate < startDate">
                                            Tanggal kembali tidak boleh sebelum tanggal ambil
                                        </p>
                                    </div>
                                </div>

                                <div class="sm:w-1/3">
                                    <label class="mb-2 block text-[10px] font-semibold uppercase tracking-[0.25em] text-[#4A0F1A]">
                                        Jumlah Unit <span class="text-red-400">*</span>
                                    </label>
                                    <input type="number" name="jumlah_unit" min="1" x-model="jumlahUnit" required
                                           class="w-full rounded-xl border border-[#E2D4C0] bg-white px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition">
                                </div>

                                {{-- Informasi pemesan --}}
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

                                {{-- Kalkulasi durasi --}}
                                <div class="flex items-center justify-between rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-5 py-3.5"
                                     x-show="startDate && endDate">
                                    <div class="text-sm text-[#4A2E28]">
                                        Durasi: <span class="font-semibold text-[#4A0F1A]" x-text="durationDays + ' hari'"></span>
                                        <span x-show="jumlahUnit > 1"> × <span x-text="jumlahUnit"></span> unit</span>
                                    </div>
                                    <div class="font-serif text-lg font-semibold text-[#C8960C]">
                                        Rp <span x-text="formatRupiah(grandTotal)"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end px-7 pb-7">
                                <button type="button"
                                        x-on:click="nextStep()"
                                        x-bind:disabled="!selectedKatalogId || !startDate || !endDate"
                                        class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#D6B35C] to-[#B8983A] px-7 py-3 font-serif font-semibold text-[#4A0F1A] shadow-sm transition duration-200 hover:scale-[1.02] disabled:opacity-40 disabled:scale-100 disabled:cursor-not-allowed">
                                    Lanjut <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </div>

                        {{-- ── STEP 2: Ringkasan ── --}}
                        <div x-show="step === 2" x-transition.opacity style="display:none">
                            <div class="border-b border-[#E2D4C0] px-7 pt-7 pb-5">
                                <p class="text-[10px] tracking-[0.3em] text-[#C8960C] uppercase font-semibold">Langkah 2 dari 2</p>
                                <h3 class="mt-0.5 font-serif text-xl font-medium text-[#4A0F1A]">Ringkasan Pesanan</h3>
                            </div>

                            <div class="space-y-5 p-7">
                                {{-- Ringkasan harga --}}
                                <div class="overflow-hidden rounded-2xl border border-[#E2D4C0]">
                                    <div class="flex items-center justify-between px-5 py-3.5 text-sm">
                                        <div class="text-[#4A2E28]">
                                            Biaya Sewa
                                            <span class="text-xs text-[#4A2E28]/60"
                                                  x-show="durationDays > 1 || jumlahUnit > 1">
                                                (<span x-text="durationDays"></span> hari
                                                <span x-show="jumlahUnit > 1"> × <span x-text="jumlahUnit"></span> unit</span>)
                                            </span>
                                        </div>
                                        <span class="font-semibold text-[#4A0F1A]">Rp <span x-text="formatRupiah(grandTotal)"></span></span>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-[#C8960C]/30 bg-[#FAF3E0] px-5 py-4">
                                        <span class="font-serif font-semibold text-[#4A0F1A]">Total</span>
                                        <span class="font-serif text-2xl font-semibold text-[#C8960C]">Rp <span x-text="formatRupiah(grandTotal)"></span></span>
                                    </div>
                                </div>

                                {{-- DP preview --}}
                                <div class="rounded-2xl border border-[#C8960C]/30 bg-[#FBF6EC] px-5 py-4 text-sm">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#C8960C] mb-2">Pembayaran DP (50%)</p>
                                    <p class="font-serif text-xl font-semibold text-[#4A0F1A]">Rp <span x-text="formatRupiah(Math.round(grandTotal * 0.5))"></span></p>
                                    <p class="mt-1 text-xs text-[#4A2E28]/60">Dibayar setelah admin konfirmasi pesanan. Sisa dilunasi setelah barang dikembalikan.</p>
                                </div>

                                {{-- Info ambil sendiri --}}
                                <div class="flex items-start gap-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-xs text-[#4A2E28]">
                                    <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-[#C8960C]"></i>
                                    <p>Pengambilan dan pengembalian barang dilakukan <strong>langsung ke sanggar</strong>. Admin akan menghubungi kamu melalui WhatsApp untuk konfirmasi jadwal.</p>
                                </div>

                                {{-- Info flow --}}
                                <div class="flex items-start gap-3 rounded-2xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-xs text-[#4A2E28]">
                                    <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-[#C8960C]"></i>
                                    <p>Pesanan akan dikonfirmasi admin dalam <strong>1×24 jam</strong>. Setelah dikonfirmasi, kamu akan menerima email tagihan DP untuk dibayar via Midtrans.</p>
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
        </div>
    </div>

    @include('public.layouts.footer')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        window.addEventListener('load', () => { lucide.createIcons(); });

        const rawKatalogs     = @json($katalogs);
        const rawSelectedItem = @json($item);

        document.addEventListener('alpine:init', () => {
            Alpine.data('sewaForm', () => ({
                step: 1,
                startDate: '', endDate: '', jumlahUnit: 1,
                katalogList:       rawKatalogs || [],
                selectedKatalogId: rawSelectedItem ? rawSelectedItem.id : '',
                katalogPrice:      rawSelectedItem ? parseFloat(rawSelectedItem.price) : 0,

                initForm() { if (this.selectedKatalogId) this.updateKatalog(); },

                updateKatalog() {
                    const k = this.katalogList.find(x => x.id == this.selectedKatalogId);
                    if (k) { this.katalogPrice = parseFloat(k.price); }
                },

                get durationDays() {
                    if (!this.startDate || !this.endDate) return 1;
                    const diff = new Date(this.endDate) - new Date(this.startDate);
                    const days = Math.ceil(diff / (1000 * 60 * 60 * 24)) + 1;
                    return days > 0 ? days : 1;
                },
                get grandTotal() { return this.katalogPrice * this.durationDays * (this.jumlahUnit || 1); },

                formatRupiah(n) { return new Intl.NumberFormat('id-ID').format(n || 0); },
                nextStep() { this.step++; window.scrollTo({ top: 0, behavior: 'smooth' }); },
                prevStep() { this.step--; window.scrollTo({ top: 0, behavior: 'smooth' }); },
            }));
        });
    </script>

    {{-- Modal: Tinggalkan Halaman? --}}
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
        let formDirty = false, leaveTarget = null;
        const modal = document.getElementById('leave-modal');
        document.querySelectorAll('input,select,textarea').forEach(el => {
            el.addEventListener('input',  () => { formDirty = true; });
            el.addEventListener('change', () => { formDirty = true; });
        });
        document.querySelector('form[method="POST"]')?.addEventListener('submit', () => { formDirty = false; });
        window.addEventListener('beforeunload', e => { if (!formDirty) return; e.preventDefault(); e.returnValue = ''; });
        document.addEventListener('click', e => {
            if (!formDirty) return;
            const link = e.target.closest('a[href]');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
            e.preventDefault(); leaveTarget = href; modal.classList.remove('hidden');
        });
        document.getElementById('leave-cancel')?.addEventListener('click', () => { modal.classList.add('hidden'); leaveTarget = null; });
        document.getElementById('leave-confirm')?.addEventListener('click', () => { formDirty = false; if (leaveTarget) window.location.href = leaveTarget; });
        modal?.addEventListener('click', e => { if (e.target === modal) { modal.classList.add('hidden'); leaveTarget = null; } });
    })();
    </script>
</body>
</html>