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
        Schema::create('modified_rent_billings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_email');
            $table->decimal('monthly_rent', 8, 2); // Monthly rent amount
            $table->decimal('balance', 8, 2)->default(0); // Outstanding balance
            $table->date('last_payment_date')->nullable(); // Date of the last payment
            $table->decimal('last_payment_amount', 8, 2)->nullable(); // Amount of the last payment
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_billings', function (Blueprint $table) {
            //
        });
    }
};
