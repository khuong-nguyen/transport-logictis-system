<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_money', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('advance_money_code', 50)->unique();
            $table->string('advance_money_type', 30)->comment('BOOKING - OTHER]');
            $table->foreignId('advance_money_employee_id')->comment('employee_id');
            $table->foreignId('give_money_employee_id')->comment('employee_id');
            $table->string('advance_money_employee_code', 30)->comment('employee_code');
            $table->string('give_money_employee_code', 30)->comment('employee_code');
            $table->string('advance_money_employee_name', 200)->comment('employee_name');
            $table->string('give_money_employee_name', 200)->comment('employee_name');
            $table->decimal('advance_money');
            $table->decimal('refund_money')->default(0);
            $table->string('advance_money_reason',255);
            $table->string('refund_money_status')->default('EMPTY')->comment('[EMPTY,PARTIAL,FULL]');
            $table->foreignId('booking_id')->nullable()->comment('booking table');
            $table->string('booking_no',100)->nullable()->comment('booking table');
            $table->foreignId('approved_by')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('fixed_asset');
    }
}
