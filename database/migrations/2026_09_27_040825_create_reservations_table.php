<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('restaurant_table_id')
                ->constrained('restaurant_tables')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('reservation_date');

            $table->time('reservation_time');

            $table->unsignedInteger('guest_count');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'checked_in',
                'completed',
                'cancelled',
                'no_show',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};