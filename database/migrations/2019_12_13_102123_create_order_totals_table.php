<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_totals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bill_id')->unique(); // same on orders
            $table->string('detail')->nullable();
            $table->string('total');
            $table->string('discount')->default(0);
            $table->string('due')->default(0);
            $table->string('paid')->default(0);
            $table->string('return_back')->default(0);
            $table->string('grand_total')->default(0);
            $table->integer('customer_id')->unsigned(); // reference
            $table->foreign('customer_id')->references('id')->on('users');
            $table->integer('is_due')->default(0); // 0 no due, 1 due, 2 paid by customer
            $table->string('date');
            $table->integer('created_by')->nullable(); // confirmed by
            $table->string('confirmed_at')->nullable(); // confirmed at
            $table->integer('is_seen')->default(0); // seen by branch
            $table->integer('is_confirmed')->default(0); // confirmed by branch
            $table->integer('is_deliverd')->default(0); // delivered by branch
            $table->integer('order_by')->unsigned(); // by order by
            $table->foreign('order_by')->references('id')->on('users');
            $table->text('raw_data')->nullable();
            $table->integer('bill_type')->default(0); // 0 by manager 1 is online
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
        Schema::dropIfExists('order_totals');
    }
}
