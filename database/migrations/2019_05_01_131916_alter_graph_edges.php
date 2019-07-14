<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGraphEdges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graph_edges', function (Blueprint $table) {
            $table->renameColumn('topic_from_id', 'node_from_id');
            $table->renameColumn('topic_to_id', 'node_to_id');

            $table->dropForeign('graph_edges_topic_from_id_foreign');
            $table->dropForeign('graph_edges_topic_to_id_foreign');

            $table->foreign('node_from_id')->references('id')->on('graph_nodes');
            $table->foreign('node_to_id')->references('id')->on('graph_nodes');

            $table->float('position_x')->default(100)->nullable();
            $table->float('position_y')->default(100)->nullable();
            $table->string('color', 10)->default('#000000')->nullable();
            $table->string('pattern', 40)->default('solid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graph_edges', function (Blueprint $table) {
            $table->renameColumn('node_from_id', 'topic_from_id');
            $table->renameColumn('node_to_id', 'topic_to_id');

            $table->foreign('topic_from_id')->references('id')->on('topics');
            $table->foreign('topic_to_id')->references('id')->on('topics');

            $table->dropForeign('graph_edges_node_from_id_foreign');
            $table->dropForeign('graph_edges_node_to_id_foreign');

            $table->dropColumn('position_x');
            $table->dropColumn('position_y');
            $table->dropColumn('color');
            $table->dropColumn('pattern');
        });
    }
}
