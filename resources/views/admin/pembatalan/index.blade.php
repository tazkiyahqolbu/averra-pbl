@extends('admin.layouts.app')

@section('title', 'Permintaan Pembatalan')

@section('content')
<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-3xl">Permintaan Pembatalan</h1>
            <p class="admin-subtitle mt-1 text-sm">Daftar permintaan pembatalan dari customer.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-3 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @php
        $menunggu  = $pembatalans->where('status', 'menunggu');
        $diproses  = $pembatalans->whereIn('status', ['disetujui', 'ditolak']);
    @endphp

    {{-- Menunggu --}}
    @if($menunggu->isNotEmpty())
        <div class="space-y-3">
            <h2 class="admin-title text-lg">Menunggu Tinjauan ({{ $menunggu->count() }})</h2>
            @foreach($menunggu as $item)
                <div class="admin-card p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="badge-warning text-xs">Menunggu</span>
                            <span class="text-sm font-semibold text-[#4A0F1A]">#{{ $item->pemesanan->kode_pemesanan }}</span>
                        </div>
                        <p class="text-sm text-[#4A2E28]">{{ $item->user->name }}</p>
                        <p class="text-xs admin-muted">Diajukan: {{ $item->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-[#4A2E28]/70 line-clamp-2">{{ $item->alasan }}</p>
                    </div>
                    <a href="{{ route('admin.pembatalan.show', $item->id) }}"
                       class="admin-btn-primary shrink-0 text-sm">
                        Tinjau
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Sudah Diproses --}}
    @if($diproses->isNotEmpty())
        <div class="space-y-3 mt-6">
            <h2 class="admin-title text-lg">Sudah Diproses ({{ $diproses->count() }})</h2>
            @foreach($diproses as $item)
                <div class="admin-card p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 opacity-80">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            @if($item->status === 'disetujui')
                                <span class="badge-active text-xs">Disetujui</span>
                            @else
                                <span class="badge-inactive text-xs">Ditolak</span>
                            @endif
                            <span class="text-sm font-semibold text-[#4A0F1A]">#{{ $item->pemesanan->kode_pemesanan }}</span>
                        </div>
                        <p class="text-sm text-[#4A2E28]">{{ $item->user->name }}</p>
                        <p class="text-xs admin-muted">Diproses: {{ $item->diproses_pada?->format('d M Y, H:i') ?? '-' }}</p>
                    </div>
                    <a href="{{ route('admin.pembatalan.show', $item->id) }}"
                       class="admin-btn-secondary shrink-0 text-sm">
                        Detail
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    @if($pembatalans->isEmpty())
        <div class="admin-card p-12 text-center">
            <i data-lucide="inbox" class="h-10 w-10 mx-auto text-[#C8960C] opacity-40 mb-3"></i>
            <p class="text-[#4A2E28]/60 text-sm">Belum ada permintaan pembatalan.</p>
        </div>
    @endif
</div>
@endsection
