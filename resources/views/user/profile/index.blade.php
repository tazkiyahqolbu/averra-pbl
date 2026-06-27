@extends('user.layouts.app')

@section('content')
    {{-- Header --}}
    <div class="mb-7">
        <p class="text-[10px] tracking-[0.4em] text-[#C8960C] uppercase font-semibold">— AKUN —</p>
        <h1 class="mt-0.5 font-serif text-3xl font-light text-[#4A0F1A]">Profil Saya</h1>
        <div class="mt-3 h-[1px] w-16 bg-gradient-to-r from-[#C8960C] to-transparent"></div>
    </div>

    <div x-data="{ 
        isEditing: {{ $errors->has('nama') || $errors->has('no_hp') ? 'true' : 'false' }}, 
        showPasswordModal: {{ $errors->has('password') || $errors->has('current_password') ? 'true' : 'false' }}, 
        showCurrentPass: false, 
        showNewPass: false, 
        showConfirmPass: false 
    }">

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                <i data-lucide="check-circle" class="h-4 w-4 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div
                class="mb-5 flex items-start gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                <i data-lucide="alert-circle" class="h-4 w-4 shrink-0 mt-0.5"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="rounded-2xl border border-[#E2D4C0] bg-white shadow-[0_2px_8px_rgba(74,15,26,0.06)] overflow-hidden">
            <div class="grid lg:grid-cols-[240px_1fr]">

                {{-- Sisi kiri — Avatar --}}
                <div
                    class="flex flex-col items-center justify-start border-b border-[#E2D4C0] bg-[#FAF3E0]/70 px-6 py-8 lg:border-b-0 lg:border-r">

                    {{-- Avatar --}}
                    <div class="h-24 w-24 rounded-full overflow-hidden border-2 border-[#C8960C]/40 bg-[#4A0F1A] shadow-sm">
                        @if ($user && $user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil"
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

                {{-- Sisi kanan — Form Profil --}}
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

                    {{-- Section Keamanan --}}
                    <div class="mt-8 border-t border-[#E2D4C0] pt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Keamanan</p>
                                <p class="text-sm font-medium text-[#4A0F1A] mt-1">Kata Sandi Akun</p>
                                <p class="text-xs text-[#4A2E28]/50 mt-0.5">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
                            </div>
                            <button type="button" @click="showPasswordModal = true"
                                class="inline-flex items-center gap-2 rounded-full border border-[#4A0F1A]/30 bg-white px-4 py-2 text-xs font-semibold text-[#4A0F1A] shadow-sm hover:border-[#4A0F1A] hover:bg-[#4A0F1A] hover:text-[#FAF3E0] transition-all duration-200">
                                <i data-lucide="key-round" class="h-3.5 w-3.5"></i>
                                Ganti Password
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Modal Pop-up Ganti Password --}}
        <div x-show="showPasswordModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div class="w-full max-w-md rounded-2xl border border-[#E2D4C0] bg-white p-6 shadow-2xl relative"
                @click.away="showPasswordModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                
                <div class="flex items-center justify-between border-b border-[#E2D4C0] pb-4 mb-5">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#C8960C]">Keamanan</p>
                        <h3 class="font-serif text-xl font-medium text-[#4A0F1A]">Ganti Password</h3>
                    </div>
                    <button type="button" @click="showPasswordModal = false"
                        class="rounded-full p-1.5 text-[#4A2E28]/40 hover:bg-[#FAF3E0] hover:text-[#4A0F1A] transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Password Saat Ini --}}
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/70 font-semibold mb-1.5">Password Saat Ini</label>
                        <div class="relative">
                            <input :type="showCurrentPass ? 'text' : 'password'" name="current_password" required
                                placeholder="Masukkan password saat ini"
                                class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0]/30 px-3.5 py-2.5 text-sm text-[#4A0F1A] outline-none transition focus:border-[#C8960C] focus:bg-white pr-10">
                            <button type="button" @click="showCurrentPass = !showCurrentPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4A2E28]/50 hover:text-[#4A0F1A] transition">
                                <svg x-show="!showCurrentPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showCurrentPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l18 18"/><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/><path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/70 font-semibold mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input :type="showNewPass ? 'text' : 'password'" name="password" required
                                placeholder="Minimal 8 karakter"
                                class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0]/30 px-3.5 py-2.5 text-sm text-[#4A0F1A] outline-none transition focus:border-[#C8960C] focus:bg-white pr-10">
                            <button type="button" @click="showNewPass = !showNewPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4A2E28]/50 hover:text-[#4A0F1A] transition">
                                <svg x-show="!showNewPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showNewPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l18 18"/><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/><path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-[#4A2E28]/70 font-semibold mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConfirmPass ? 'text' : 'password'" name="password_confirmation" required
                                placeholder="Ulangi password baru"
                                class="w-full rounded-xl border border-[#E2D4C0] bg-[#FAF3E0]/30 px-3.5 py-2.5 text-sm text-[#4A0F1A] outline-none transition focus:border-[#C8960C] focus:bg-white pr-10">
                            <button type="button" @click="showConfirmPass = !showConfirmPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4A2E28]/50 hover:text-[#4A0F1A] transition">
                                <svg x-show="!showConfirmPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showConfirmPass" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l18 18"/><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-3.4"/><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a17.8 17.8 0 0 1-3.1 4.2"/><path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7a9.4 9.4 0 0 0 4-.9"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-3 flex items-center justify-end gap-3">
                        <button type="button" @click="showPasswordModal = false"
                            class="rounded-full border border-[#E2D4C0] bg-white px-5 py-2 text-xs font-semibold text-[#4A0F1A] hover:bg-[#FAF3E0] transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-full bg-gradient-to-br from-[#6B1625] to-[#3A0A12] px-6 py-2 text-xs font-semibold text-[#FAF3E0] shadow-[0_4px_14px_rgba(74,15,26,0.3)] hover:shadow-[0_6px_18px_rgba(74,15,26,0.4)] hover:from-[#7B1C2E] transition-all duration-200">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
