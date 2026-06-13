@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-border p-8 shadow-soft max-w-lg">
    <h2 class="text-2xl font-semibold text-gray-900">Upload Bukti Pembayaran</h2>
    <form action="{{ route('user.pembayaran.upload') }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
        @csrf
        <div>
            <label for="booking_id" class="block text-sm font-medium text-gray-700">Kode Booking</label>
            <input type="text" id="booking_id" name="booking_id" class="w-full rounded border p-2" placeholder="Masukkan kode booking">
        </div>
        <div>
            <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
            <input type="file" id="payment_proof" name="payment_proof" class="w-full rounded border p-2">
        </div>
        <button type="submit" class="rounded-full px-6 py-2.5 bg-primary text-white font-semibold hover:bg-rose-700 transition">
            Upload
        </button>
    </form>
</div>
@endsection
