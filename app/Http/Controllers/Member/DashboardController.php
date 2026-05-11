<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BorrowingSchedule;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $memberId = auth()->id();

        return view('member.dashboard', [
            'totalBorrowings'    => BorrowingSchedule::where('member_id', $memberId)->count(),
            'pendingCount'       => BorrowingSchedule::where('member_id', $memberId)->where('status', 'pending')->count(),
            'approvedCount'      => BorrowingSchedule::where('member_id', $memberId)->where('status', 'approved')->count(),
            'unreadNotifications'=> Notification::where('user_id', $memberId)->whereNull('read_at')->count(),
            'recentBorrowings'   => BorrowingSchedule::with('equipment')
                                        ->where('member_id', $memberId)
                                        ->latest()->limit(5)->get(),
        ]);
    }
}
