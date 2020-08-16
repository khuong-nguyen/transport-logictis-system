<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_name', 200);
            $table->string('employee_address', 300)->nullable();
            $table->string('employee_code', 50)->unique();
            $table->string('email', 100)->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('tax_code', 50)->nullable();
            $table->string('country_code', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->string('department_code', 30)->comment('[DRIVER - HR - TRANSPORT - ACCOUNTING]');
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
        Schema::dropIfExists('employee');
    }
}
