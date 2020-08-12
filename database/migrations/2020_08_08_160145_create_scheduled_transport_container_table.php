<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledTransportContainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_transport_container', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('booking_id');
            $table->string('booking_no', 50);
            $table->foreignId('container_id');
            $table->foreignId('booking_container_id');
            $table->foreignId('booking_container_detail_id');
            $table->string('container_no', 50);
            $table->datetime('etd');
            $table->datetime('act_td')->nullable();
            $table->datetime('eta');
            $table->datetime('act_ta')->nullable();
            $table->foreignId('container_truck_id');
            $table->foreignId('container_truck_code');
            $table->foreignId('driver_id');
            $table->string('driver_name');
            $table->integer('hour_number_alarm')->default(0);
            $table->string('schedule_status')->default('INPROCESS');//[INPROCESS,DELAY,ONTIME]
            $table->string('reason_delay',255)->nullable();
            $table->string('start_location',20)->default('SGN');//[SGN, HN, HP, DN, KH, DN]
            $table->string('start_address',255)->nullable();
            $table->string('end_location',20)->nullable();//[SGN, HN, HP, DN, KH, DN]
            $table->string('end_address',255)->nullable();
            $table->decimal('vgm')->default(0);
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
        Schema::dropIfExists('scheduled_transport_container');
    }
}
