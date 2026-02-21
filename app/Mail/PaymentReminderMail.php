<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $timeLabel;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction, $timeLabel)
    {
        $this->transaction = $transaction;
        $this->timeLabel = $timeLabel;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[U-Market] Pengingat Pembayaran: Pesanan #' . $this->transaction->order_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-reminder',
        );
    }
}
