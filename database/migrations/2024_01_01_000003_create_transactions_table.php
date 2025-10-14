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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['DEPOSIT', 'WITHDRAWAL', 'INVESTMENT', 'PROFIT', 'COMMISSION', 'BONUS']);
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('PENDING');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('transaction_hash')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_hash')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'type', 'status']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
