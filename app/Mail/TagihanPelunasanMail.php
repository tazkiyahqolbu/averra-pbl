<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TagihanPelunasanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Pemesanan $pesanan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tagihan Pelunasan Sewa – #{$this->pesanan->kode_pemesanan}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.tagihan-pelunasan',
        );
    }
}
