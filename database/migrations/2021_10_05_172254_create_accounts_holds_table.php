<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsHoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_holds', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('account_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->double('amount', 20, 16);
            $table->string('type', 25);
            $table->uuid('ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_holds');
    }
}
