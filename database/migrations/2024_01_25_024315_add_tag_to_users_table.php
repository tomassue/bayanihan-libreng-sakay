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
        // Adding new column to an existing table.
        Schema::table('users', function (Blueprint $table) {
            $table->integer('tag')->default(0)->after('status'); // 0 - pending, 1 - approved, 2 - declined.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function ($table) {
                $table->dropColumn('paid');
            });
        });
    }
};
