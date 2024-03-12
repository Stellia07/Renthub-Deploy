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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming user_id is a foreign key to the users table
            $table->decimal('amount', 8, 2);
            $table->string('receipt_image_path')->nullable(); // Assuming this can be nullable
            $table->string('recipient_email');
            $table->text('description')->nullable(); // Assuming this can be nullable
            $table->timestamps();
        });

        // Optional: Add foreign key constraint
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
