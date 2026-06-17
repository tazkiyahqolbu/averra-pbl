@extends('user.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 md:p-6 space-y-6">

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center text-xl font-bold text-red-800">
                {{ strtoupper(substr(($user?->nama ?? $user?->name ?? 'U'), 0, 1)) }}
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-900">{{ $user?->nama ?? '' }}</h2>
                <p class="text-sm text-gray-500">{{ $user?->email ?? '' }}</p>
            </div>
        </div>
        <a href="{{ route('user.profile.index') }}" class="text-sm font-semibold text-red-800 hover:underline">Edit Profil</a>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-900 uppercase text-xs tracking-wider">PEMESANAN SAYA</h3>
            <a href="{{ route('user.pemesanan.index') }}" class="text-xs font-semibold text-red-800">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-4 gap-2 text-center">
            @foreach([['Konfirmasi', $statusCounts['konfirmasi']], ['Pembayaran', $statusCounts['pembayaran']], ['Berlangsung', $statusCounts['berlangsung']], ['Selesai', $statusCounts['selesai']]] as $status)
            <div class="space-y-1">
                <div class="text-xl font-bold text-gray-900">{{ $status[1] }}</div>
                <div class="text-[10px] text-gray-500 uppercase leading-tight">{{ $status[0] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-gray-900 uppercase text-xs tracking-wider">PENGEMBALIAN BARANG</h3>
            <a href="{{ route('user.pemesanan.index') }}" class="text-xs font-semibold text-red-800">Lihat Semua →</a>
        </div>
        <p class="text-sm text-gray-600">{{ $statusCounts['pengembalian'] }} barang sedang dalam proses pengembalian</p>
    </div>

        </nav>
    </div>

</div>
@endsection
