<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitHasConvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_has_converts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_rate');
            $table->integer('unit_id')->unsigned(); //
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('convert_rate');
            $table->integer('convert_unit_id')->unsigned(); //
            $table->foreign('convert_unit_id')->references('id')->on('units');
            $table->integer('created_by')->unsigned(); //
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
        Schema::dropIfExists('unit_has_converts');
    }
}
