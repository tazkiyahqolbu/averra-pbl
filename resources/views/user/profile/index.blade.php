@extends('user.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto font-dashboard" x-data="{ isEditing: false, showPassword: false, showSecurity: false }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-4 mb-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37]">
                AKUN
            </p>


            <p class="text-sm text-gray-500 font-medium mt-1">
                Kelola informasi profil akun Anda
            </p>
        </div>

        {{-- Tombol Edit --}}
        <button
            type="button"
            @click="isEditing = !isEditing"
            class="inline-flex items-center rounded-full border border-[#5D001E] bg-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-[#5D001E] hover:bg-[#5D001E] hover:text-white transition shadow-sm">

            <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>

            <span x-text="isEditing ? 'Batal Edit' : 'Edit Profil'"></span>
        </button>
    </div>

    {{-- Card Profile --}}
    <div class="rounded-[28px] bg-white border border-gray-100 shadow-sm overflow-hidden">

        <div class="grid lg:grid-cols-[260px_1fr]">

            {{-- LEFT SIDE --}}
<div class="bg-[#FAF3E0]/50 border-r border-gray-100 px-6 py-8 flex flex-col items-center justify-center">

    {{-- Avatar --}}
    <div class="h-24 w-24 rounded-full overflow-hidden bg-[#5D001E] shadow-sm">

        @php($u = auth()->user())

        @if($u && $u->profile_photo)
            <img
                src="{{ asset('storage/' . $u->profile_photo) }}"
                alt="Foto Profil"
                class="h-full w-full object-cover">
        @else
            <div class="h-full w-full flex items-center justify-center text-white text-3xl font-bold">
                {{ strtoupper(substr(($u?->name ?? 'U'), 0, 1)) }}
            </div>
        @endif

    </div>

    {{-- Nama --}}
    <h2 class="mt-4 text-xl font-bold text-[#2D2D2D]">
        {{ $u?->name ?? '' }}
    </h2>

    {{-- Email --}}
    <p class="text-sm text-gray-500 mt-1 break-all text-center">
        {{ $u?->email ?? '' }}
    </p>

    {{-- Upload Foto --}}
    <form
        action="{{ route('user.profile.photo.update') }}"
        method="POST"
        enctype="multipart/form-data"
        class="mt-5">

        @csrf
        @method('PUT')

        {{-- Input File Hidden --}}
        <input
            type="file"
            id="profile_photo"
            name="profile_photo"
            class="hidden"
            accept=".jpg,.jpeg,.png"
            onchange="this.form.submit()">

        {{-- Button Upload --}}
        <label
            for="profile_photo"
            class="cursor-pointer inline-flex items-center rounded-full border border-[#5D001E] bg-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-[#5D001E] hover:bg-[#5D001E] hover:text-white transition shadow-sm">

            Ubah Foto Profil
        </label>
    </form>

    {{-- Note --}}
    <p class="text-xs text-gray-500 text-center mt-4 leading-relaxed max-w-[180px]">
        Format foto
        <span class="font-semibold">
            .jpg, .jpeg, .png
        </span>
        maksimal
        <span class="font-semibold">
            2MB
        </span>
    </p>

</div>

            {{-- RIGHT SIDE --}}
            <div class="px-8 py-8">

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- Nama --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-500">
                                    Nama Lengkap
                                </label>

                                <button type="button"
                                        @click="isEditing = true"
                                        class="text-[#5D001E]">

                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <input type="text"
                                   name="nama"
                                   value="{{ $u?->name ?? '' }}"
                                   :disabled="!isEditing"
                                   class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none transition focus:border-[#5D001E] disabled:text-gray-400 text-sm font-semibold text-gray-800">

                        </div>

                        {{-- Email — READ-ONLY sesuai dokumen AVERRA (tidak bisa diubah) --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-500">
                                    Email
                                </label>

                                <span class="text-[10px] font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                    🔒 tidak bisa diubah
                                </span>
                            </div>

                            <input type="email"
                                   name="email"
                                   value="{{ $u?->email ?? '' }}"
                                   readonly
                                   class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none text-sm font-semibold text-gray-400 cursor-not-allowed">
                        </div>

                        {{-- Nomor HP --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-500">
                                    Nomor Telepon
                                </label>

                                <button type="button"
                                        @click="isEditing = true"
                                        class="text-[#5D001E]">

                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <input type="text"
                                   name="no_hp"
                                   value="{{ $u?->no_hp ?? '' }}"
                                   :disabled="!isEditing"
                                   class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none transition focus:border-[#5D001E] disabled:text-gray-400 text-sm font-semibold text-gray-800">
                        </div>

                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="inline-flex items-center rounded-full bg-[#5D001E] text-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider hover:bg-[#4A0F1A] transition shadow-md border border-[#D4AF37]">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

                {{-- KEAMANAN (digabung dengan bagian atas seperti permintaan kamu) --}}
                <div class="mt-10 border-t border-gray-200 pt-6">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#D4AF37] mb-4">
                        KEAMANAN
                    </p>

                    {{-- Tombol ganti password tetap satu konteks, tapi tidak memisah struktur visual terlalu jauh --}}
                    <div class="flex items-center justify-between mb-5">
                        <div></div>
                        <button type="button"
                            class="text-[#5D001E] text-sm font-semibold underline"
                            x-show="isEditing"
                            x-cloak
                            @click="showSecurity = !showSecurity">
                            Ganti Password →
                        </button>
                    </div>

                    <div class="space-y-4" x-show="isEditing && showSecurity" x-cloak>
                        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">
                                    Password Saat Ini
                                </label>
                                <input type="password" name="current_password" class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none transition focus:border-[#5D001E] text-sm font-semibold text-gray-800" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" name="password" class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none transition focus:border-[#5D001E] text-sm font-semibold text-gray-800" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirmation" class="w-full border-b border-[#DDD5CA] pb-2 bg-transparent outline-none transition focus:border-[#5D001E] text-sm font-semibold text-gray-800" />
                            </div>

                            <button type="submit" class="inline-flex items-center rounded-full bg-[#5D001E] text-white px-5 py-2.5 text-xs font-semibold uppercase tracking-wider hover:bg-[#4A0F1A] transition shadow-md border border-[#D4AF37]">
                                Simpan Password
                            </button>
                        </form>


                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
