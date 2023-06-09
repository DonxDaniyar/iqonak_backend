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
        Schema::table('records', function (Blueprint $table) {
            $table->dateTime('scanned_at')->nullable();
            $table->uuid('record_uuid')->nullable();
            $table->unsignedBigInteger('checkpoint_id')->nullable();
            $table->foreign('checkpoint_id')->references('id')->on('checkpoints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('scanned_at');
            $table->dropColumn('record_uuid');
            $table->dropForeign(['checkpoint_id']);
            $table->dropColumn('checkpoint_id');
        });
    }
};
