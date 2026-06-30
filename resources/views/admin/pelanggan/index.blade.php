@extends('admin.layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-title text-3xl">Data Pelanggan</h1>
            <p class="admin-subtitle mt-1 text-sm">Daftar akun pelanggan yang terdaftar di sistem.</p>
        </div>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-[#E2D4C0] text-left text-xs font-semibold uppercase tracking-widest text-[#4A2E28]/50">
                    <th class="px-5 py-3">Pelanggan</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="hidden sm:table-cell px-5 py-3">No. HP</th>
                    <th class="px-5 py-3 text-center">Pesanan</th>
                    <th class="hidden md:table-cell px-5 py-3">Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E2D4C0]/60">
                @forelse ($pelanggan as $user)
                    <tr class="hover:bg-[#FAF3E0]/40 transition">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#4A0F1A]/10 text-sm font-bold text-[#4A0F1A]">
                                    {{ strtoupper(substr($user->nama ?? $user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="font-medium text-[#4A0F1A]">{{ $user->nama ?? $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-[#4A2E28] text-xs sm:text-sm">{{ $user->email }}</td>
                        <td class="hidden sm:table-cell px-5 py-3 text-[#4A2E28]">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="rounded-full bg-[#4A0F1A]/10 px-3 py-1 text-xs font-semibold text-[#4A0F1A]">
                                {{ $user->pemesanans_count }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-5 py-3 text-[#4A2E28]">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-[#4A2E28]/50 font-medium">
                            Belum ada pelanggan terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div>
        {{ $pelanggan->links() }}
    </div>
</div>
@endsection
