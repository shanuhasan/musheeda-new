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
        $slug = $this->order->product_name; // We saved the slug in this field
        $product = \App\Models\Product::where('slug', $slug)->first();

        if ($product && $product->download_file_path) {
            $pdfPath = storage_path($product->download_file_path);
            
            if (file_exists($pdfPath)) {
                return [
                    Attachment::fromPath($pdfPath)
                            ->as(str_replace(' ', '_', $product->name) . '.pdf')
                            ->withMime('application/pdf'),
                ];
            }
        }

        return [];
    }
}
