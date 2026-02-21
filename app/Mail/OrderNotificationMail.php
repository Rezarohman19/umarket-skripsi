<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $seller;
    public $isPaid;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction, $seller, $isPaid = false)
    {
        $this->transaction = $transaction;
        $this->seller = $seller;
        $this->isPaid = $isPaid;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isPaid ? 'Pesanan Baru Telah Dibayar!' : 'Ada Pesanan Baru Muncul!';
        return new Envelope(
            subject: '[U-Market] ' . $subject . ' (#' . $this->transaction->order_id . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-notification',
        );
    }
}
