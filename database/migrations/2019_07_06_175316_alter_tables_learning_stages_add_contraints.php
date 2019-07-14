<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesLearningStagesAddContraints extends Migration
{
    public function up()
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign('skills_learning_stage_id_foreign');
            $table->dropColumn('learning_stage_id');
            $table->unsignedInteger('learning_object_id');
            $table->foreign('learning_object_id')->references('id')->on('learning_objects');
        });
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->unsignedInteger('learning_stage_id');
            $table->foreign('learning_stage_id')->references('id')->on('learning_stages');
        });
        Schema::table('graph_nodes', function (Blueprint $table) {
            $table->unsignedInteger('learning_object_id');
            $table->foreign('learning_object_id')->references('id')->on('learning_objects');
        });

    }

    public function down()
    {
    }
}
