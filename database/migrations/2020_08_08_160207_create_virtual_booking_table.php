<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_booking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('virtual_booking_no')->unique();
            $table->string('tvvd', 50)->nullable();
            $table->string('por_1', 30);
            $table->string('por_2', 30)->nullable();
            $table->string('pol_1', 30);
            $table->string('pol_2', 30)->nullable();
            $table->string('pod_1', 30);
            $table->string('pod_2', 30);
            $table->string('del_1', 30);
            $table->string('del_2', 30)->nullable();
            $table->string('r_d_term_1', 30)->nullable();
            $table->string('r_d_term_2', 30)->nullable();
            $table->string('b_l_no', 30)->nullable();
            $table->boolean('si');
            $table->boolean('brd');
            $table->boolean('fh');
            $table->string('cmdt_1', 30);
            $table->string('cmdt_2', 30)->nullable();
            $table->decimal('weight');
            $table->string('unit', 10);
            $table->string('lofc_1', 30)->nullable();
            $table->string('lofc_2', 30);
            $table->date('sailling_due_date');
            $table->string('pick_up_cy', 50)->nullable();
            $table->date('pick_up_dt')->nullable();
            $table->string('full_return_cy', 50)->nullable();
            $table->string('bkg_contact_name', 100)->nullable();
            $table->string('bkg_contact_email', 100)->nullable();
            $table->string('bkg_contact_tel', 30)->nullable();
            $table->text('ext_remark')->nullable();
            $table->text('int_remark')->nullable();
            $table->foreignId('shipper_id');
            $table->foreignId('forwarder_id');
            $table->foreignId('consignee_id');
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
        Schema::dropIfExists('virtual_booking');
    }
}
