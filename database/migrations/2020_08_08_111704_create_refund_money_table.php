<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_money', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('refund_money_code', 50)->unique();
            $table->string('refund_money_type', 30)->comment('BOOKING - OTHER]');
            $table->foreignId('refund_money_employee_id')->comment('employee_id');
            $table->foreignId('collect_money_employee_id')->comment('employee_id');
            $table->string('refund_money_employee_code', 30)->comment('employee_code');
            $table->string('collect_money_employee_code', 30)->comment('employee_code');
            $table->string('refund_money_employee_name', 200)->comment('employee_name');
            $table->string('collect_money_employee_name', 200)->comment('employee_name');
            $table->timestamp('refund_money_date');
            $table->decimal('refund_money',16.2)->default(0)->nullable();
            $table->decimal('balance_money',16,2)->default(0)->nullable();
            $table->string('invoice_attach_file', 200)->nullable();
            $table->string('refund_money_reason',255)->nullable();
            $table->foreignId('advance_money_id')->nullable()->comment('advance_money table');
            $table->string('advance_money_code', 50)->unique();
            $table->foreignId('booking_id')->nullable()->comment('booking table');
            $table->string('booking_no',100)->nullable()->comment('booking table');
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
        Schema::dropIfExists('refund_money');
    }
}
