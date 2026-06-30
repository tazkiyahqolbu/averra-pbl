<?php

namespace App\Mail;

use App\Models\Pembatalan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PembatalanDisetujuiMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Pembatalan $pembatalan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pembatalan Disetujui – #{$this->pembatalan->pemesanan->kode_pemesanan}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.pembatalan-disetujui',
        );
    }
}
