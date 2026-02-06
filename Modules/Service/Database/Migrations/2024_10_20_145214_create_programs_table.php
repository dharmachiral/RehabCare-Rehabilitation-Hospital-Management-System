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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->text('category_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->string('program_type')->default('past');
            $table->string('date')->nullable();
            $table->longText('shortdescription')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->text('video')->nullable();
            $table->string('status')->default('off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
};
