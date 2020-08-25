<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingContainerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_container_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('booking_id');
            $table->string('booking_no', 50);
            $table->foreignId('container_id')->nullable();
            $table->foreignId('booking_container_id');
            $table->string('container_no', 50)->nullable();
            $table->string('seal_no_1', 50)->nullable();
            $table->string('seal_no_2', 50)->nullable();
            $table->integer('package');
            $table->decimal('weight')->nullable();
            $table->decimal('vgm')->nullable();
            $table->decimal('measure');
            $table->string('st', 30)->nullable(); //[MT,OP,OC,VL,IC,ID]
            $table->boolean('rf')->default(false)->nullable();
            $table->boolean('scheduled')->default(false);
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
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
        Schema::dropIfExists('booking_container_details');
    }
}
