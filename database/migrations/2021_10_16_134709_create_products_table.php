<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->unique()->index();
            $table->string('base_currency', 10)->index();
            $table->string('quote_currency', 10)->index();
            $table->double('base_min_size', 20, 12);
            $table->double('base_max_size', 20, 12);
            $table->double('quote_increment', 20, 12);
            $table->double('base_increment', 20, 12);
            $table->string('display_name');
            $table->double('min_market_funds', 20, 12);
            $table->double('max_market_funds', 20, 12);
            $table->boolean('margin_enabled');
            $table->boolean('fx_stablecoin');
            $table->double('max_slippage_percentage', 20, 12);
            $table->boolean('post_only');
            $table->boolean('limit_only');
            $table->boolean('cancel_only');
            $table->boolean('trading_disabled');
            $table->string('status', 25);
            $table->string('status_message');
            $table->boolean('auction_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
