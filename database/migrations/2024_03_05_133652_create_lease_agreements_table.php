<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_lease_agreements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaseAgreementsTable extends Migration
{
    public function up()
    {
        Schema::create('lease_agreements', function (Blueprint $table) {
            $table->id();
            $table->string('lessor_name');
            $table->string('lessor_address');
            $table->string('lessee_name');
            $table->string('lessee_email');
            $table->string('property_address');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent_amount', 8, 2); // Assuming rent amounts will have two decimal places
            $table->string('jurisdiction');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('lease_agreements');
    }
}
