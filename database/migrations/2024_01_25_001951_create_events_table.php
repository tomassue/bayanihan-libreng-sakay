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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->date('event_date');
            $table->string('event_location');
            $table->text('google_map_link')->nullable();
            $table->time('time_start');
            $table->time('time_end');
            $table->string('category');
            $table->string('estimated_number_of_participants');
            $table->integer('status')->default(0);
            $table->integer('tag')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
