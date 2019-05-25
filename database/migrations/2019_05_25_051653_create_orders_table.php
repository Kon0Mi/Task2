<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('carid')->unsigned();
            $table->integer('workerid')->unsigned();
            $table->date('begin');
            $table->date('end');
            $table->integer('hourwork');
            $table->foreign('carid')->references('id')->on('car');
            $table->foreign('workerid')->references('id')->on('worker');
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
