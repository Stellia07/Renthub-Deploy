<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentBillingsTable extends Migration
{
    public function up()
    {
        Schema::create('rent_billings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_email')->unique();
            $table->decimal('overall_usage', 8, 2);
            $table->decimal('previous_reading', 8, 2);
            $table->decimal('new_reading', 8, 2);
            $table->decimal('price_per_unit', 8, 2);
            $table->decimal('amount_due', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rent_billings');
    }
}