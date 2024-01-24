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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // system generated id and will be saved to the other user information tables as connection or reference
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('id_account_type'); // from account_type table. This will determine if the user is an organization or administrator.
            $table->string('password');
            $table->integer('status')->default('0'); // with a default value of 0. 0 and 1, once approved (1), user can now login to the system
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
