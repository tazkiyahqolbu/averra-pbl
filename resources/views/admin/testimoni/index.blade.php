@extends('admin.layouts.app')

@section('title', 'Testimoni')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Testimoni Customer</h1>
        <p class="admin-subtitle mt-1 text-sm">Pantau ulasan pelanggan dan balas testimoni.</p>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistik & Filter --}}
    <div class="admin-card p-5">
        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label class="admin-label">Filter Rating</label>
                <select id="filter-rating" class="admin-select" onchange="filterTestimoni()">
                    <option value="">Semua</option>
                    @for($r = 5; $r >= 1; $r--)
                        <option value="{{ $r }}">{{ $r }} Bintang</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="admin-label">Cari Nama</label>
                <input type="text" id="filter-nama" class="admin-input" placeholder="Nama pelanggan…"
                       oninput="filterTestimoni()">
            </div>
            <div class="rounded-2xl bg-[#FAF3E0] p-4">
                <p class="admin-muted text-sm">Rata-rata Rating</p>
                <p class="font-heading text-2xl font-bold text-[#4A0F1A]">
                    <span class="text-amber-400">★</span>
                    {{ $rataRating ?: '-' }}
                    <span class="text-base font-normal admin-muted">dari {{ $totalUlasan }} ulasan</span>
                </p>
            </div>
        </div>
    </div>

    {{-- List Testimoni --}}
    <div class="space-y-4" id="testimoni-list">
        @forelse($testimonis as $t)
            @php
                $detail    = $t->pemesanan?->detailPemesanans->first();
                $namaItem  = $detail?->jasa?->nama_jasa
                          ?? $detail?->paket?->nama_paket
                          ?? $detail?->barang?->nama_barang
                          ?? '-';
            @endphp
            <div class="admin-card p-5 testimoni-item"
                 data-rating="{{ $t->rating }}"
                 data-nama="{{ strtolower($t->user?->nama ?? '') }}">

                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <div class="mb-1 flex items-center gap-2 flex-wrap">
                            <span class="text-base">
                                <span class="text-amber-400">{{ str_repeat('★', $t->rating) }}</span><span class="text-[#E2D4C0]">{{ str_repeat('★', 5 - $t->rating) }}</span>
                            </span>
                            <strong class="text-[#4A0F1A]">{{ $t->user?->nama ?? '-' }}</strong>
                            @if($t->dibalas)
                                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">Sudah Dibalas</span>
                            @endif
                        </div>
                        <p class="admin-muted text-sm">{{ $namaItem }} | {{ $t->created_at->format('d M Y') }}</p>
                    </div>
                    <button type="button"
                            onclick="bukaDetail({{ $t->id }})"
                            class="shrink-0 rounded-xl border border-[#E2D4C0] px-4 py-1.5 text-xs font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                        Lihat Detail &amp; Balas
                    </button>
                </div>

                <p class="mt-3 text-sm leading-6 text-[#4A2E28]">"{{ $t->isi_testimoni }}"</p>

                {{-- Preview foto (maks 4) --}}
                @if($t->fotos->isNotEmpty())
                    <div class="mt-3 flex gap-2 flex-wrap">
                        @foreach($t->fotos->take(4) as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}"
                                 alt="foto testimoni"
                                 class="h-16 w-16 rounded-xl object-cover border border-[#E2D4C0] cursor-pointer hover:opacity-80 transition"
                                 onclick="bukaDetail({{ $t->id }})">
                        @endforeach
                        @if($t->fotos->count() > 4)
                            <button type="button"
                                    onclick="bukaDetail({{ $t->id }})"
                                    class="flex h-16 w-16 items-center justify-center rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] text-xs font-semibold text-[#4A2E28] hover:bg-[#F0E8D0] transition">
                                +{{ $t->fotos->count() - 4 }}
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Balasan admin (preview) --}}
                @if($t->dibalas)
                    <div class="mt-3 rounded-xl border-l-4 border-[#C8960C] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A2E28]">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#C8960C] mb-1">Balasan Admin</p>
                        {{ Str::limit($t->dibalas, 120) }}
                    </div>
                @endif
            </div>
        @empty
            <div class="admin-card p-10 text-center admin-muted">
                Belum ada testimoni dari pelanggan.
            </div>
        @endforelse
    </div>
</div>

{{-- ── Modal Detail Testimoni ── --}}
<div id="modal-testimoni" class="hidden fixed inset-0 z-50 flex items-start justify-center bg-black/60 px-4 py-10 overflow-y-auto">
    <div class="w-full max-w-xl rounded-3xl bg-white shadow-2xl my-auto" id="modal-body">
        {{-- diisi JS --}}
    </div>
</div>

