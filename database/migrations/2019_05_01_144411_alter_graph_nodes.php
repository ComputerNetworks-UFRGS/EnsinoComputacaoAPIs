<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGraphNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graph_nodes', function (Blueprint $table) {
            $table->integer('type')->default(1)->nullable();
            $table->unsignedInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graph_nodes', function (Blueprint $table) {
            $table->dropForeign('graph_nodes_topic_id_foreign');

            $table->dropColumn('type');
            $table->dropColumn('topic_id');
        });
    }
}
