<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'katalog_id'          => ['required', 'string'],
            'nama_pemesan'        => ['required', 'string', 'max:255'],
            'no_hp'               => ['required', 'string', 'max:20'],
            'alamat_lengkap'      => ['nullable', 'string'],
            'zona_lokasi_id'      => ['nullable', 'exists:zona_lokasis,id'],
            'keterangan_acara'    => ['nullable', 'string'],
            'metode_bayar'        => ['required', 'in:dp,lunas'],
            'tanggal_pelaksanaan' => ['nullable', 'date', 'after_or_equal:today'],
            'tanggal_ambil'       => ['nullable', 'date', 'after_or_equal:today'],
            'tanggal_kembali'     => ['nullable', 'date', 'after_or_equal:tanggal_ambil'],
            'jumlah_unit'         => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'katalog_id.required'          => 'Pilih item yang ingin dipesan.',
            'nama_pemesan.required'        => 'Nama pemesan wajib diisi.',
            'no_hp.required'               => 'Nomor HP wajib diisi.',
            'metode_bayar.required'        => 'Pilih metode pembayaran.',
            'metode_bayar.in'              => 'Metode pembayaran tidak valid.',
            'tanggal_pelaksanaan.after_or_equal' => 'Tanggal pelaksanaan tidak boleh di masa lalu.',
            'tanggal_ambil.after_or_equal' => 'Tanggal ambil tidak boleh di masa lalu.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal ambil.',
            'zona_lokasi_id.exists'        => 'Zona lokasi tidak valid.',
            'jumlah_unit.min'              => 'Jumlah minimal 1.',
        ];
    }
}
