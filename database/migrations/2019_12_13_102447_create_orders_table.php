<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->unsigned(); // purchase ko lagi
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->integer('purchase_manage_id')->unsigned(); // for kun date ko bhai
            $table->foreign('purchase_manage_id')->references('id')->on('purchase_has_manages');
            $table->integer('order_total_id')->unsigned(); // reference
            $table->foreign('order_total_id')->references('id')->on('order_totals');
            $table->integer('vegetable_id')->unsigned(); // reference
            $table->foreign('vegetable_id')->references('id')->on('vegetables');
            $table->integer('user_id')->unsigned(); // sold user
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('bill_id');
            $table->string('quantity'); // kati
            $table->string('rate'); // paisa ko
            $table->string('total'); // jamma
            $table->integer('unit_id')->unsigned(); //
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('calc_qty');// for calculation stock
            $table->integer('calc_unit_id')->unsigned(); // for calculation stock
            $table->foreign('calc_unit_id')->references('id')->on('units');
            $table->string('date');
            $table->integer('is_cancle')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('order_by')->unsigned(); //
            $table->foreign('order_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
