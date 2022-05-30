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
        Schema::create('pending_to_delete', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('petitioner_id');
            $table->string('petitioner_name');
            $table->unsignedBigInteger('sale_id');
            $table->string('sale_token');

            $table->foreign('petitioner_id')->references('id')->on('users');
            $table->foreign('sale_id')->references('id')->on('sales');
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
        Schema::dropIfExists('pending_to_delete');
    }
};
