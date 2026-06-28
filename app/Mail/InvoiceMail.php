<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pemesanan;

class InvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public function __construct(public Pemesanan $pemesanan)
    {
        //
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pesanan #' . $this->pemesanan->kode_pemesanan,
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'mail.invoice',
            with: ['pemesanan' => $this->pemesanan],
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
