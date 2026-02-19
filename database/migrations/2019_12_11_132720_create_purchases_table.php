<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purchase_id'); // unique name
            $table->string('date'); // date
            $table->string('weight');
            $table->string('amount');
            $table->string('total');
            $table->integer('vegetable_id')->unsigned(); // kun vegetable kineko
            $table->foreign('vegetable_id')->references('id')->on('vegetables');
            $table->integer('purchase_user_id')->unsigned(); // kasbata kineko
            $table->foreign('purchase_user_id')->references('id')->on('users');
            $table->integer('category_id')->unsigned(); // kun category ko
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('unit_id')->unsigned(); // kun unit ko
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('is_active')->default(1); // status
            $table->integer('is_out')->default(0); // default not out
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
        Schema::dropIfExists('purchases');
    }
}
