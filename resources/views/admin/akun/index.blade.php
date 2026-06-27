@extends('admin.layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="admin-section">
    <div>
        <h1 class="admin-title text-3xl">Profil Admin</h1>
        <p class="admin-subtitle mt-1 text-sm">
            Kelola informasi profil admin yang sedang login.
        </p>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            <i data-lucide="circle-check" class="h-5 w-5 shrink-0 text-green-600"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card p-6">
        <form class="space-y-5" action="#" method="POST">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#4A0F1A] text-2xl font-bold text-white">
                    {{ strtoupper(substr($admin->nama ?? $admin->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <label class="admin-label">Foto Profil</label>
                    <input type="file" class="admin-file">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="admin-label">Nama *</label>
                    <input type="text" name="nama" class="admin-input" value="{{ $admin->nama ?? $admin->name ?? 'Admin' }}">
                </div>

                <div>
                    <label class="admin-label">Email</label>
                    <input type="email" class="admin-input bg-[#FAF3E0] opacity-70" value="{{ $admin->email }}" readonly>
                </div>

                <div>
                    <label class="admin-label">No. HP *</label>
                    <input type="text" name="no_hp" class="admin-input" placeholder="081234567890" value="{{ $admin->no_hp ?? '' }}">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="btn-open-password-modal"
                    class="admin-btn-secondary">
                    Ganti Password
                </button>
                <button type="submit" class="admin-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     Modal Ganti Password
══════════════════════════════════════════════════════ --}}
<div id="password-modal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display:none!important;">

    {{-- Backdrop --}}
    <div id="password-modal-backdrop"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closePasswordModal()"></div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-md rounded-2xl bg-[#FAF3E0] shadow-2xl border border-[#E2D4C0]">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-[#E2D4C0] px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#4A0F1A]/10">
                    <i data-lucide="lock" class="h-4 w-4 text-[#4A0F1A]"></i>
                </div>
                <h2 class="font-semibold text-[#4A0F1A]" style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;">
                    Ganti Password
                </h2>
            </div>
            <button type="button" onclick="closePasswordModal()"
                class="flex h-8 w-8 items-center justify-center rounded-full text-[#7A5C3A] transition hover:bg-[#E2D4C0]">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        {{-- Body --}}
        <form action="{{ route('admin.akun.password') }}" method="POST" class="px-6 py-5 space-y-4">
            @csrf
            @method('PUT')

            {{-- Error alerts --}}
            @if ($errors->has('current_password'))
                <div class="flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <i data-lucide="alert-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
                    {{ $errors->first('current_password') }}
                </div>
            @endif
            @if ($errors->has('password'))
                <div class="flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <i data-lucide="alert-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
                    {{ $errors->first('password') }}
                </div>
            @endif

            {{-- Password Saat Ini --}}
            <div>
                <label for="admin_current_password" class="admin-label">Password Saat Ini <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password"
                           id="admin_current_password"
                           name="current_password"
                           class="admin-input pr-11 @error('current_password') border-red-400 @enderror"
                           placeholder="Masukkan password saat ini"
                           required>
                    <button type="button"
                            onclick="toggleAdminPass('admin_current_password', 'icon-cp')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7A5C3A] hover:text-[#4A0F1A] transition-colors">
                        <i id="icon-cp" data-lucide="eye" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>

            {{-- Password Baru --}}
            <div>
                <label for="admin_new_password" class="admin-label">Password Baru <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password"
                           id="admin_new_password"
                           name="password"
                           class="admin-input pr-11 @error('password') border-red-400 @enderror"
                           placeholder="Minimal 8 karakter"
                           required>
                    <button type="button"
                            onclick="toggleAdminPass('admin_new_password', 'icon-np')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7A5C3A] hover:text-[#4A0F1A] transition-colors">
                        <i id="icon-np" data-lucide="eye" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="admin_confirm_password" class="admin-label">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password"
                           id="admin_confirm_password"
                           name="password_confirmation"
                           class="admin-input pr-11"
                           placeholder="Ulangi password baru"
                           required>
                    <button type="button"
                            onclick="toggleAdminPass('admin_confirm_password', 'icon-cfp')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#7A5C3A] hover:text-[#4A0F1A] transition-colors">
                        <i id="icon-cfp" data-lucide="eye" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closePasswordModal()" class="admin-btn-secondary px-5 py-2.5">
                    Batal
                </button>
                <button type="submit" class="admin-btn-primary px-5 py-2.5">
                    <i data-lucide="save" class="mr-2 h-4 w-4 inline"></i>
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const passwordModal = document.getElementById('password-modal');

    function openPasswordModal() {
        passwordModal.style.removeProperty('display');
        passwordModal.style.display = 'flex';
        lucide.createIcons();
    }

    function closePasswordModal() {
        passwordModal.style.display = 'none';
    }

    function toggleAdminPass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Buka modal tombol "Ganti Password"
    document.getElementById('btn-open-password-modal').addEventListener('click', openPasswordModal);

    // Jika ada error password, buka modal otomatis
    @if ($errors->hasAny(['current_password', 'password']) || session('open_password_modal'))
        document.addEventListener('DOMContentLoaded', openPasswordModal);
    @endif

    // Tutup modal jika tekan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePasswordModal();
    });
</script>
@endpush
@endsection
