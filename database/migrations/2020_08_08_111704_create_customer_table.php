<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_legal_english_name', 200);
            $table->string('customer_language_name', 200)->nullable();
            $table->string('customer_address', 300)->nullable();
            $table->string('customer_store_address1', 300)->nullable();
            $table->string('customer_store_address2', 300)->nullable();
            $table->string('customer_store_address3', 300)->nullable();
            $table->string('customer_code', 50)->unique();
            $table->string('email', 100);
            $table->string('fax', 30)->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('tax_code', 50)->nullable();
            $table->string('country_code', 30);
            $table->string('city', 30);
            $table->string('location_code', 50);
            $table->string('zip_code', 50)->nullable();
            $table->string('post_office_box', 300)->nullable();
            $table->string('sale_office_code', 50);
            $table->string('sale_rep_code', 50);
            $table->string('customer_type', 30)->default('01')->comment('[01,02,03]');
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
        Schema::dropIfExists('customer');
    }
}
