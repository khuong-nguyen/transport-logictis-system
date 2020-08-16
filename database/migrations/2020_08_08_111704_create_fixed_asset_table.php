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
        Schema::create('fixed_asset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fixed_asset_name', 200);
            $table->string('manuafacture', 300)->nullable();
            $table->string('fixed_asset_code', 50)->unique();
            $table->string('desc', 255)->nullable();
            $table->string('fixed_asset_type', 30)->comment('TRUCK - MOOC - RO-MOOC]');
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
