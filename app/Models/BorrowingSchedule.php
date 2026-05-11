<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BorrowingSchedule extends Model
{
    protected $fillable = [
        'equipment_id', 'member_id', 'borrow_date', 'return_date',
        'actual_return_date', 'status', 'quantity_borrowed', 'purpose', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'return_date' => 'date',
            'actual_return_date' => 'date',
            'quantity_borrowed' => 'integer',
        ];
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }
}
