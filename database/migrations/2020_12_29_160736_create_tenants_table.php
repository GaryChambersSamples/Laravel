<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id');
            $table->date('lease_start_date');
            $table->date('lease_end_date');
            $table->decimal('monthly_rent', $precision=10, $scale=2);
            $table->decimal('late_fee', $precision=10, $scale=2);
            $table->integer('grace_period');
            $table->decimal('returned_check_fee', $precision=10, $scale=2);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email')->email()->nullable();
            $table->boolean('active');
            $table->mediumText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
