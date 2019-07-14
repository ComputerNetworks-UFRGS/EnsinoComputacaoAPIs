<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreataTableEdges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graph_edges', function (Blueprint $table) {
            $table->unsignedInteger('graph_id');
            $table->unsignedInteger('topic_from_id');
            $table->unsignedInteger('topic_to_id');
            $table->timestamps();

            $table->primary(['graph_id', 'topic_from_id', 'topic_to_id']);

            $table->foreign('graph_id')->references('id')->on('graphs');
            $table->foreign('topic_from_id')->references('id')->on('topics');
            $table->foreign('topic_to_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graph_edges');
    }
}
