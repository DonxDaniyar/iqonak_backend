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
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->unsignedBigInteger('visit_purpose_id')->nullable();
            $table->foreign('visit_purpose_id')->references('id')->on('visit_purposes');
            $table->unsignedBigInteger('place_of_direction_id')->nullable();
            $table->foreign('place_of_direction_id')->references('id')->on('place_of_directions');
            $table->unsignedBigInteger('payment_note_id')->nullable();
            $table->foreign('payment_note_id')->references('id')->on('payment_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
