<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('admin_note')->nullable();
            $table->timestamp('completed_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['completed_at']);
            $table->dropColumn(['admin_note', 'completed_at']);
        });
    }
};
