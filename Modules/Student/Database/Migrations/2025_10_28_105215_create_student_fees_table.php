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
        Schema::create('student_fees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('fee_type_id')->constrained('fee_types')->onDelete('cascade');
    $table->unsignedTinyInteger('month')->nullable(); // for recurring fees
    $table->year('year')->nullable();
    $table->decimal('amount', 10, 2);
    $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
