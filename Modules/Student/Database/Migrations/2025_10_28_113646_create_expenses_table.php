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
        Schema::create('expenses', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('student_id');
    $table->unsignedBigInteger('expense_type_id');
    $table->decimal('amount', 10, 2);
    $table->date('expense_date')->nullable();
    $table->text('description')->nullable();
    $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
    $table->decimal('paid_amount', 10, 2)->default(0);
    $table->timestamps();

    $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    $table->foreign('expense_type_id')->references('id')->on('expense_types')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
