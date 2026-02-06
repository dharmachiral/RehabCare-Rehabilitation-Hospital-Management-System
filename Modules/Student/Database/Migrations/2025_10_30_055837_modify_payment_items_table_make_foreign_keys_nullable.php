<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPaymentItemsTableMakeForeignKeysNullable extends Migration
{
    public function up()
    {
        Schema::table('payment_items', function (Blueprint $table) {
            $table->unsignedBigInteger('student_fee_id')->nullable()->change();
            $table->unsignedBigInteger('expense_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('payment_items', function (Blueprint $table) {
            $table->unsignedBigInteger('student_fee_id')->nullable(false)->change();
            $table->unsignedBigInteger('expense_id')->nullable(false)->change();
        });
    }
}
