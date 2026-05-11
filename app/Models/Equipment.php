<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipments';

    protected $fillable = [
        'code', 'name', 'description', 'category',
        'quantity', 'available_quantity', 'status',
        'location', 'purchase_date', 'purchase_price',
        'last_maintenance_date', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'last_maintenance_date' => 'date',
            'purchase_price' => 'decimal:2',
            'quantity' => 'integer',
            'available_quantity' => 'integer',
        ];
    }

    public function borrowingSchedules(): HasMany
    {
        return $this->hasMany(BorrowingSchedule::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(EquipmentReport::class);
    }
}
