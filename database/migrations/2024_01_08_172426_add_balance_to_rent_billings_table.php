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
        Schema::table('rent_billings', function (Blueprint $table) {
            //
            $table->decimal('balance', 8, 2)->default(0)->after('amount_due');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_billings', function (Blueprint $table) {
            //
            $table->dropColumn('balance');
        });
    }
};
