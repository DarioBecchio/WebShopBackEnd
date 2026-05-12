<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . $this->contactMessage->typeLabel() . '] Nuovo messaggio da ' . $this->contactMessage->name
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.contact.alert');
    }

    public function attachments(): array
    {
        return [];
    }
}