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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('referral_code')->unique();
            $table->string('referred_by')->nullable();
            $table->enum('role', ['USER', 'ADMIN'])->default('USER');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['referral_code']);
            $table->index(['referred_by']);
            $table->index(['role']);
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
