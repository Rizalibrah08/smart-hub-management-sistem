<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();
            $table->integer('total_borrowed')->default(0);
            $table->integer('total_returned_on_time')->default(0);
            $table->integer('total_returned_late')->default(0);
            $table->integer('average_borrow_duration')->nullable();
            $table->date('last_borrowed_date')->nullable();
            $table->foreignId('last_borrowed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_reports');
    }
};
