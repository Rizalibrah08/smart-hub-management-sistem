<?php

namespace App\Listeners;

use App\Events\CheckInApproved;
use App\Mail\BorrowingApproved;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class SendCheckInNotification
{
    public function handle(CheckInApproved $event): void
    {
        $checkIn = $event->checkIn->load(['member', 'equipment', 'borrowingSchedule']);
        $member  = $checkIn->member;

        // Send email
        Mail::to($member->email)->send(new BorrowingApproved($checkIn));

        // Persist notification record
        Notification::create([
            'user_id'             => $member->id,
            'type'                => 'check_in_approved',
            'title'               => $checkIn->check_in_type === 'borrow'
                                        ? 'Pengambilan Peralatan Disetujui'
                                        : 'Pengembalian Peralatan Dikonfirmasi',
            'message'             => 'Check-in ' . $checkIn->check_in_type . ' untuk peralatan '
                                        . $checkIn->equipment->name . ' telah disetujui.',
            'related_entity_type' => 'CheckIn',
            'related_entity_id'   => $checkIn->id,
            'is_sent'             => true,
            'sent_at'             => now(),
        ]);
    }
}
