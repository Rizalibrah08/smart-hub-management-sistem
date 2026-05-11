<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowing_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->date('borrow_date');
            $table->date('return_date');
            $table->date('actual_return_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'returned', 'overdue'])->default('pending');
            $table->integer('quantity_borrowed')->default(1);
            $table->text('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('borrow_date');
            $table->index(['equipment_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_schedules');
    }
};
