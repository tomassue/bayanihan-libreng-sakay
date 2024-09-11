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
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('action', 255); // E.g., created, updated, deleted
            $table->string('model_type', 255); // E.g., Post, Order, User
            $table->unsignedBigInteger('model_id'); // Reference to the model/entity
            $table->json('changes')->nullable(); // Stores changes in JSON format
            $table->string('ip_address', 45)->nullable(); // IPv4 or IPv6 address
            $table->text('user_agent')->nullable(); // Details about the browser/device
            $table->timestamps();

            // Indexes for efficient querying
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
