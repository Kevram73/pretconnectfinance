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
        Schema::create('multi_level_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('referrer_id');
            $table->integer('level');
            $table->decimal('amount', 15, 2);
            $table->decimal('percentage', 5, 2);
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->string('transaction_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'referrer_id', 'level']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_level_commissions');
    }
};
