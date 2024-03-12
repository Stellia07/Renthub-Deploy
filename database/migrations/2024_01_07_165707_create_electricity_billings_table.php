<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('electricity_billings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_email');
            $table->decimal('overall_usage', 8, 2)->default(0);
            $table->decimal('previous_reading', 8, 2)->default(0);
            $table->decimal('new_reading', 8, 2)->default(0);
            $table->decimal('price_per_unit', 8, 2)->default(13);
            $table->decimal('amount_due', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_billings');
    }
};
