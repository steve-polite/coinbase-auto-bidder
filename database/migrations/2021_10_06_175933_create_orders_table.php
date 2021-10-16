<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->uuid('id');
            $table->double('price', 20, 16)->nullable();
            $table->double('size', 20, 16)->nullable();
            $table->string('product_id', 25);
            $table->uuid('profile_id');
            $table->string('side', 25);
            $table->double('funds', 20, 16)->nullable();
            $table->double('specified_funds', 20, 16)->nullable();
            $table->string('type', 25);
            $table->string('time_in_force', 5)->nullable();
            $table->boolean('post_only');
            $table->dateTime('created_at');
            $table->dateTime('done_at');
            $table->string('done_reason', 25);
            $table->double('fill_fees', 20, 16);
            $table->double('filled_size', 20, 16);
            $table->double('executed_value', 20, 16);
            $table->string('status', 25);
            $table->boolean('settled');
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
