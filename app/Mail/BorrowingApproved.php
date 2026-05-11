<?php

namespace App\Mail;

use App\Models\CheckIn;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BorrowingApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CheckIn $checkIn) {}

    public function envelope(): Envelope
    {
        $subject = $this->checkIn->check_in_type === 'borrow'
            ? 'Pengambilan Peralatan Disetujui'
            : 'Pengembalian Peralatan Dikonfirmasi';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.borrowing-approved');
    }
}
