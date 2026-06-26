<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kode OTP Reset Password - Averra');
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
            <h2>Reset Password Averra</h2>
            <p>Kode OTP Anda: <strong style='font-size:24px;letter-spacing:6px'>{$this->otp}</strong></p>
            <p>Berlaku selama 10 menit.</p>
        "
        );
    }
}
