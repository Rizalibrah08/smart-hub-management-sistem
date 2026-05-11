<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'message',
        'related_entity_type', 'related_entity_id',
        'is_sent', 'sent_at', 'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_sent' => 'boolean',
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
