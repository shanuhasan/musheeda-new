<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class EbookPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /** How long the download link in the email stays valid. */
    public const LINK_VALID_DAYS = 7;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your E-Book Purchase from Musheeda Solutions',
        );
    }

    public function content(): Content
    {
        $product = $this->product();

        return new Content(
            view: 'emails.ebook_purchase',
            with: [
                'productTitle' => $product->name ?? $this->order->product_name,
                // Backup to the attachment: some inboxes strip or spam-filter attachments.
                'downloadUrl' => URL::temporarySignedRoute(
                    'ebook.download',
                    now()->addDays(self::LINK_VALID_DAYS),
                    ['order' => $this->order->id]
                ),
                'linkValidDays' => self::LINK_VALID_DAYS,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $product = $this->product();
        $path = $product?->downloadFileAbsolutePath();

        if (!$path) {
            Log::warning('Ebook purchase mail sent WITHOUT attachment: download file missing.', [
                'order_id' => $this->order->id,
                'product' => $this->order->product_name,
                'download_file_path' => $product?->download_file_path,
            ]);

            return [];
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION)) ?: 'pdf';

        return [
            Attachment::fromPath($path)
                ->as(str_replace(' ', '_', $product->name) . '.' . $extension)
                ->withMime($extension === 'zip' ? 'application/zip' : 'application/pdf'),
        ];
    }

    /** The order stores the product slug in product_name. */
    private function product(): ?Product
    {
        return Product::where('slug', $this->order->product_name)->first();
    }
}
