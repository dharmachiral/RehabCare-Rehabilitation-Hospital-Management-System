<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Make name nullable if it exists
            if (Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->change();
            } else {
                $table->string('name')->nullable();
            }

            // Add role_id with default value
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')
                      ->nullable()
                      ->default(7)
                      ->constrained('roles') // Assuming you have a roles table
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the name change
            $table->string('name')->nullable(false)->change();

            // Remove role_id if it was added
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            }
        });
    }
}
