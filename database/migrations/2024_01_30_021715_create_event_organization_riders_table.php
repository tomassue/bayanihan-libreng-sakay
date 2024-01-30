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
        Schema::create('event_organization_riders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_event_organization'); // FK, event_organization
            $table->integer('id_individual'); // FK, individual_information
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_organization_riders');
    }
};
