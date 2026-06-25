@extends('user.layouts.app')

@section('content')
    {{-- Header --}}
    <div class="mb-7">
        <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— AKUN —</p>
        <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">Profil Saya</h1>
        <div class="mt-3 h-[1px] w-16 bg-gradient-to-r from-[#C8960C] to-transparent"></div>
    </div>

    <div x-data="{ isEditing: false, showSecurity: false }">

        {{-- Alert --}}
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                <i data-lucide="check-circle" class="h-4 w-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] overflow-hidden">
            <div class="grid lg:grid-cols-[240px_1fr]">

                {{-- Sisi kiri — Avatar --}}
                <div
                    class="flex flex-col items-center justify-start border-b border-[#E2D4C0] bg-[#FAF3E0]/70 px-6 py-8 lg:border-b-0 lg:border-r">

                    {{-- Avatar --}}
                    <div class="h-24 w-24 rounded-full overflow-hidden border-2 border-[#C8960C]/40 bg-[#4A0F1A] shadow-sm">
                        @if ($user && $user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil"
                                class="h-full w-full object-cover">
                        @else
                            <div
                                class="h-full w-full flex items-center justify-center text-[#FAF3E0] text-3xl font-serif font-light">
                                {{ strtoupper(substr($user?->nama ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h2 class="mt-4 font-serif text-lg font-medium text-[#4A0F1A] text-center">
                        {{ $user?->nama ?? '' }}
                    </h2>
                    <p class="text-xs text-[#4A2E28]/60 mt-1 break-all text-center">
                        {{ $user?->email ?? '' }}
                    </p>

                    {{-- Upload foto --}}
                    <form action="{{ route('user.profile.photo.update') }}" method="POST" enctype="multipart/form-data"
                        class="mt-5">
                        @csrf
                        @method('PUT')
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden"
                            accept=".jpg,.jpeg,.png" onchange="this.form.submit()">
                        <label for="profile_photo"
                            class="cursor-pointer inline-flex items-center gap-2 rounded-full border border-[#4A0F1A]/25 bg-white px-4 py-2 text-xs font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
                            <i data-lucide="camera" class="h-3.5 w-3.5"></i>
                            Ubah Foto
                        </label>
                    </form>
                    <p class="text-[10px] text-[#4A2E28]/40 text-center mt-3 leading-relaxed">
                        .jpg, .jpeg, .png — maks 2 MB
                    </p>
                </div>

                {{-- Sisi kanan — Form --}}
                <div class="px-8 py-8">
                    <div class="mb-5 flex items-center justify-between">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Informasi Profil</p>
                        <button type="button" @click="isEditing = !isEditing"
                            class="inline-flex items-center gap-1.5 rounded-full border border-[#4A0F1A]/30 bg-white px-4 py-1.5 text-xs font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
                            <i data-lucide="edit-3" class="h-3.5 w-3.5"></i>
                            <span x-text="isEditing ? 'Batal' : 'Edit Profil'"></span>
                        </button>
                    </div>

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="nama" value="{{ $user?->nama ?? '' }}" :disabled="!isEditing"
                                    class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none transition text-sm font-semibold text-[#4A0F1A] focus:border-[#C8960C] disabled:text-[#4A2E28]/40 disabled:cursor-default">
                            </div>

                            {{-- Email — read-only --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-[10px] uppercase tracking-wider text-[#4A2E28]/50">Email</label>
                                    <span
                                        class="text-[10px] font-medium text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                        tidak bisa diubah
                                    </span>
                                </div>
                                <input type="email" name="email" value="{{ $user?->email ?? '' }}" readonly
                                    class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none text-sm font-semibold text-[#4A2E28]/40 cursor-not-allowed">
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Nomor
                                    Telepon</label>
                                <input type="text" name="no_hp" value="{{ $user?->no_hp ?? '' }}"
                                    :disabled="!isEditing"
                                    class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none transition text-sm font-semibold text-[#4A0F1A] focus:border-[#C8960C] disabled:text-[#4A2E28]/40 disabled:cursor-default">
                            </div>
                        </div>

                        <div class="mt-7" x-show="isEditing" x-cloak>
                            <button type="submit"
                                class="rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-2.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    {{-- Keamanan --}}
                    <div class="mt-8 border-t border-[#E2D4C0] pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Keamanan</p>
                            <button type="button" x-show="isEditing" x-cloak @click="showSecurity = !showSecurity"
                                class="text-xs font-semibold text-[#4A0F1A] underline underline-offset-2 hover:text-[#C8960C] transition">
                                <span x-text="showSecurity ? 'Tutup' : 'Ganti Password'"></span>
                            </button>
                        </div>

                        <div x-show="isEditing && showSecurity" x-cloak>
                            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label
                                        class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Password
                                        Saat Ini</label>
                                    <input type="password" name="current_password"
                                        class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none transition text-sm font-semibold text-[#4A0F1A] focus:border-[#C8960C]">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Password
                                        Baru</label>
                                    <input type="password" name="password"
                                        class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none transition text-sm font-semibold text-[#4A0F1A] focus:border-[#C8960C]">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/50 mb-2">Konfirmasi
                                        Password Baru</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full border-b border-[#E2D4C0] pb-2 bg-transparent outline-none transition text-sm font-semibold text-[#4A0F1A] focus:border-[#C8960C]">
                                </div>
                                <button type="submit"
                                    class="rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-2.5 text-sm font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                                    Simpan Password
                                </button>
                            </form>
                        </div>

                        <p x-show="!isEditing" class="text-sm text-[#4A2E28]/50">
                            Klik "Edit Profil" untuk mengubah password.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
