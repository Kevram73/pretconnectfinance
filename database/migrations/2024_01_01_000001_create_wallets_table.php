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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('total_deposited', 15, 2)->default(0.00);
            $table->decimal('total_withdrawn', 15, 2)->default(0.00);
            $table->decimal('total_invested', 15, 2)->default(0.00);
            $table->decimal('total_profits', 15, 2)->default(0.00);
            $table->decimal('total_commissions', 15, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
