<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_movements', function (Blueprint $table) {
            $table->bigInteger("id")->unsigned()->unique();
            $table->uuid('account_id');
            $table->double("amount", 20, 16);
            $table->double("balance", 20, 16);
            $table->dateTime('created_at');
            $table->string('type', 25);
            $table->uuid('order_id')->nullable();
            $table->string('product_id', 25)->nullable();
            $table->bigInteger('trade_id')->unsigned()->nullable();
            $table->uuid('transfer_id')->nullable();
            $table->string('transfer_type', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_movements');
    }
}