@php
    $jsTestimoni = $testimonis->map(function ($t) {
        $detail   = $t->pemesanan?->detailPemesanans->first();
        $namaItem = $detail?->jasa?->nama_jasa
                  ?? $detail?->paket?->nama_paket
                  ?? $detail?->barang?->nama_barang
                  ?? '-';
        return [
            'id'        => $t->id,
            'nama'      => $t->user?->nama ?? '-',
            'rating'    => $t->rating,
            'item'      => $namaItem,
            'tanggal'   => $t->created_at->format('d M Y'),
            'ulasan'    => $t->isi_testimoni,
            'dibalas'   => $t->dibalas,
            'fotos'     => $t->fotos->map(fn($f) => asset('storage/' . $f->foto_path))->values(),
            'balas_url' => route('admin.testimoni.balas', $t->id),
        ];
    });
@endphp
<script>
const testimoniData = @json($jsTestimoni);

function bukaDetail(id) {
    const t = testimoniData.find(x => x.id === id);
    if (!t) return;

    const bintangKuning = '★'.repeat(t.rating);
    const bintangAbu    = '☆'.repeat(5 - t.rating);

    let fotosHtml = '';
    if (t.fotos.length > 0) {
        const gambar = t.fotos.map(url => {
            const ext = url.split('.').pop().toLowerCase();
            if (['mp4', 'webm', 'mov'].includes(ext)) {
                return `<video src="${url}" controls class="h-32 w-32 rounded-xl object-cover border border-[#E2D4C0]"></video>`;
            }
            return `<img src="${url}" class="h-32 w-32 rounded-xl object-cover border border-[#E2D4C0] cursor-pointer" onclick="window.open('${url}','_blank')" alt="">`;
        }).join('');
        fotosHtml = `<div>
            <p class="text-[10px] font-semibold uppercase tracking-wider text-[#C8960C] mb-2">Foto / Video (${t.fotos.length})</p>
            <div class="flex flex-wrap gap-2">${gambar}</div>
        </div>`;
    }

    const balasanLama = t.dibalas
        ? `<div class="rounded-xl border-l-4 border-[#C8960C] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A2E28] mb-4">
               <p class="text-[10px] font-semibold uppercase tracking-wider text-[#C8960C] mb-1">Balasan Sebelumnya</p>
               ${escapeHtml(t.dibalas)}
           </div>`
        : '';

    document.getElementById('modal-body').innerHTML = `
        <div class="p-6 border-b border-[#E2D4C0] flex items-center justify-between">
            <div>
                <span class="text-lg text-amber-400">${bintangKuning}</span><span class="text-lg text-[#E2D4C0]">${bintangAbu}</span>
                <strong class="ml-2 text-[#4A0F1A]">${escapeHtml(t.nama)}</strong>
            </div>
            <button onclick="tutupDetail()" class="text-xl text-[#4A2E28]/40 hover:text-[#4A0F1A] transition leading-none">✕</button>
        </div>
        <div class="p-6 space-y-5">
            <p class="text-xs admin-muted">${escapeHtml(t.item)} | ${escapeHtml(t.tanggal)}</p>
            <p class="text-sm leading-6 text-[#4A2E28] italic">"${escapeHtml(t.ulasan)}"</p>
            ${fotosHtml}
            ${balasanLama}
            <form method="POST" action="${t.balas_url}" class="space-y-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PATCH">
                <label class="block text-[10px] font-semibold uppercase tracking-wider text-[#4A0F1A]">
                    ${t.dibalas ? 'Ubah Balasan' : 'Tulis Balasan'}
                </label>
                <textarea name="dibalas" rows="3" required maxlength="1000"
                          class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0] px-4 py-3 text-sm text-[#4A0F1A] focus:border-[#C8960C] focus:outline-none transition resize-none"
                          placeholder="Tulis balasan untuk pelanggan…">${escapeHtml(t.dibalas || '')}</textarea>
                <button type="submit"
                        class="w-full rounded-xl bg-[#4A0F1A] py-2.5 text-sm font-semibold text-[#FAF3E0] hover:bg-[#7B1C2E] transition">
                    Simpan Balasan
                </button>
            </form>
        </div>
    `;

    document.getElementById('modal-testimoni').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function tutupDetail() {
    document.getElementById('modal-testimoni').classList.add('hidden');
    document.body.style.overflow = '';
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

document.getElementById('modal-testimoni').addEventListener('click', function(e) {
    if (e.target === this) tutupDetail();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupDetail();
});

function filterTestimoni() {
    const rating = document.getElementById('filter-rating').value;
    const nama   = document.getElementById('filter-nama').value.toLowerCase().trim();
    document.querySelectorAll('.testimoni-item').forEach(el => {
        const cocokRating = !rating || el.dataset.rating === rating;
        const cocokNama   = !nama   || el.dataset.nama.includes(nama);
        el.style.display  = (cocokRating && cocokNama) ? '' : 'none';
    });
}
</script>
@endsection
