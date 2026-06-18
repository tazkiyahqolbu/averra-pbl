<?php

namespace App\Mail;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPengembalian extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pemesanan $pemesanan,
        public DetailPemesanan $detail,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[SILART] Pengingat: Pengembalian Barang Besok — ' . $this->pemesanan->kode_pemesanan,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.reminder-pengembalian',
        );
    }
}
