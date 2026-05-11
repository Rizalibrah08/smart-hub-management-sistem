<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_schedule_id')->constrained('borrowing_schedules')->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->enum('check_in_type', ['borrow', 'return'])->default('borrow');
            $table->enum('status', ['pending_approval', 'approved', 'rejected'])->default('pending_approval');
            $table->text('condition_notes')->nullable();
            $table->timestamp('checked_in_at');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('check_in_type');
            $table->index(['member_id', 'checked_in_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
