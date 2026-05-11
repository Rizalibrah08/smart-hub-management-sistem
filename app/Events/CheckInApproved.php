<?php

namespace App\Events;

use App\Models\CheckIn;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckInApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(public CheckIn $checkIn) {}
}
