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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('min_amount', 15, 2);
            $table->decimal('max_amount', 15, 2);
            $table->decimal('daily_percentage', 5, 2);
            $table->integer('duration_days');
            $table->decimal('total_percentage', 5, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_rapid')->default(false);
            $table->integer('rapid_days')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'is_rapid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
