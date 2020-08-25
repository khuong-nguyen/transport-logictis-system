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
            $table->foreignId('container_id')->nullable();
            $table->foreignId('booking_container_id');
            $table->foreignId('booking_container_detail_id')->nullable();
            $table->string('container_no', 50)->nullable();
            $table->datetime('pickup_plan');
            $table->datetime('act_td')->nullable();
            $table->datetime('delivery_plan');
            $table->datetime('completed_date');
            $table->datetime('act_ta')->nullable();
            $table->foreignId('truck_id');
            $table->string('container_truck_code');
            $table->foreignId('driver_id');
            $table->string('driver_name',100);
            $table->integer('hour_number_alarm')->default(0);
            $table->string('schedule_status',20)->default('INPROCESS')->comment('[INPROCESS,DELAY,ONTIME]');
            $table->string('reason_delay',255)->nullable();
            $table->string('start_location',20)->default('SGN')->comment('[SGN, HN, HP, DN, KH, DN]');
            $table->string('pickup_address',255)->nullable();
            $table->string('end_location',20)->nullable()->comment('[SGN, HN, HP, DN, KH, DN]');
            $table->string('delivery_address',255)->nullable();
            $table->decimal('transport_cost',16,2)->default(0);
            $table->decimal('vgm',16,2)->default(0);
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
