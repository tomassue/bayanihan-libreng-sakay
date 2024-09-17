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
        Schema::create('client_rider_tagging', function (Blueprint $table) {
            $table->id();
            $table->string('id_event');
            $table->string('id_client');
            $table->string('id_individual');
            $table->boolean('is_message_sent')->default(0); // 0 - not sent; 1 - sent;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_rider_tagging');
    }
};
