<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_store', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('drug_id');
            $table->bigInteger('storekeeper_id');
            $table->string('previous_stock');
            $table->string('current_stock');
            $table->string('qty_in');
            $table->string('qty_out');
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
        Schema::dropIfExists('drug_store');
    }
}
