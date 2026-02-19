<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_no');
            $table->integer('branch_id')->unsigned(); 
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->integer('address_id')->unsigned(); 
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->integer('user_type')->default(3); // 1 for admin, 2 for manager ie branch, 3 for user
            $table->integer('type')->default(1); // 0 for others, 1 for creditor, 2 for debtor,
            $table->string('secondary_addess')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('created_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
