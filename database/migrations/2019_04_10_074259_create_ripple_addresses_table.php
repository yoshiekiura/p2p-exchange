<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRippleAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ripple_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('address');
            $table->string('message');
            $table->string('label')->nullable();
            $table->integer('wallet_id')->unsigned()->nullable();
            $table->foreign('wallet_id')->references('id')
                ->on('ripple_wallets')->onDelete('cascade');
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
        Schema::dropIfExists('ripple_addresses');
    }
}
