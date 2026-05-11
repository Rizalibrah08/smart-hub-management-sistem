<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    protected $fillable = [
        'borrowing_schedule_id', 'equipment_id', 'member_id',
        'check_in_type', 'status', 'condition_notes',
        'checked_in_at', 'approved_by', 'approved_at', 'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function borrowingSchedule(): BelongsTo
    {
        return $this->belongsTo(BorrowingSchedule::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
