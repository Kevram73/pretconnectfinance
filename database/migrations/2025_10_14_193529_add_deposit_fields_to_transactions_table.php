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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('deposit_type', ['AUTOMATIC', 'MANUAL'])->nullable()->after('type');
            $table->string('screenshot_path')->nullable()->after('payment_hash');
            $table->text('admin_notes')->nullable()->after('screenshot_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['deposit_type', 'screenshot_path', 'admin_notes']);
        });
    }
};