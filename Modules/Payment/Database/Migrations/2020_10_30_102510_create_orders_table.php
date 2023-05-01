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
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('record_id')->nullable();
            $table->foreign('record_id')->references('id')->on('records');
            $table->integer('payment_id')->nullable();
            $table->integer('payment_amount')->nullable();
            $table->string('payment_user_contact_email')->nullable();
            $table->string('payment_user_contact_phone', 20)->nullable();
            $table->string('payment_card_pan', 50)->nullable();
            $table->string('payment_card_exp', 50)->nullable();
            $table->string('payment_card_owner', 50)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->text('payment_description')->nullable();
            $table->string('payment_salt')->nullable();
            $table->string('payment_sig')->nullable();
            $table->text('payment_link')->nullable();
            $table->json('payment_json')->nullable();
            $table->boolean('late_payment_flag')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
