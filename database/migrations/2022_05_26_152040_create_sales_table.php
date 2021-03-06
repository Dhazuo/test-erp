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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->unsignedBigInteger('seller_id');

            $table->string('seller_name');
            $table->string('customer');
            $table->integer('total_stock');
            $table->float('total_price');
            $table->enum('status', ['active', 'pending_to_delete'])->default('active');

            $table->foreign('seller_id')->references('id')->on('users');
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
        Schema::dropIfExists('sales');
    }
};
