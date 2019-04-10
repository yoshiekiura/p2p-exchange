<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRippleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ripple_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->integer('wallet_id')->unsigned()->nullable();
            $table->foreign('wallet_id')->references('id')
                ->on('ripple_wallets')->onDelete('cascade');
            $table->enum('state', [
                'unconfirmed', 'confirmed', 'pendingApproval',
                'rejected', 'removed', 'signed'
            ]);
            $table->enum('type', ['send', 'receive']);
            $table->bigInteger('value')->nullable();
            $table->longText('hash')->nullable();
            $table->integer('confirmations')->nullable();
            $table->timestamp('date')->nullable();
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
        Schema::dropIfExists('ripple_transactions');
    }
}
