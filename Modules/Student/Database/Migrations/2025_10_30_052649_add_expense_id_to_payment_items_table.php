<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add this to your payment_items table migration
Schema::table('payment_items', function (Blueprint $table) {
    $table->boolean('is_advance')->default(false)->after('paid_amount');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_items', function (Blueprint $table) {
            //
        });
    }
};
