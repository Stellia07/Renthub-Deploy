<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTenantsTable extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Add the 'status' column with default value 'pending'
            $table->enum('status', ['accepted', 'rejected', 'pending'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Remove the 'status' column if rolled back
            $table->dropColumn('status');
        });
    }
}
