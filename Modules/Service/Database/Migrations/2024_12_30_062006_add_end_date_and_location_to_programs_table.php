<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('date'); // Replace 'some_column' with the appropriate column name
            $table->integer('partner_id')->nullable()->after('end_date');
            $table->text('location')->nullable()->after('partner_id');  // Optional: Adjust 'nullable()' as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['end_date','partner_id', 'location']);
        });
    }
};
