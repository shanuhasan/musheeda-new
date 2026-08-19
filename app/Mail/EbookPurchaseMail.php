<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\Order;

class EbookPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your E-Book Purchase from Musheeda Solutions',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ebook_purchase',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // For testing, we will attach a dummy PDF file from public or storage.
        // If the file doesn't exist, it will skip.
        $pdfPath = storage_path('app/ebooks/kids_learning_ebook.pdf');
        
        if (file_exists($pdfPath)) {
            return [
                Attachment::fromPath($pdfPath)
                        ->as('Kids_Learning_EBook.pdf')
                        ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
