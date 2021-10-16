<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('id')->unique()->index();
            $table->string('name');
            $table->double('min_size', 20, 16);
            $table->string('status', 25);
            $table->double('max_precision', 20, 16);
            $table->string('type', 25);
            $table->string('symbol', 25);
            $table->string('crypto_address_link')->nullable();
            $table->string('crypto_transaction_link')->nullable();
            $table->double('min_withdrawal_amount', 12, 2);
            $table->double('max_withdrawal_amount', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
