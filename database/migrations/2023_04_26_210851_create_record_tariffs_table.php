<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id');
            $table->foreign('record_id')->references('id')->on('records');
            $table->unsignedBigInteger('tariff_id');
            $table->foreign('tariff_id')->references('id')->on('tariffs');
            $table->decimal('price');
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
        Schema::dropIfExists('record_tariffs');
    }
};
