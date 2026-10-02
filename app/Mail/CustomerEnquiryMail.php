<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable as MailableContract;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function envelope(): Envelope
    {
        $type = ucfirst((string) ($this->payload['enquiryType'] ?? 'general enquiry'));

        return new Envelope(
            from: config('mail.from.address', 'enquiry@crumbsandcrown.com'),
            replyTo: [new Address($this->payload['email'], $this->payload['fullName'])],
            to: [new Address('enquiry@crumbsandcrown.com', 'Crumbs & Crown')],
            subject: 'New enquiry: ' . $type . ' from ' . $this->payload['fullName'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-enquiry',
            with: ['payload' => $this->payload],
        );
    }
}
