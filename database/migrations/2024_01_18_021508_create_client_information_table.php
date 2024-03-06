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
        Schema::create('client_information', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // reference key to User table
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->string('sex');
            $table->date('birthday');
            $table->string('contact_number');
            $table->string('address');
            $table->integer('id_school'); // id from school
            $table->string('guardian_name');
            $table->string('guardian_contact_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_information');
    }
};
