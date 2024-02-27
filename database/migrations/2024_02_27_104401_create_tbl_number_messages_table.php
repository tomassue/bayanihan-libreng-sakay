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
        Schema::create('tbl_number_messages', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->nullable();
            $table->string('otp_code')->nullable();
            $table->string('is_verified')->default(0);
            $table->string('otp_type')->nullable();
            $table->string('sms_status')->nullable();
            $table->string('sms_trans_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_number_messages');
    }
};
