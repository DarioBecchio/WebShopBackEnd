<?php

namespace App\Mail;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReturnApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ReturnRequest $returnRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reso approvato - Ordine #' . $this->returnRequest->order_number
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.returns.approved');
    }

    public function attachments(): array
    {
        return [];
    }
}