<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTopicAndTopicType extends Migration
{
    public function up()
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign('skills_topic_id_foreign');
            $table->dropColumn('topic_id');
        });

        Schema::table('graph_nodes', function (Blueprint $table) {
            $table->dropForeign('graph_nodes_topic_id_foreign');
            $table->dropColumn('topic_id');
        });

        Schema::drop('topics');
        Schema::drop('topic_types');

    }

    public function down()
    {
    }
}
