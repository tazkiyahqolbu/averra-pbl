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
        // Pemesanan jasa/paket acara selalu dilaksanakan di lokasi pemesan (bukan di
        // sanggar), jadi zona lokasi & alamat wajib diisi. Sewa barang tetap opsional
        // karena masih ada pilihan "Ambil Sendiri" langsung ke sanggar.
        $isSewaBarang = str_starts_with((string) $this->input('katalog_id'), 'barang-');

        return [
            'katalog_id'          => ['required', 'string'],
            'nama_pemesan'        => ['required', 'string', 'max:255'],
            'no_hp'               => ['required', 'string', 'max:20'],
            'alamat_lengkap'      => [$isSewaBarang ? 'nullable' : 'required', 'string'],
            'zona_lokasi_id'      => [$isSewaBarang ? 'nullable' : 'required', 'exists:zona_lokasi,id'],
            'opsional_ids'        => ['nullable', 'array'],
            'opsional_ids.*'      => ['integer', 'exists:paket_detail,id'],

            'keterangan_acara'    => ['nullable', 'string'],

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
            'nama_pemesan.max'             => 'Nama pemesan maksimal :max karakter.',
            'no_hp.required'               => 'Nomor HP wajib diisi.',
            'no_hp.max'                    => 'Nomor HP maksimal :max karakter.',

            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal ambil.',
            'zona_lokasi_id.exists'        => 'Zona lokasi tidak valid.',
            'zona_lokasi_id.required'      => 'Pilih zona lokasi pelaksanaan.',

            'alamat_lengkap.required'      => 'Alamat lengkap lokasi pelaksanaan wajib diisi.',
            'jumlah_unit.min'              => 'Jumlah minimal 1.',
        ];
    }
}
