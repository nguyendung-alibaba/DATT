<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donHang;

    public function __construct($donHang)
    {
        $this->donHang = $donHang;
    }

    public function build()
    {
        return $this->subject('✅ Đơn hàng của bạn đã được xác nhận')
            ->view('emails.order_received');
    }
}
