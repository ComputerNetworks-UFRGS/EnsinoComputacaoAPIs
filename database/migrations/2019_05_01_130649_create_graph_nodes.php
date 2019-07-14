<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graph_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->integer('width')->default(200)->nullable();
            $table->integer('height')->default(100)->nullable();
            $table->float('position_x')->default(100)->nullable();
            $table->float('position_y')->default(100)->nullable();
            $table->string('shape', 40)->default('')->nullable();
            $table->unsignedInteger('graph_id');

            $table->foreign('graph_id')->references('id')->on('graphs');
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
        Schema::dropIfExists('graph_nodes');
    }
}
