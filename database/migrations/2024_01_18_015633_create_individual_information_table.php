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
        Schema::create('individual_information', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // reference id to User table
            $table->string('user_type');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->string('sex');
            $table->string('contact_number');
            $table->string('id_barangay'); // reference key from tbl_ref_barangay
            $table->string('address');
            $table->integer('id_organization'); // id from organization
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_information');
    }
};
