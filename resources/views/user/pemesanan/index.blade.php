@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-border p-6 shadow-soft">
    <h2 class="text-2xl font-semibold text-gray-900">Riwayat Pemesanan</h2>

    @if(empty($pemesanan) || $pemesanan->isEmpty())
        <p class="mt-4 text-sm text-muted-foreground">Belum ada riwayat pemesanan.</p>
    @else
        <div class="mt-5 grid gap-3">
            @foreach ($pemesanan as $p)
                <div class="rounded-2xl border border-border p-5 flex justify-between items-center shadow-sm hover:shadow-md transition">
                    <div>
                        <p class="font-semibold text-gray-900">
                            {{ $p->jenis }}
                            <span class="text-xs text-muted-foreground font-normal">· {{ $p->kode_pemesanan ?? $p->id }}</span>
                        </p>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ $p->tanggal_pakai ?? $p->tanggal_pemesanan }} · {{ $p->lokasi }}
                        </p>
                    </div>
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700">
                        {{ $p->status }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
