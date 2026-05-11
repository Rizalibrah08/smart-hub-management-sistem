<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentReport extends Model
{
    protected $fillable = [
        'equipment_id', 'total_borrowed', 'total_returned_on_time',
        'total_returned_late', 'average_borrow_duration',
        'last_borrowed_date', 'last_borrowed_by',
    ];

    protected function casts(): array
    {
        return [
            'last_borrowed_date' => 'date',
        ];
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function lastBorrowedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_borrowed_by');
    }
}
