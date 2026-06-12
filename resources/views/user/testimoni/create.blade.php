@extends('user.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto rounded-3xl bg-white border border-border p-6 shadow-soft">
    
    <h2 class="text-2xl font-semibold text-gray-900 mb-2">
        Tulis Testimoni
    </h2>

    <p class="text-sm text-gray-500 mb-6">
        Bagikan pengalaman Anda setelah menggunakan layanan kami.
    </p>

    <form action="{{ route('user.testimoni.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-5">

            {{-- Rating --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rating
                </label>

                <select name="rating"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:outline-none"
                    required>
                    <option value="">Pilih Rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4">⭐⭐⭐⭐ (4)</option>
                    <option value="3">⭐⭐⭐ (3)</option>
                    <option value="2">⭐⭐ (2)</option>
                    <option value="1">⭐ (1)</option>
                </select>
            </div>

            {{-- Isi Testimoni --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Testimoni
                </label>

                <textarea
                    name="isi_testimoni"
                    rows="5"
                    placeholder="Tulis pengalaman Anda..."
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring focus:ring-maroon-deep/20 focus:outline-none"
                    required></textarea>
            </div>

            {{-- Upload Foto --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Foto (Opsional)
                </label>

                <input type="file"
                    name="foto"
                    accept="image/*"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-maroon-deep file:px-4 file:py-2 file:text-white hover:file:opacity-90">
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                    class="rounded-xl bg-maroon-deep px-5 py-3 text-white hover:opacity-90 transition">
                    Kirim Testimoni
                </button>

                <a href="{{ route('user.testimoni.index') }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>

        </div>
    </form>
</div>
@endsection