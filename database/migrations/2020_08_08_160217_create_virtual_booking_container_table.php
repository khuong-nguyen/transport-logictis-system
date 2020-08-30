<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualBookingContainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_booking_container', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('virtual_booking_id');
            $table->foreignId('container_id');
            $table->string('container_code',30)->nullable();
            $table->integer('vol');
            $table->decimal('eq_sub')->default(0);
            $table->decimal('soc')->default(0);
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('virtual_booking_container');
    }
}
