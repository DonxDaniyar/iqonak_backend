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
        Schema::create('record_scans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id');
            $table->foreign('record_id')->references('id')->on('records');
            $table->unsignedBigInteger('security_id');
            $table->foreign('security_id')->references('id')->on('users');
            $table->dateTime('scanned_at');
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
        Schema::dropIfExists('record_scans');
    }
};
