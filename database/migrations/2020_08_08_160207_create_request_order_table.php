<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_order_no')->unique();
            $table->string('tvvd', 50)->nullable();
            $table->string('por_1', 30);
            $table->string('por_2', 30)->nullable();
            $table->string('pol_1', 30);
            $table->string('pol_2', 30)->nullable();
            $table->string('pod_1', 30);
            $table->string('pod_2', 30)->nullable();
            $table->string('del_1', 30);
            $table->string('del_2', 30)->nullable();
            $table->string('r_d_term_1', 30)->nullable();
            $table->string('r_d_term_2', 30)->nullable();
            $table->string('b_l_no', 30)->nullable();
            $table->boolean('si')->default(false);
            $table->boolean('brd')->default(false);
            $table->boolean('fh')->default(false);
            $table->string('cmdt_1', 30)->nullable();
            $table->string('cmdt_2', 30)->nullable();
            $table->decimal('weight',16,2)->default(0)->nullable();
            $table->string('unit', 10);
            $table->string('lofc_1', 30)->nullable();
            $table->string('lofc_2', 30)->nullable();
            $table->date('sailling_due_date');
            $table->string('pick_up_cy', 50)->nullable();
            $table->date('pick_up_dt')->nullable();
            $table->string('full_return_cy', 50)->nullable();
            $table->string('bkg_contact_name', 100)->nullable();
            $table->string('bkg_contact_email', 100)->nullable();
            $table->string('bkg_contact_tel', 30)->nullable();
            $table->text('ext_remark')->nullable();
            $table->text('int_remark')->nullable();
            $table->string('booking_status',8)->default('ORDER')->comment('[ORDER,VIRTUAL,BOOKING]');
            $table->string('booking_type',8)->default('IMPORT')->comment('[IMPORT, EXPORT]');
            $table->foreignId('shipper_id')->nullable();
            $table->foreignId('forwarder_id')->nullable();
            $table->foreignId('consignee_id')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->string('schedule_status')->default('EMPTY')->comment('[EMPTY,PARTIAL,FULL]');
            $table->string('pickup_address', 300)->nullable();
            $table->string('delivery_address', 300)->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->datetime('closing_time')->nullable();
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
        Schema::dropIfExists('request_order');
    }
}