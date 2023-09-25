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
        Schema::create('device_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->string('latitude', 50); 
            $table->string('longitude', 50);
            $table->string('temperature', 50)->nullable();
            $table->string('salinity', 50)->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_locations');
    }
};
