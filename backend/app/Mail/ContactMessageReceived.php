<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contact) {}

    public function envelope(): Envelope
    {
        $topic = $this->contact->topic ?: 'General Inquiry';

        return new Envelope(
            subject: '[Website] ' . $topic . ' — ' . $this->contact->name,
            replyTo: [new Address($this->contact->email, $this->contact->name)],
            tags: ['contact-form'],
            metadata: ['contact_id' => (string) $this->contact->id],
        );
    }

    public function headers(): Headers
    {
        return new Headers(
            messageId: 'contact-' . $this->contact->id . '@drugpharmaeg.com',
            text: [
                'X-Mailer'                  => 'DrugPharmaWebsite',
                'X-Auto-Response-Suppress'  => 'All',
                'Auto-Submitted'            => 'auto-generated',
                'List-Unsubscribe'          => '<mailto:hr@drugpharmaeg.com?subject=Unsubscribe>',
                'Precedence'                => 'bulk',
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
            text: 'emails.contact-message-text',
        );
    }
}
