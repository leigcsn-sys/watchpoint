<?php

namespace App\Mail;

use App\Models\Watch;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeDetectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Watch $watch, public string $summary) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Change detected: ' . $this->watch->url,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.change-detected',
            with: [
                'url' => $this->watch->url,
                'summary' => $this->summary,
                'detectedAt' => now()->toDayDateTimeString(),
            ],
        );
    }
}