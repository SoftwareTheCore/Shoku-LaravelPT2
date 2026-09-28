<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_category_id')
                ->constrained('menu_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name', 150);

            $table->text('description')->nullable();

            $table->decimal('price', 12, 2);

            $table->unsignedInteger('stock')->default(0);

            $table->string('image')->nullable();

            $table->boolean('is_available')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};