<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseHasManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_has_manages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->unsigned(); // purchase ko manage
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->string('weight'); // 1 kg Rs 20 
            $table->integer('unit_id')->unsigned(); // kun unit ko
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('rate');
            $table->string('date',50); // date
            $table->integer('is_active')->default(1); // status
            $table->integer('created_by')->unsigned(); // who created this item
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('purchase_has_manages');
    }
}
