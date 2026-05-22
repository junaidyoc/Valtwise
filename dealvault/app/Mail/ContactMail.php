<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $subject,
        public string $userMessage
    ) {}

    public function envelope(): Envelope
    {
        $subjectMap = [
            'broken_coupon' => 'Report: Broken Coupon',
            'suggest_store' => 'Request: Store Suggestion',
            'general' => 'General Question',
            'partnership' => 'Partnership Inquiry',
            'other' => 'Contact Form Submission',
        ];

        return new Envelope(
            subject: $subjectMap[$this->subject] ?? 'Contact Form Submission',
            replyTo: [$this->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}
