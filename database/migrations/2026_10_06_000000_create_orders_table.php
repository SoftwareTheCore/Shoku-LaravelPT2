<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('reservation_id')
                ->constrained('reservations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('total_amount', 12, 2);

            $table->enum('status', [
                'pending',
                'preparing',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->nullOnDelete();

            $table->string('menu_name', 150);
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
